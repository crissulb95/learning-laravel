<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    const FAIL = 'failure';
    const SUCCESS = 'success';

    public function register(Request $request) {
        
        $fields = $request->validate([
            'name' => 'string|required|max:40',
            'lastname' => 'string|required|max:40',
            'email' => 'string|email|required|unique:users,email',
            'password' => 'string|required|max:20|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken($fields['email'],['test','newAbility'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'User was created succesfully',
            'status' => self::SUCCESS
        ];

        try {
            return response($response,201);
        } catch (\Throwable $th) {
            return response([
                'message' => 'Something happened while processing the request',
                'status' => self::FAIL,
                'error' => $th
            ],400);
        }
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'string|email|required|unique:users,email',
            'password' => 'string|required|max:20',
        ]);
        
        //Check email
        $user = User::where('email',$fields['email'])->first();

        //Check password
        if(!user || !Hash::check($fields['password'],$user->password)) {
            return response([
                'message' => 'Check the credentials',
                'status' => self::FAIL
            ],401);
        }

        $token = $user->createToken($fields['email'],['test','newAbility'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'User was logged in succesfully',
            'status' => self::SUCCESS
        ];

        try {
            return response($response,201);
        } catch (\Throwable $th) {
            return response([
                'message' => 'Something happened while processing the request',
                'status' => self::FAIL,
                'error' => $th
            ],400);
        }
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        try {
            return response([
                'message' => 'User was logged out succesfully',
                'status' => self::SUCCESS
            ],200);
        } catch (\Throwable $th) {
            return response([
                'message' => 'User could not be logged out',
                'status' => self::FAIL,
                'error' => $th
            ],400);
        }
    }
}