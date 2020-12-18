<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    const STATUS_SEND ='SEND';
    const STATUS_UNSEND = 'UNSEND';
    const STATUS_UNREAD = 'UNREAD';
    const STATUS_READ = 'READ';
    const STATUS_FAILED = 'FAILED';

    const MAIN_TYPE_EMAIL1 = 'EMAIL1';
    const MAIN_TYPE_EMAIL2 = 'EMAIL2';
    const MAIN_TYPE_PHONE1 = 'PHONE1';
    const MAIN_TYPE_PHONE2 = 'PHONE2';
    const MAIN_TYPE_PHONE3 = 'PHONE3';

    const SUB_TYPE_SMS = 'SMS';
    const SUB_TYPE_VOICE = 'VOICE';
    const SUB_TYPE_WHATSAPP = 'WHATSAPP';

    //
    protected $fillable = [
        'user_id',
        'summon_id',
        'contact_id',
        'main_type',
        'sub_type',
        'status',
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function summon()
    {
        return $this->hasOne('App\Summon', 'id', 'summon_id');
    }

    public function contact()
    {
        return $this->hasOne('App\Contact', 'id', 'contact_id');
    }
}
