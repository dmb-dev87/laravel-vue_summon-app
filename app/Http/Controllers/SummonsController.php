<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Summon;
use App\Location;
use App\Group;
use App\Contact;
use Carbon\Carbon;

class SummonsController extends Controller
{
    //
    public function getList()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $summons = Summon::where('user_id', '=', $userId)
                        ->where('del_flag', '=', '0')
                        ->get();

        foreach($summons as $summon)
        {
            $summon->location_name = $summon->location->name;
            $summon->end_date_str = date("d/m/Y h:i A", strtotime($summon->end_date));
        }

        return $summons;
    }

    public function getLocationOptions()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $locations = Location::where('user_id', '=', $userId)
                            ->where('del_flag', '=', '0')
                            ->get();

        $location_options = array();

        foreach($locations as $location)
        {
            array_push($location_options, ['value' => $location['id'], 'label' => $location['name']]);
        }

        return $location_options;
    }

    public function getGroupOptions()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $groups = Group::where('user_id', '=', $userId)
                            ->where('del_flag', '=', '0')
                            ->get();

        $group_options = array();

        foreach($groups as $group)
        {
            array_push($group_options, ['value' => $group['id'], 'label' => $group['name']]);
        }

        return $group_options;
    }

    public function getContactOptions()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $contacts = Contact::where('user_id', '=', $userId)
                            ->where('del_flag', '=', '0')
                            ->get();

        $contact_options = array();

        foreach($contacts as $contact)
        {
            array_push($contact_options, ['value' => $contact['id'], 'label' => $contact['name']]);
        }

        return $contact_options;
    }

    public function createSummon(Request $request)
    {
        $item = $request->input('summon');

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            $summon = new Summon;

            $summon->user_id = $userId;
            $summon->location_id = $item['sel_location']['value'];

            $contact_list = "";
            foreach($item['sel_contacts'] as $contact)
            {
                $contact_list .= $contact['value'].",";
            }
            $contact_list = rtrim($contact_list, ",");
            $summon->contact_list = $contact_list;

            $group_list = "";
            foreach($item['sel_groups'] as $group)
            {
                $group_list .= $group['value'].",";
            }
            $group_list = rtrim($group_list, ",");
            $summon->group_list = $group_list;

            $summon->start_date = Carbon::parse($item['start_date']);
            $summon->end_date = Carbon::parse($item['end_date']);
            $summon->message = $item['message'];
            $summon->is_sent = false;

            $summon->save();

            return $summon;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }
}
