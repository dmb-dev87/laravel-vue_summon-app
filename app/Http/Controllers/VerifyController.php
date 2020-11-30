<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;

class VerifyController extends Controller
{
    //

    public function verifyEmail()
    {
        $token = request('email_verification_token');
        $code = request('verification_code');

    	if($token == null) {
            return response()->json(['error' => 'Invalid verification']);
    	}

        $user = User::where('email_verification_token',$token)->first();

        if($user == null ) {
            return response()->json(['error' => 'Invalid verification']);
        }

        if ($user->verification_code != $code) {
            return response()->json(['error' => 'Invalid verification']);
        }

        $user->update([
            'email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'email_verification_token' => '',
            'verification_code' => ''
        ]);
       
        return response()->json(['user' => $user]);
    }
}
