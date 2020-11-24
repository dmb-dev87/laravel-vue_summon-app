<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    //
    public function __construct()
    {
    }

    public function get()
    {
        $users = User::get();
        return $users;
    }
}
