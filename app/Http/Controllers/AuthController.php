<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

use App\Mail\VerificationEmail;
use App\User;
use App\Contact;
use App\Event;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'user_name' => trim($request->input('user_name')),
            'name' => trim($request->input('user_name')),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
            'email_verification_token' => Str::random(32),
            'status' => 'Deactivate',
            'verification_code' => mt_rand(100000, 999999)
        ]);

        \Mail::to($user->email)->send(new VerificationEmail($user));

        return response()->json(['token' => $user->email_verification_token]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Wrong Email or Password']);
        }

        $email = request('email');

        $user = User::where('email', '=', $email)->first();

        if ($user->email_verified == false)
        {
            return response()->json(['error' => 'You need to confirm your account. We have sent you an activation code, please check your email.']);
        }

        if ($user->status == 'Deactivate')
        {
            return response()->json(['error' => 'Your account is not activate. Please contact to administrator.']);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user' => $this->guard()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function guard(){
        return \Auth::Guard('api');
    }

    public function updateUser(Request $request)
    {
        $user = $request->input('user');
        try
        {
            User::where('id', '=', $user['id'])
                ->update([
                    'user_name' => $user['user_name'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'email2' => $user['email2'],
                    'phone_number1' => $user['phone_number1'],
                    'phone_number2' => $user['phone_number2'],
                    'phone_number3' => $user['phone_number3'],
                ]);

            $user = User::find($user['id']);
            return $user;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $old_password = request('old_password');
        $new_password = request('new_password');
        $confirm_password = request('confirm_password');

        try
        {
            if ((\Hash::check($old_password, $user->password)) == false) {
                $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
            } else if ((\Hash::check($new_password, $user->password)) == true) {
                $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
            } else {
                User::where('id', $userId)->update(['password' => bcrypt($new_password)]);
                $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
            }
        }
        catch(Exception $ex)
        {
            $msg = $ex->getMessage();
            $arr = array("status" => 400, "message" => $msg, "data" => array());
        }
        
        return $arr;
    }

    public function emailConfigure(Request $request)
    {
        $this->validate($request, [
            'access_token' => 'required',
        ]);

        $email_type = request('email_type');
        $access_token = request('access_token');

        if ($email_type == 'google')
        {
            return $this->configureWithGoogle($access_token);
        }
        elseif ($email_type == 'outlook')
        {
            return $this->configureWithOutlook($access_token);
        }
    }

    public function configureWithOutlook($access_token)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            $connections = $this->getContactsWithOutlook($access_token);

            foreach($connections as $connection)
            {
                $email_addresses = $connection->getEmailAddresses();

                $pre_contacts = Contact::where('user_id', '=', $userId)
                                        ->where('email', '=', $email_addresses[0]['address'])
                                        ->get();

                if ($pre_contacts->count() > 0)
                {
                    break;
                }

                $contact = new Contact;

                $contact->user_id = $userId;
                $contact->name = $connection->getDisplayName();

                $contact->email = $email_addresses[0]['address'];
                $contact->email_val1 = true;

                $contact->email2 = count($email_addresses) > 1 ? $email_addresses[1]['address'] : null;
                $contact->email_val2 = count($email_addresses) > 1 ? true : false;

                $contact->phone_number1 = $connection->getMobilePhone();
                $contact->phone_voice1 = $connection->getMobilePhone() != null ? true : false;
                $contact->phone_sms1 = $connection->getMobilePhone() != null ? true : false;
                $contact->phone_whatsapp1 = $connection->getMobilePhone() != null ? true : false;

                $contact->save();
            }

            $event_values = $this->getEventsWithOutlook($access_token);

            foreach($event_values as $event_value)
            {
                $start_datetime = $event_value->getStart();                

                $pre_events = Event::where('user_id', '=', $userId)
                                    ->where('start_date', '=', $start_datetime->getDateTime())
                                    ->get();

                if ($pre_events->count() > 0)
                {
                    break;
                }

                $event = new Event;

                $event->user_id = $userId;
                $event->message = $event_value->getSubject();

                $event->start_date = $start_datetime->getDateTime();

                $end_datetime = $event_value->getEnd();
                $event->end_date = $end_datetime->getDateTime();

                $event->save();
            }

            $arr = array("status" => 200, "message" => "Email cofiguration is successed.", "data" => array());
        }
        catch(Exception $ex)
        {
            $msg = $ex->getMessage();
            $arr = array("status" => 400, "message" => $msg, "data" => array());
        }

        return $arr;
    }

    public function getContactsWithOutlook($access_token)
    {
        $graph = new Graph();
        $graph->setAccessToken($access_token);

        $contacts = $graph->createRequest("GET", "/me/contacts")
                        ->setReturnType(Model\Contact::class)
                        ->execute();

        return $contacts;
    }

    public function getEventsWithOutlook($access_token)
    {
        $graph = new Graph();
        $graph->setAccessToken($access_token);

        $events = $graph->createRequest("GET", "/me/events")
                        ->setReturnType(Model\Event::class)
                        ->execute();
        
        return $events;
    }

    public function configureWithGoogle($access_token)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            $connections = $this->getContactsWithGoogle($access_token);

            foreach($connections as $connection)
            {
                $contact = new Contact;

                $contact->user_id = $userId;
                $contact->name = $connection->names[0]->displayName;

                $pre_contacts = Contact::where('user_id', '=', $userId)
                                        ->where('email', '=', $connection->emailAddresses[0]->value)
                                        ->get();

                if ($pre_contacts->count() > 0)
                {
                    break;
                }

                $contact->email = $connection->emailAddresses[0]->value;
                $contact->email_val1 = true;

                $contact->email2 = count($connection->emailAddresses) > 1 ? $connection->emailAddresses[1]->value : null;
                $contact->email_val2 = count($connection->emailAddresses) > 1 ? true : false;

                $contact->phone_number1 = count($connection->phoneNumbers) > 0 ? $connection->phoneNumbers[0]->value : null;
                $contact->phone_voice1 = count($connection->phoneNumbers) > 0 ? true : false;
                $contact->phone_sms1 = count($connection->phoneNumbers) > 0 ? true : false;
                $contact->phone_whatsapp1 = count($connection->phoneNumbers) > 0 ? true : false;

                $contact->phone_number2 = count($connection->phoneNumbers) > 1 ? $connection->phoneNumbers[1]->value : null;
                $contact->phone_voice2 = count($connection->phoneNumbers) > 1 ? true : false;
                $contact->phone_sms2 = count($connection->phoneNumbers) > 1 ? true : false;
                $contact->phone_whatsapp2 = count($connection->phoneNumbers) > 1 ? true : false;

                $contact->phone_number3 = count($connection->phoneNumbers) > 2 ? $connection->phoneNumbers[2]->value : null;
                $contact->phone_voice3 = count($connection->phoneNumbers) > 2 ? true : false;
                $contact->phone_sms3 = count($connection->phoneNumbers) > 2 ? true : false;
                $contact->phone_whatsapp3 = count($connection->phoneNumbers) > 2 ? true : false;

                $contact->save();
            }

            // $events = $this->getEventsWithGoogle($access_token);

            $arr = array("status" => 200, "message" => "Email cofiguration is successed.", "data" => array());
        }
        catch(Exception $ex)
        {
            $msg = $ex->getMessage();
            $arr = array("status" => 400, "message" => $msg, "data" => array());
        }

        return $arr;
    }

    public function getContactsWithGoogle($access_token)
    {
        $url = 'https://people.googleapis.com/v1/people/me/connections?oauth_token='.$access_token."&personFields=names,emailAddresses,phoneNumbers";

        $curl = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        curl_setopt($curl, CURLOPT_URL, $url);

        //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

        //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);

        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);

        //The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

        //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);

        //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        //To stop cURL from verifying the peer's certificate.
        $contents = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($contents);

        return $response->connections ? $response->connections : null;
    }

    public function getEventsWithGoogle($access_token)
    {
        $url = 'https://www.googleapis.com/calendar/v3/calendars/primary/events?oauth_token='.$access_token;

        $curl = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        curl_setopt($curl, CURLOPT_URL, $url);

        //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

        //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);

        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);

        //The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

        //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);

        //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        //To stop cURL from verifying the peer's certificate.
        $contents = curl_exec($curl);
        curl_close($curl);

        return $contents;
    }

}
