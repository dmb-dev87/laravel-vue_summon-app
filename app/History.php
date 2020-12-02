<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    const STATUS_UNREAD = 'Unread';
    const STATUS_READ = 'Read';

    //
    protected $fillable = [
        'user_id',
        'summon_id',
        'contact_id',
        'history_detail',
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
