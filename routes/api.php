<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationApiMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('userRegistration');
Route::post('/login', [UserController::class, 'userLogin'])->name('userLogin');
Route::get('/logout', [UserController::class, 'userLogout'])->name('userLogout');
Route::post('/send-otp', [UserController::class, 'sendOTPCode'])->name('sendOTPCode');
Route::post('/verify-otp', [UserController::class, 'verifyOTP'])->name('verifyOTP');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware([TokenVerificationApiMiddleware::class]);
Route::get('/user-profile', [UserController::class, 'userProfile'])->middleware([TokenVerificationApiMiddleware::class]);
Route::post('/update-profile', [UserController::class, 'updateProfile'])->middleware([TokenVerificationApiMiddleware::class]);
