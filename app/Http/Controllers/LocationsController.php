<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;

class LocationsController extends Controller
{
    //
    public function get()
    {
        $locations = Location::where('del_flag', '=', '0')->get();
        return $locations;
    }
}
