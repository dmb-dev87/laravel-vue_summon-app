<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable = [
        'user_id',
        'contact_user_id',
        'email',        
        'del_flag',
    ];

    public function contact()
    {
        return $this->hasOne(User::class, 'id', 'contact_user_id');
    }
}
