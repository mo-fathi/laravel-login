<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controllers 
use App\Http\Controllers\Auth\UserEmailValidationController;


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
Route::post('/email-otp', [UserEmailValidationController::class,'sendEmailOTP']);
Route::post('/email-validation', [UserEmailValidationController::class,'validateEmail']);