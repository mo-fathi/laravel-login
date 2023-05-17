<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Responses\APIResponse;
use App\Mail\ResetPasswordRequested;
use App\Models\ApiPasswordResetTokens;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserResetPassword extends Controller
{
    public function resetPassword(Request $request)
    {
        // validation
        $request->validate([
            'email' => ['required','email'],
            'otp' => ['required', 'min:6','max:6'],
            'new_password' => ['required','confirmed',
            Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()]
        ]);

        // checking
        $user = User::where('email',$request->email)->first();
        $token = ApiPasswordResetTokens::where('email',$request->email)->first();

        if (! $user || ! $token)
        {
            return APIResponse::json('wrong otp',true);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return APIResponse::json('your password changed');

    }

    public function sendResetPasswordEmail(Request $request)
    {
        $request->validate([
            'email' => ['required','email']
        ]);

        $user = User::where('email',$request->email)->first();
        
        if (! $user)
        {
            return APIResponse::json('please check your email inbox.');
        }
        // delete exist tokens
        ApiPasswordResetTokens::where('email',$request->email)->delete();

        $reset_password = ApiPasswordResetTokens::create([
            'email' => $request->email,
            'token' => mt_rand(100000 , 999999),
            'expired_at' => now()->addMinutes(2),
        ]);
        // $reset_password = new ApiPasswordResetTokens();
        // $reset_password->email = $request->email;
        // $reset_password->token = mt_rand(100000 , 999999);
        // $reset_password->created_at = now();
        // $
        // $reset_password->save();

        // mail
        Mail::to($request->email)->send(new ResetPasswordRequested($reset_password->token));

        return APIResponse::json('please check your email inbox.');

    }
}
