<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    const EVENT_SUCCESS = 'event-success';
    const EVENT_PRIMARY = 'event-primary';

    protected $fillable = [
        'user_id',
        'location_id',
        'contact_list',
        'group_list',
        'due_date',        
        'message',
        'del_flag'
    ];

    public function location()
    {
        return $this->hasOne('App\Location', 'id', 'location_id');
    }
}
