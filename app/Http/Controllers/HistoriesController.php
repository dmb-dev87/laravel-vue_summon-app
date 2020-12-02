<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\History;

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
            $history->history_detail = json_decode($history->history_detail);
        }
        return $histories;
    }
}
