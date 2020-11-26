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
        'due_date',        
        'message',
        'del_flag'
    ];

    public function location()
    {
        return $this->hasOne('App\Location', 'id', 'location_id');
    }
}
