<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'email_val1',
        'email2',
        'email_val2',
        'phone_number1',
        'phone_voice1',
        'phone_sms1',
        'phone_whatsapp1',
        'phone_number2',
        'phone_voice2',
        'phone_sms2',
        'phone_whatsapp2',
        'phone_number3',
        'phone_voice3',
        'phone_sms3',
        'phone_whatsapp3',
        'del_flag',
    ];

    // public function contact()
    // {
    //     return $this->hasOne(User::class, 'id', 'user_id');
    // }
}
