<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends ResponseController
{

    public function getAllUsers(Request $request)
    {
        $allUsers = User::all()->where('uuid', "!=", $request->user()->uuid);
        return $this->successResponse(200 , $allUsers);
    }

    public function index(Request $request)
    {
        return $this->successResponse(200, $request->user());
    }

    /**
     * Register new user in app.
     */
    public function register(Request $request)
    {
        $userDataValidation = $request->validate([
            'user_name' => "required|string",
            'email' => "required|email|string",
            'password' => "required|string",
            'avatar' => "required|string",
        ]);

        $uuid = Str::uuid()->toString();

        $user = User::create([
            'name' => $userDataValidation['user_name'],
            'email' => $userDataValidation['email'],
            'password' => Hash::make($userDataValidation['password']),
            'uuid' => $uuid,
            'avatar' => $userDataValidation['avatar'],
        ]);

        $accessToken = $user->createToken($uuid)->plainTextToken;
        $newUserData = array(
            "user" => $user,
            "token" => $accessToken
        );

        return $this->successResponse(201, $newUserData);
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
        $user = User::where("email", $userLoginValidation['email'])->get()->first();


        if (empty($user)) {
            return $this->errorResponse("User not found", 404);
        }

        if (!Hash::check($userLoginValidation['password'], $user->password)) {
            return $this->errorResponse('Unauthorized', 403);
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
