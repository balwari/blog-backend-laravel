<?php

namespace App\Http\Controllers\Api;


use App\User;
use App\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){

        $validateData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required',
            'password' => 'required|confirmed'
        ]);

        $validateData['password'] = bcrypt($request->password);

        $user = User::create($validateData);
        $accessToken = $user->createToken('authToken')->accessToken;
        return response($user['id']);

    }


    public function login(Request $request){
         
        $credentials = $request->validate([
             'email' => 'required',
             'password' => 'required'
        ]);
        
        $data = User::where('email', $request->email)->get();
            
        if( !auth()->attempt($credentials)) {
            return response(['message' => 'Invalid credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        if($data[0]['name']=='admin'){
        return response(['id'=> 'admin','access_token' => $accessToken]);
        }else if($data[0]['blocked'] == '0'){
        return response(['id'=> 'user','access_token' => $accessToken]);
        }else{
        return response(['message' => 'Your Account Has Been Blocked']);
        }
    }

}