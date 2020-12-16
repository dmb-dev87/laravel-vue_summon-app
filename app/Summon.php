<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Summon extends Model
{
    //
    protected $fillable = [
        'user_id',
        'location_id',
        'contact_list',
        'group_list',
        'summon_type',
        'start_date',
        'end_date',
        'del_flag',
        'message',
        'is_sent',
    ];

    public function location()
    {
        return $this->hasOne('App\Location', 'id', 'location_id');
    }
}
