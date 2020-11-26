<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

use App\Event;
use App\Contact;
use App\Group;

class EventsController extends Controller
{
    public function getList()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user_id = $user->id;

        $events = Event::where('del_flag', '=', '0')
                        ->where('user_id', '=', $user_id)
                        ->get();

        foreach($events as $event)
        {
            $event = $this->transformEvent($event);
        }

        return $events;
    }

    public function getSelectedContacts(string $list)
    {
        $sel_contacts = array();

        $contact_ids = explode(",", $list);
        foreach($contact_ids as $contact_id)
        {
            $contact = Contact::find($contact_id);
            array_push($sel_contacts, ['label' => $contact['name'], 'value' => $contact['id']]);
        }
        return $sel_contacts;
    }

    public function getSelectedGroups(string $list)
    {
        $sel_groups = array();

        $group_ids = explode(",", $list);
        foreach($group_ids as $group_id)
        {
            $group = Group::find($group_id);
            array_push($sel_groups, ['label' => $group['name'], 'value' => $group['id']]);
        }
        return $sel_groups;
    }

    public function createEvent(Request $request)
    {
        $item = $request->input('event');

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            $event = new Event;

            $event->user_id = $userId;
            $event->location_id = $item['sel_location']['value'];

            $contact_list = "";
            foreach($item['sel_contacts'] as $contact)
            {
                $contact_list .= $contact['value'].",";
            }
            $contact_list = rtrim($contact_list, ",");
            $event->contact_list = $contact_list;

            $group_list = "";
            foreach($item['sel_groups'] as $group)
            {
                $group_list .= $group['value'].",";
            }
            $group_list = rtrim($group_list, ",");
            $event->group_list = $group_list;

            $event->due_date = Carbon::parse($item['due_date']);
            $event->message = $item['message'];
            $event->is_sent = false;

            $event->save();

            return $this->transformEvent($event);
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function updateEvent(Request $request, $id)
    {
        $item = $request->input('event');

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            $contact_list = "";
            foreach($item['sel_contacts'] as $contact)
            {
                $contact_list .= $contact['value'].",";
            }
            $contact_list = rtrim($contact_list, ",");

            $group_list = "";
            foreach($item['sel_groups'] as $group)
            {
                $group_list .= $group['value'].",";
            }
            $group_list = rtrim($group_list, ",");

            Event::where('id', '=', $id)
                ->where('user_id', '=', $userId)
                ->update([
                    'location_id' => $item['sel_location']['value'],
                    'contact_list' => $contact_list,
                    'group_list' => $group_list,
                    'due_date' => Carbon::parse($item['due_date']),
                    'message' => $item['message'],
                ]);

            return $this->transformEvent(Event::find($id));
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function draggedEvent(Request $request, $id)
    {
        $item = $request->input('payload');
        $dragged_date = $item['date'];

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        try
        {
            Event::where('id', '=', $id)
                ->where('user_id', '=', $userId)
                ->update([
                    'due_date' => Carbon::parse($dragged_date),
                ]);

            return $this->transformEvent(Event::find($id));
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function transformEvent($event)
    {
        $event->startDate = $event->due_date;
        $event->title = $event->message;
        $event->classes = $event->is_sent ? Event::EVENT_SUCCESS : Event::EVENT_PRIMARY;
        $event->sel_location = ['label' => $event->location->name, 'value' => $event->location_id];
        $event->sel_contacts = $this->getSelectedContacts($event->contact_list);
        $event->sel_groups = $this->getSelectedGroups($event->group_list);

        return $event;
    }

    public function deleteEvent($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user_id = $user->id;

        try
        {
            $res = Event::where('id', '=', $id)
                            ->where('user_id', '=', $user_id)
                            ->update(['del_flag' => '1']);

            return $res;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }
}
