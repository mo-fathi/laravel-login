<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controllers
use App\Http\Controllers\Auth\UserEmailVerificationController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserResetPassword;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// send otp
Route::post('/register/email-otp', [UserEmailVerificationController::class,'sendEmailOTP']);
// otp validation
Route::post('/register/email-otp/validation', [UserEmailVerificationController::class,'validateEmailOTP']);
// user registration
Route::post('/register',[UserRegisterController::class,'register']);

// login
Route::post('/login',[UserLoginController::class,'login']);
// reset pasword
Route::post('/reset-password',[UserResetPassword::class,'resetPassword']);
Route::post('/reset-password/email',[UserResetPassword::class,'sendResetPasswordEmail']);
Route::middleware(['auth:sanctum'])->group(function () {
    // logoutc
    Route::post('logout',[UserLoginController::class,'logout']);
});

