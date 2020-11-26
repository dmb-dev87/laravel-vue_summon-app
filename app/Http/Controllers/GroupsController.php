<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Group;
use App\Contact;

class GroupsController extends Controller
{
    //
    public function getList()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $groups = Group::where('user_id', '=', $userId)
                        ->where('del_flag', '=', 0)->get();

        foreach($groups as $group)
        {
            $group->sel_contacts = $this->getSelectedContacts($group->contact_list);
        }
        return $groups;
    }

    public function getSelectedContacts(string $list)
    {
        $sel_contacts = array();

        $contact_ids = explode(",", $list);
        foreach($contact_ids as $contact_id)
        {
            $contact = Contact::find($contact_id);
            if ($contact)
                array_push($sel_contacts, ['label' => $contact['name'], 'value' => $contact['id']]);
        }
        return $sel_contacts;
    }

    public function deleteGroup($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            $res = Group::where('id', '=', $id)
                ->where('user_id', '=', $userId)
                ->update(['del_flag' => '1']);
            
            return $res;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function createGroup(Request $request)
    {
        $item = $request->input('group');

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            $group = new Group;

            $group->user_id = $userId;
            $group->name = $item['name'];

            $contact_list = "";

            foreach($item['sel_contacts'] as $contact)
            {
                $contact_list .= $contact['value'].",";
            }

            $contact_list = rtrim($contact_list, ",");

            $group->contact_list = $contact_list;

            $group->save();

            return $group;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function updateGroup(Request $request, $id)
    {
        $item = $request->input('group');

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $contact_list = "";
        foreach($item['sel_contacts'] as $contact)
        {
            $contact_list .= $contact['value'].",";
        }
        $contact_list = rtrim($contact_list, ",");

        try
        {
            Group::where('id', '=', $id)
                ->where('user_id', '=', $userId)
                ->update([
                    'name' => $item['name'],
                    'contact_list' => $contact_list,
                ]);

            $group = Group::find($id);
            return $group;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }
}
