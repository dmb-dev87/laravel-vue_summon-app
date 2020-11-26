<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Contact;

class ContactsController extends Controller
{
    //
    public function getList()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user_id = $user->id;

        $contacts = Contact::where('del_flag', '=', '0')
                        ->where('user_id', '=', $user_id)
                        ->get();

        return $contacts;
    }

    public function deleteContact($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user_id = $user->id;

        try
        {
            $res = Contact::where('id', '=', $id)
                            ->where('user_id', '=', $user_id)
                            ->update(['del_flag' => '1']);
            
            return $res;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function createContact(Request $request)
    {
        $item = $request->input('contact');

        $user = JWTAuth::parseToken()->authenticate();
        $user_id = $user->id;

        try
        {
            $contact = new Contact;

            $contact->user_id = $user_id;
            $contact->name = $item['name'];
            $contact->email = $item['email'];
            $contact->email_val1 = $item['email_val1'];
            $contact->email2 = $item['email2'];
            $contact->email_val2 = $item['email_val2'];
            $contact->phone_number1 = $item['phone_number1'];
            $contact->phone_voice1 = $item['phone_voice1'];
            $contact->phone_sms1 = $item['phone_sms1'];
            $contact->phone_whatsapp1 = $item['phone_whatsapp1'];
            $contact->phone_number2 = $item['phone_number2'];
            $contact->phone_voice2 = $item['phone_voice2'];
            $contact->phone_sms2 = $item['phone_sms2'];
            $contact->phone_whatsapp2 = $item['phone_whatsapp2'];
            $contact->phone_number3 = $item['phone_number3'];
            $contact->phone_voice3 = $item['phone_voice3'];
            $contact->phone_sms3 = $item['phone_sms3'];
            $contact->phone_whatsapp3 = $item['phone_whatsapp3'];

            $contact->save();

            return $contact;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function updateContact(Request $request, $id)
    {
        
        $item = $request->input('contact');

        $user = JWTAuth::parseToken()->authenticate();
        $user_id = $user->id;

        try
        {
            Contact::where('id', '=', $id)
                ->where('user_id', '=', $user_id)
                ->update([
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'email_val1' => $item['email_val1'],
                    'email2' => $item['email2'],
                    'email_val2' => $item['email_val2'],
                    'phone_number1' => $item['phone_number1'],
                    'phone_voice1' => $item['phone_voice1'],
                    'phone_sms1' => $item['phone_sms1'],
                    'phone_whatsapp1' => $item['phone_whatsapp1'],
                    'phone_number2' => $item['phone_number2'],
                    'phone_voice2' => $item['phone_voice2'],
                    'phone_sms2' => $item['phone_sms2'],
                    'phone_whatsapp2' => $item['phone_whatsapp2'],
                    'phone_number3' => $item['phone_number3'],
                    'phone_voice3' => $item['phone_voice3'],
                    'phone_sms3' => $item['phone_sms3'],
                    'phone_whatsapp3' => $item['phone_whatsapp3'],
                ]);

            $contact = Contact::find($id);
            return $contact;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }
}
