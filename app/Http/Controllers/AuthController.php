<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Mail\VerificationEmail;
use App\User;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'user_name' => trim($request->input('user_name')),
            'name' => trim($request->input('user_name')),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
            'email_verification_token' => Str::random(32),
            'status' => 'Deactivate',
            'verification_code' => mt_rand(100000, 999999)
        ]);

        \Mail::to($user->email)->send(new VerificationEmail($user));

        return response()->json(['token' => $user->email_verification_token]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Wrong Email or Password']);
        }

        $email = request('email');

        $user = User::where('email', '=', $email)->first();

        if ($user->email_verified == false)
        {
            return response()->json(['error' => 'You need to confirm your account. We have sent you an activation code, please check your email.']);
        }

        if ($user->status == 'Deactivate')
        {
            return response()->json(['error' => 'Your account is not activate. Please contact to administrator.']);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user' => $this->guard()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function guard(){
        return \Auth::Guard('api');
    }

    public function updateUser(Request $request)
    {
        $user = $request->input('user');
        try
        {
            User::where('id', '=', $user['id'])
                ->update([
                    'user_name' => $user['user_name'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'email2' => $user['email2'],
                    'phone_number1' => $user['phone_number1'],
                    'phone_number2' => $user['phone_number2'],
                    'phone_number3' => $user['phone_number3'],
                ]);

            $user = User::find($user['id']);
            return $user;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $old_password = request('old_password');
        $new_password = request('new_password');
        $confirm_password = request('confirm_password');

        try
        {
            if ((\Hash::check($old_password, $user->password)) == false) {
                $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
            } else if ((\Hash::check($new_password, $user->password)) == true) {
                $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
            } else {
                User::where('id', $userId)->update(['password' => bcrypt($new_password)]);
                $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
            }
        }
        catch(Exception $ex)
        {
            $msg = $ex->getMessage();
            $arr = array("status" => 400, "message" => $msg, "data" => array());
        }
        
        return $arr;
    }
}
