<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\History;
use App\Contact;

class HistoriesController extends Controller
{
    //
    public function getHistories($summon_id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $histories = History::where('user_id', '=', $userId)
                        ->where('summon_id', '=', $summon_id)
                        ->get();

        foreach($histories as $history)
        {
            $history->contact_name = $history->contact->name;
        }
        return $histories;
    }

    public function emailResponse($history_id)
    {
        History::where('id', '=', $history_id)
                ->update(['status' => History::STATUS_READ] );

        $history = History::find($history_id);

        return $history;
    }
}
