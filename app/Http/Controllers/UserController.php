<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends ResponseController
{


    /**
     * Register new user in app.
     */
    public function register(Request $request)
    {
        return $request->all();
        $userDataValidation = $request->validate([
            'user_name' => "required|string",
            'email' => "required|email|string",
            'password' => "required|string",
        ]);

        $uuid = Str::uuid()->toString();

        $user = User::create([
            'name' => $userDataValidation['user_name'],
            'email' => $userDataValidation['email'],
            'password' => Hash::make($userDataValidation['password']),
            'uuid' => $uuid,
        ]);

        $accessToken = $user->createToken($uuid)->plainTextToken;

        return $this->successResponse(201, $accessToken);
    }

    /**
     * login with user name or email password.
     */
    public function login(Request $request)
    {
        $userLoginValidation = $request->validate([
            'email' => 'email|required',
            'password' => "string|min:8",
        ]);
        $user = User::where("email" , $userLoginValidation['email'])->get()->first();


        if(empty($user)){
            return $this->errorResponse("User not found" , 404);
        }

        if(!Hash::check($userLoginValidation['password'] , $user->password)){
            return $this->errorResponse('Unauthorized' , 403);
        }

        $accessToken = $user->createToken($user->uuid)->plainTextToken;
        return $this->successResponse(201, $accessToken);
    }

    /**
     * logout user .
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->successResponse(200, 'token deleted successfully');
    }

}
