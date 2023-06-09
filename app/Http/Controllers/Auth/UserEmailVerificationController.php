<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmailVerification;
use App\Models\User;

class UserEmailVerificationController extends Controller
{
    public function sendEmailOTP(Request $request)
    {
        // validate request
        $validated = $request->validate([
            'email' => 'required|email'
        ]);


        // make otp
        $email_otp = mt_rand(100000, 999999); // Generate a random OTP token

        // store otp
        Cache::add($validated['email'], $email_otp, 5*60);
        // check if not add

        // send email
        Mail::to($validated['email'])->send(new UserEmailVerification($email_otp));
        // response
        return [
            'message' => 'otp was sent to your email',
            'error' => false,
            'date' => ''
        ];
    }

    public function validateEmailOTP(Request $request)
    {
        // validation
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'otp' => 'required|min:6|max:6'
        ]);

        $cached_otp = Cache::get($validated['email'], 'default');

        // email verified
        if($cached_otp == $validated['otp']){

            return APIResponse::json('The email otp code valid');

        }

        return  APIResponse::json('The email otp code valid is not valid');

    }

}
