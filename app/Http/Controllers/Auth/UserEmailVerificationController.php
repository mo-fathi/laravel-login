<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmailVerification;

class UserEmailVerificationController extends Controller
{
    public function sendEmailOTP(Request $request)
    {
        // validate request
        $validator = $request->validate([
            'email' => 'required|email'
        ]);

        
        // make otp
        $email_otp = mt_rand(100000, 999999); // Generate a random OTP token

        // store otp
        Cache::add($validator['email'], $email_otp, 120);
        // check if not add
        
        // send email
        Mail::to($validator['email'])->send(new UserEmailVerification($email_otp));
        // response
        return [
            'message' => 'otp was sent to your email',
            'error' => false,
            'date' => ''
        ];
    }

    public function validateEmail(Request $request)
    {
        // validation
        $validator = $request->validate([
            'email' => 'required|email|unique:users',
            'otp' => 'required|min:6|max:6'
        ]);

        // create new user


        // response
    }
    
}
