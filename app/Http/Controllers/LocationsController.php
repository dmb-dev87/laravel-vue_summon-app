<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Location;

class LocationsController extends Controller
{
    //
    public function getList()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $locations = Location::where('user_id', '=', $userId)
                        ->where('del_flag', '=', '0')
                        ->get();
        return $locations;
    }

    public function createLocation(Request $request)
    {
        $item = $request->input('location_item');

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            $location = new Location;

            $location->user_id = $userId;
            $location->name = $item['name'];

            $location->save();

            return $location;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function updateLocation(Request $request, $id)
    {
        $item = $request->input('location_item');

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            Location::where('id', '=', $id)
                ->where('user_id', '=', $userId)
                ->update([
                    'name' => $item['name'],
                ]);

            $location = Location::find($id);
            return $location;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function deleteLocation($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            $res = Location::where('id', '=', $id)
                ->where('user_id', '=', $userId)
                ->update(['del_flag' => '1']);
            
            return $res;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }
}
