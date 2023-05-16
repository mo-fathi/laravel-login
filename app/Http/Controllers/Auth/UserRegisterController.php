<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserRegisterController extends Controller
{
    public function register(Request $request)
    {
        // validation
        $validator = $request->validate([
            'email' => ['required','email','unique:users'],
            'name' => ['required'],
            'family' => ['required'],
            'otp' => ['required','min:6','max:6'],
            'password' => ['required','confirmed',
            Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()],
        ]);

        $cached_otp = Cache::get($validator['email'], 'default');
        // check email and otp
        if($cached_otp == $validator['otp']){

            // create user with that email and verify.
            $new_user = User::create([
                'email' => $validator['email'],
                'name' => $validator['name'],
                'family' => $validator['family'],
                'password' => Hash::make($validator['password']),
                'email_verified_at' => now(),
            ]) ;

            return $new_user;

        }
        return 'wrong otp';
    }
}
