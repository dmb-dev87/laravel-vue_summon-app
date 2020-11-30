<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
}
