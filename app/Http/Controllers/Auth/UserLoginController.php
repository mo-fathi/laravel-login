<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\APIResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
            'device_name' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $data = [
            'user' => $user,
            'access_token' => $user->createToken($request->device_name)->plainTextToken
        ];


        return APIResponse::json('welcome',false,$data);
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return APIResponse::json('Logged out');


    }
}
