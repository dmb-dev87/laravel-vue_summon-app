<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;

use App\Summon;
use App\Location;
use App\Group;
use App\Contact;
use App\History;

use App\Mail\SummonMail;

use Carbon\Carbon;

class SummonsController extends Controller
{
    //
    public function getList()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $summons = Summon::where('user_id', '=', $userId)
                        ->where('del_flag', '=', '0')
                        ->get();

        foreach($summons as $summon)
        {
            $summon->location_name = $summon->location->name;
            $summon->end_date_str = date("d/m/Y h:i A", strtotime($summon->end_date));
            $summon->start_date_str = date("d/m/Y h:i A", strtotime($summon->start_date));
        }

        return $summons;
    }

    public function getLocationOptions()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $locations = Location::where('user_id', '=', $userId)
                            ->where('del_flag', '=', '0')
                            ->get();

        $location_options = array();

        foreach($locations as $location)
        {
            array_push($location_options, ['value' => $location['id'], 'label' => $location['name']]);
        }

        return $location_options;
    }

    public function getGroupOptions()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $groups = Group::where('user_id', '=', $userId)
                        ->where('del_flag', '=', '0')
                        ->get();

        $group_options = array();

        foreach($groups as $group)
        {
            array_push($group_options, ['value' => $group['id'], 'label' => $group['name']]);
        }

        return $group_options;
    }

    public function getContactOptions()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $contacts = Contact::where('user_id', '=', $userId)
                            ->where('del_flag', '=', '0')
                            ->get();

        $contact_options = array();

        foreach($contacts as $contact)
        {
            array_push($contact_options, ['value' => $contact['id'], 'label' => $contact['name']]);
        }

        return $contact_options;
    }

    public function recordVoicemail()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $receiver_number = $user->phone_number1;
        $receiver_number = "+13152150723";

        // $response_url = url('/').'/api/summons/voice/response';
        $response_url = getenv("APP_URL").'/api/summons/voice/response';

        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");

        $twilio = new Client($account_sid, $auth_token);
        $call = $twilio->calls->create(
            $receiver_number,
            $twilio_number,
            array("url" => $response_url)
        );
    }

    public function responseVoiceCall(Request $request)
    {
        $response = new VoiceResponse();

        $save_url = url('/').'/api/summons/voice/save';
        // $save_url = getenv("APP_URL").'/api/summons/voice/save';

        $response->say('Please leave a message at the beep. Press the star key when finished');
        $response->record(['maxLength' => 30, 'finishOnKey' => '*', 'action' => $save_url, 'method' => 'GET']);
        $response->say('I did not receive a recording');

        echo $response;
    }

    public function saveVoicemail(Request $request)
    {
        $url = $request->RecordingUrl;
        $img = $request->CallSid . "_" . $request->RecordingSid . ".wav";
        file_put_contents($img, file_get_contents($url));
    }

    public function createSummon(Request $request)
    {
        $item = $request->input('summon');

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            $summon = new Summon;

            $summon->user_id = $userId;
            $summon->location_id = $item['sel_location']['value'];

            $contact_list = "";
            foreach($item['sel_contacts'] as $contact)
            {
                $contact_list .= $contact['value'].",";
            }
            $contact_list = rtrim($contact_list, ",");
            $summon->contact_list = $contact_list;

            $group_list = "";
            foreach($item['sel_groups'] as $group)
            {
                $group_list .= $group['value'].",";
            }
            $group_list = rtrim($group_list, ",");
            $summon->group_list = $group_list;

            $summon->start_date = Carbon::parse($item['start_date']);
            $summon->end_date = Carbon::parse($item['end_date']);
            // $summon->end_date = Carbon::createFromFormat('d/m/Y h:i A', $item['end_date']);
            $summon->message = $item['message'];

            $summon->is_sent = false;

            $summon->save();

            $this->create_init_histories($summon);

            $summon->location_name = $summon->location->name;
            $summon->end_date_str = date("d/m/Y h:i A", strtotime($summon->end_date));
            $summon->start_date_str = date("d/m/Y h:i A", strtotime($summon->start_date));

            return $summon;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function sendSummonMessage($summon_id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $summon = Summon::find($summon_id);

        $location_name = $summon->location->name;
        $due_date_str = date("d/m/Y h:i A", strtotime($summon->end_date));

        $message = 'Message: '.$summon->message.' Location: '.$location_name.' Due Datetime: '.$due_date_str;

        $contact_ids = $this->get_contact_ids($summon);

        try
        {
            foreach($contact_ids as $contact_id)
            {
                $contact = Contact::find($contact_id);

                if ($contact['email'] && $contact['email_val1'])
                {
                    $this->send_email($contact['email'], $contact, $summon, $user, History::MAIN_TYPE_EMAIL1);
                }

                if ($contact['email2'] && $contact['email_val2'])
                {
                    $this->send_email($contact['email2'], $contact, $summon, $user, History::MAIN_TYPE_EMAIL2);
                }

                if ($contact['phone_number1'])
                {
                    if ($contact['phone_sms1'])
                    {
                        $this->send_sms($contact['phone_number1'], $message, $summon_id, $user->id, $contact_id, History::MAIN_TYPE_PHONE1);
                    }
                    if ($contact['phone_whatsapp1'])
                    {
                        $this->send_whatsapp($contact['phone_number1'], $message, $summon_id, $user->id, $contact_id, History::MAIN_TYPE_PHONE1);
                    }
                }

                if ($contact['phone_number2'])
                {
                    if ($contact['phone_sms2'])
                    {
                        $this->send_sms($contact['phone_number2'], $message, $summon_id, $user->id, $contact_id, History::MAIN_TYPE_PHONE2);
                    }
                    if ($contact['phone_whatsapp2'])
                    {
                        $this->send_whatsapp($contact['phone_number2'], $message, $summon_id, $user->id, $contact_id, History::MAIN_TYPE_PHONE2);
                    }
                }

                if ($contact['phone_nmuber2'])
                {
                    if ($contact['phone_sms3'])
                    {
                        $this->send_sms($contact['phone_number3'], $message, $summon_id, $user->id, $contact_id, History::MAIN_TYPE_PHONE3);
                    }
                    if ($contact['phone_whatsapp3'])
                    {
                        $this->send_whatsapp($contact['phone_number3'], $message, $summon_id, $user->id, $contact_id, History::MAIN_TYPE_PHONE3);
                    }
                }
            }

            $arr = array("id" => $summon_id, "sent" => true, "message" => "Summon message send successfully.");
            $summon->is_sent = true;            
        }
        catch(Exception $ex)
        {
            $msg = $ex->getMessage();
            $arr = array("id" => $summon_id, "sent" => false, "message" => $msg);
            $summon->is_sent = false;            
        }

        $summon->update();

        return $arr;
    }

    protected function send_sms($phone_number, $message, $summon_id, $user_id, $contact_id, $main_type)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");

        try
        {
            $client = new Client($account_sid, $auth_token);
        
            $client->messages->create($phone_number, 
                    ['from' => $twilio_number, 'body' => $message]);

            $status = History::STATUS_SEND;
        }
        catch(Exception $ex)
        {
            $status = History::STATUS_FAILED;
        }

        $history = History::where('user_id', '=', $user_id)
                ->where('contact_id', '=', $contact_id)
                ->where('summon_id', '=', $summon_id)
                ->where('main_type', '=', $main_type)
                ->where('sub_type', '=', History::SUB_TYPE_SMS)
                ->update(['status' => $status]);
    }

    protected function send_whatsapp($phone_number, $message, $summon_id, $user_id, $contact_id, $main_type)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");

        $twilio = new Client($account_sid, $auth_token);

        try
        {
            $message = $twilio->messages->create("whatsapp:".$phone_number, // to
                ["from" => "whatsapp:".$user->phone_number1, "body" => $message]);

            $status = History::STATUS_UNREAD;
        }
        catch(Exception $ex)
        {
            $status = History::STATUS_FAILED;
        }

        $history = History::where('user_id', '=', $user_id)
                ->where('contact_id', '=', $contact_id)
                ->where('summon_id', '=', $summon_id)
                ->where('main_type', '=', $main_type)
                ->where('sub_type', '=', History::SUB_TYPE_WHATSAPP)
                ->update(['status' => $status]);
    }

    protected function send_email($email_addr, $contact, $summon, $user, $main_type)
    {
        $history = History::where('user_id', '=', $user['id'])
                ->where('contact_id', '=', $contact['id'])
                ->where('summon_id', '=', $summon['id'])
                ->where('main_type', '=', $main_type)
                ->first();

        try
        {
            Mail::to($email_addr)->send(new SummonMail($contact, $summon, $user, $history['id']));
            $status = History::STATUS_UNREAD;
        }
        catch(Exception $ex)
        {
            $status = History::STATUS_FAILED;
        }
        
        $history->update(['status' => $status]);
    }

    protected function get_contact_ids($summon)
    {  
        $contact_ids = array();

        if ($summon->contact_list)
        {
            $contact_ids = explode(',', $summon->contact_list);            
        }

        if ($summon->group_list)
        {
            $group_ids = explode(',', $summon->group_list);

            foreach($group_ids as $group_id)
            {
                $group_contacts = Group::find($group_id)->contact_list;
                $group_contact_ids = explode(',', $group_contacts);

                foreach($group_contact_ids as $group_contact_id)
                {
                    if (in_array($group_contact_id, $contact_ids) == false)
                    {
                        array_push($contact_ids, $group_contact_id);
                    }                
                }
            }
        }

        return $contact_ids;
    }

    protected function create_init_histories($summon)
    {
        $contact_ids = $this->get_contact_ids($summon);

        foreach($contact_ids as $contact_id)
        {
            $contact = Contact::find($contact_id);

            if ($contact['email'] && $contact['email_val1']) 
            {
                $this->create_history(
                    $summon->id, 
                    $summon->user_id, 
                    $contact_id, 
                    History::MAIN_TYPE_EMAIL1, 
                    null, 
                    History::STATUS_UNSEND);
            }

            if ($contact['email1'] && $contact['email_val2'])
            {
                $this->create_history(
                    $summon->id, 
                    $summon->user_id, 
                    $contact_id, 
                    History::MAIN_TYPE_EMAIL2, 
                    null, 
                    History::STATUS_UNSEND);
            }

            if ($contact['phone_number1'])
            {
                if ($contact['phone_voice1'])
                {
                    $this->create_history(
                        $summon->id, 
                        $summon->user_id, 
                        $contact_id, 
                        History::MAIN_TYPE_PHONE1, 
                        History::SUB_TYPE_VOICE, 
                        History::STATUS_UNSEND);
                }

                if ($contact['phone_sms1'])
                {
                    $this->create_history(
                        $summon->id, 
                        $summon->user_id, 
                        $contact_id, 
                        History::MAIN_TYPE_PHONE1, 
                        History::SUB_TYPE_SMS, 
                        History::STATUS_UNSEND);
                }

                if ($contact['phone_whatsapp1'])
                {
                    $this->create_history(
                        $summon->id, 
                        $summon->user_id, 
                        $contact_id, 
                        History::MAIN_TYPE_PHONE1, 
                        History::SUB_TYPE_WHATSAPP, 
                        History::STATUS_UNSEND);
                }
            }

            if ($contact['phone_number2'])
            {
                if ($contact['phone_voice2'])
                {
                    $this->create_history(
                        $summon->id, 
                        $summon->user_id, 
                        $contact_id, 
                        History::MAIN_TYPE_PHONE2,
                        History::SUB_TYPE_VOICE, 
                        History::STATUS_UNSEND);
                }

                if ($contact['phone_sms2'])
                {
                    $this->create_history(
                        $summon->id, 
                        $summon->user_id, 
                        $contact_id, 
                        History::MAIN_TYPE_PHONE2, 
                        History::SUB_TYPE_SMS, 
                        History::STATUS_UNSEND);
                }

                if ($contact['phone_whatsapp2'])
                {
                    $this->create_history(
                        $summon->id, 
                        $summon->user_id, 
                        $contact_id, 
                        History::MAIN_TYPE_PHONE2, 
                        History::SUB_TYPE_WHATSAPP, 
                        History::STATUS_UNSEND);
                }
            }

            if ($contact['phone_number3'])
            {
                if ($contact['phone_voice3'])
                {
                    $this->create_history(
                        $summon->id, 
                        $summon->user_id, 
                        $contact_id, 
                        History::MAIN_TYPE_PHONE3, 
                        History::SUB_TYPE_VOICE, 
                        History::STATUS_UNSEND);
                }

                if ($contact['phone_sms3'])
                {
                    $this->create_history(
                        $summon->id, 
                        $summon->user_id, 
                        $contact_id, 
                        History::MAIN_TYPE_PHONE3, 
                        History::SUB_TYPE_SMS, 
                        History::STATUS_UNSEND);
                }

                if ($contact['phone_whatsapp3'])
                {
                    $this->create_history(
                        $summon->id, 
                        $summon->user_id, 
                        $contact_id, 
                        History::MAIN_TYPE_PHONE3, 
                        History::SUB_TYPE_WHATSAPP, 
                        History::STATUS_UNSEND);
                }
            }
        }
    }

    protected function create_history($summon_id, $user_id, $contact_id, $main_type, $sub_type, $status)
    {
        $history = new History;

        $history->summon_id = $summon_id;
        $history->user_id = $user_id;
        $history->contact_id = $contact_id;
        $history->main_type = $main_type;
        $history->sub_type = $sub_type;
        $history->status = History::STATUS_UNSEND;

        $history->save();

        return $history;
    }

    public function getHistories($summon_id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $summon = Summon::find($summon_id);
        
        $contact_ids = $this->get_contact_ids($summon);

        $history_details = array();

        foreach($contact_ids as $contact_id)
        {
            $contact = Contact::find($contact_id);

            $history_detail = $this->get_history_detail($summon_id, $userId, $contact);
            array_push($history_details, ['contact_name' => $contact->name, 'history_detail' => $history_detail]);
        }

        return $history_details;
    }

    protected function get_history_detail($summon_id, $user_id, $contact)
    {
        $contact_id = $contact->id;

        $history_detail = array();

        if ($contact['email'] && $contact['email_val1'])
        {
            $history = History::where('summon_id', '=', $summon_id)
                            ->where('user_id', '=', $user_id)
                            ->where('contact_id', '=', $contact_id)
                            ->where('main_type', '=', History::MAIN_TYPE_EMAIL1)
                            ->first();

            $email1_history = ['type' => 'Email1', 'email' => $history['status']];
            array_push($history_detail, $email1_history);
        }

        if ($contact['email2'] && $contact['email_val2'])
        {
            $history = History::where('summon_id', '=', $summon_id)
                            ->where('user_id', '=', $user_id)
                            ->where('contact_id', '=', $contact_id)
                            ->where('main_type', '=', History::MAIN_TYPE_EMAIL2)
                            ->first();

            $email2_history = ['type' => 'Email2', 'email' => History::STATUS_UNREAD];
            array_push($history_detail, $email2_history);
        }

        if ($contact['phone_number1'])
        {
            $phone_history1 = array();

            $history = History::where('summon_id', '=', $summon_id)
                            ->where('user_id', '=', $user_id)
                            ->where('contact_id', '=', $contact_id)
                            ->where('main_type', '=', History::MAIN_TYPE_PHONE1)
                            ->where('sub_type', '=', History::SUB_TYPE_VOICE)
                            ->first();

            array_push($phone_history1, ['type' => 'voice', 'status' => $contact['phone_voice1'] ? $history->status : '']);

            $history = History::where('summon_id', '=', $summon_id)
                            ->where('user_id', '=', $user_id)
                            ->where('contact_id', '=', $contact_id)
                            ->where('main_type', '=', History::MAIN_TYPE_PHONE1)
                            ->where('sub_type', '=', History::SUB_TYPE_SMS)
                            ->first();

            array_push($phone_history1, ['type' => 'sms', 'status' => $contact['phone_sms1'] ? $history->status : '']);

            $history = History::where('summon_id', '=', $summon_id)
                            ->where('user_id', '=', $user_id)
                            ->where('contact_id', '=', $contact_id)
                            ->where('main_type', '=', History::MAIN_TYPE_PHONE1)
                            ->where('sub_type', '=', History::SUB_TYPE_WHATSAPP)
                            ->first();

            array_push($phone_history1, ['type' => 'whatsapp', 'status' => $contact['phone_whatsapp1'] ? $history->status : '']);

            array_push($history_detail, ['type' => 'Phone1', 'phone' => $phone_history1]);
        }

        if ($contact['phone_number2'])
        {
            $phone_history2 = array();

            $history = History::where('summon_id', '=', $summon_id)
                            ->where('user_id', '=', $user_id)
                            ->where('contact_id', '=', $contact_id)
                            ->where('main_type', '=', History::MAIN_TYPE_PHONE2)
                            ->where('sub_type', '=', History::SUB_TYPE_VOICE)
                            ->first();

            array_push($phone_history2, ['type' => 'voice', 'status' => $contact['phone_voice2'] ? $history->status : '']);

            $history = History::where('summon_id', '=', $summon_id)
                            ->where('user_id', '=', $user_id)
                            ->where('contact_id', '=', $contact_id)
                            ->where('main_type', '=', History::MAIN_TYPE_PHONE2)
                            ->where('sub_type', '=', History::SUB_TYPE_SMS)
                            ->first();

            array_push($phone_history2, ['type' => 'sms', 'status' => $contact['phone_sms2'] ? $history->status : '']);

            $history = History::where('summon_id', '=', $summon_id)
                            ->where('user_id', '=', $user_id)
                            ->where('contact_id', '=', $contact_id)
                            ->where('main_type', '=', History::MAIN_TYPE_PHONE2)
                            ->where('sub_type', '=', History::SUB_TYPE_WHATSAPP)
                            ->first();

            array_push($phone_history2, ['type' => 'whatsapp', 'status' => $contact['phone_whatsapp2'] ? $history->status : '']);

            array_push($history_detail, ['type' => 'Phone2', 'phone' => $phone_history2]);
        }

        if ($contact['phone_number3'])
        {
            $phone_history3 = array();

            $history = History::where('summon_id', '=', $summon_id)
                            ->where('user_id', '=', $user_id)
                            ->where('contact_id', '=', $contact_id)
                            ->where('main_type', '=', History::MAIN_TYPE_PHONE3)
                            ->where('sub_type', '=', History::SUB_TYPE_VOICE)
                            ->first();

            array_push($phone_history3, ['type' => 'voice', 'status' => $contact['phone_voice3'] ? $history->status : '']);

            $history = History::where('summon_id', '=', $summon_id)
                            ->where('user_id', '=', $user_id)
                            ->where('contact_id', '=', $contact_id)
                            ->where('main_type', '=', History::MAIN_TYPE_PHONE3)
                            ->where('sub_type', '=', History::SUB_TYPE_SMS)
                            ->first();

            array_push($phone_history3, ['type' => 'sms', 'status' => $contact['phone_sms3'] ? $history->status : '']);

            $history = History::where('summon_id', '=', $summon_id)
                            ->where('user_id', '=', $user_id)
                            ->where('contact_id', '=', $contact_id)
                            ->where('main_type', '=', History::MAIN_TYPE_PHONE3)
                            ->where('sub_type', '=', History::SUB_TYPE_WHATSAPP)
                            ->first();

            array_push($phone_history3, ['type' => 'whatsapp', 'status' => $contact['phone_whatsapp3'] ? $history->status : '']);

            array_push($history_detail, ['type' => 'Phone3', 'phone' => $phone_history3]);
        }

        return $history_detail;
    }
}
