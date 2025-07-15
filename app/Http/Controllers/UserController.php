<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    //
    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|unique:users,email|max:200',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => "You have been registered successfully",
            'user' => $user
        ], 201);
    }
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]
        );
        if (!Auth::attempt($request->only('email', 'password')))
            return response()->json([
                'message' => "invalid email or password ", //if not ! will get error and if its true

            ], 401);
        $user = User::where('email', $request->email)->firstOrFail(); //here will find first email in db coz its unique
        $token = $user->createToken('my token')->plainTextToken; //here will generate token for the $user and store it in $token
        return response()->json([
            'message' => "login  successfully",
            'user' => $user,
            'token' => $token
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => " logout successfully ",

        ],401);
    }
}
