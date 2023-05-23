<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controllers
use App\Http\Controllers\Auth\UserEmailVerificationController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserResetPasswordController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\UserPostController;

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
Route::post('/reset-password',[UserResetPasswordController::class,'resetPassword']);
Route::post('/reset-password/email',[UserResetPasswordController::class,'sendResetPasswordEmail']);
Route::middleware(['auth:sanctum'])->group(function () {
    // logoutc
    Route::post('logout',[UserLoginController::class,'logout']);

    // post routes
    Route::get('/posts',[UserPostController::class,'index']);
    Route::get('/posts/{id}',[UserPostController::class,'show']);
    Route::post('/posts',[UserPostController::class,'store']);
    Route::put('/posts/{id}',[UserPostController::class,'update']);
    Route::delete('/posts/{id}',[UserPostController::class,'destroy']);

    // category routes
    Route::get('/categories',[UserCategoryController::class,'index']);
    Route::get('/categories/{id}',[UserCategoryController::class,'show']);
    Route::post('/categories',[UserCategoryController::class,'store']);
    Route::put('/categories/{id}',[UserCategoryController::class,'update']);
    Route::delete('/categories/{id}',[UserCategoryController::class,'destroy']);
});

