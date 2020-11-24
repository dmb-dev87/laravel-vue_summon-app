<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class GroupsController extends Controller
{
    //
    public function get()
    {
        $groups = Group::where('del_flag', '=', 0)->get();
        return $groups;
    }
}
