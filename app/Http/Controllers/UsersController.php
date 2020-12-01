<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    //
    public function __construct()
    {
    }

    public function getList()
    {
        $users = User::where('del_flag', '=', '0')->get();
        return $users;
    }

    public function updateUser(Request $request, $id)
    {
        $user = $request->input('user');
        try
        {
            User::where('id', '=', $id)
                ->update([
                    'user_name' => $user['user_name'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'email2' => $user['email2'],
                    'phone_number1' => $user['phone_number1'],
                    'phone_number2' => $user['phone_number2'],
                    'phone_number3' => $user['phone_number3'],
                    'status' => $user['status'],
                    'role_name' => $user['role_name'],
                ]);

            $user = User::find($id);
            return $user;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function deleteUser($id)
    {
        try
        {
            $res = User::where('id', '=', $id)
                ->update(['del_flag' => '1']);
            
            return $res;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }

    public function changePassword(Request $request)
    {
        $user = $request->input('user');
        try
        {
            User::where('id', '=', $user['id'])
                ->update([
                    'password' => bcrypt($user['new_pwd']),
                ]);

            $user = User::find($user['id']);
            return $user;
        }
        catch(Exception $ex)
        {
            return $ex;
        }
    }
}
