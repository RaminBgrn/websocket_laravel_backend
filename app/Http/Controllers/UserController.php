<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends ResponseController
{
    public function index(){
        return 'index';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
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
            'uuid'=> $uuid,
        ]);

        $accessToken = $user->createToken($uuid)->plainTextToken;

         return $this->successResponse(201 , $accessToken);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
