<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactsController extends Controller
{
    //
    public function get($user_id)
    {
        $user_id = 1;
        $contacts = Contact::where('del_flag', '=', '0')
            ->where('user_id', '=', $user_id)
            ->get();

        foreach($contacts as $contact)
        {
            $contact->name = $contact->contact->name;
            $contact->email = $contact->contact->email;
            $contact->email2 = $contact->contact->email2;
            $contact->phone_number1 = $contact->contact->phone_number1;
            $contact->phone_number2 = $contact->contact->phone_number2;
            $contact->phone_number3 = $contact->contact->phone_number3;
            $contact->email_val1 = $contact->contact->email_val1;
            $contact->email_val2 = $contact->contact->email_val2;
            $contact->phone_voice1 = $contact->contact->phone_voice1;
            $contact->phone_sms1 = $contact->contact->phone_sms1;
            $contact->phone_whatsapp1 = $contact->contact->phone_whatsapp1;
            $contact->phone_voice2 = $contact->contact->phone_voice2;
            $contact->phone_sms2 = $contact->contact->phone_sms2;
            $contact->phone_whatsapp2 = $contact->contact->phone_whatsapp2;
            $contact->phone_voice3 = $contact->contact->phone_voice3;
            $contact->phone_sms3 = $contact->contact->phone_sms3;
            $contact->phone_whatsapp3 = $contact->contact->phone_whatsapp3;
        }
        
        return $contacts;
    }
}
