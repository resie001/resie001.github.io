<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){

        $username = $request->username;
        $password = $request->password;

        $user = DB::table('m_user')->where('user_username',$username)->first();

        // $user = User::where('user_username',$username)->first();

        if(!$user){
            return response()->json([
                'success' => false,
                'message'=> 'Username tidak ada',
                'data' => ''
            ], 400)->header('Accept','application/json');;
        } else {
            if($user->user_status != 0){
                if(Hash::check($password, $user->user_password)){
                    return response()->json([
                        'success' => true,
                        'message'=> 'Login Berhasil',
                        'data' => $user
                    ], 200)->header('Accept','application/json');;
                } else {
                    return response()->json([
                        'success' => false,
                        'message'=> 'Password Salah',
                        'data' => ''
                    ], 400)->header('Accept','application/json');;
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message'=> 'User belum diaktifkan',
                    'data' => ''
                ], 400)->header('Accept','application/json');;
            }
        }
    }
}