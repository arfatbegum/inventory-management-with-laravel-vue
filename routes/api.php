<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationApiMiddleware;
use Illuminate\Support\Facades\Route;

//user routes
Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('userRegistration');
Route::post('/login', [UserController::class, 'userLogin'])->name('userLogin');
Route::get('/logout', [UserController::class, 'userLogout'])->name('userLogout');
Route::post('/send-otp', [UserController::class, 'sendOTPCode'])->name('sendOTPCode');
Route::post('/verify-otp', [UserController::class, 'verifyOTP'])->name('verifyOTP');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware([TokenVerificationApiMiddleware::class]);
Route::get('/user-profile', [UserController::class, 'userProfile'])->middleware([TokenVerificationApiMiddleware::class]);
Route::post('/update-profile', [UserController::class, 'updateProfile'])->middleware([TokenVerificationApiMiddleware::class]);

//Category routes
Route::get('/category-list', [CategoryController::class, 'categoryList'])->middleware([TokenVerificationApiMiddleware::class]);
Route::post('/create-category', [CategoryController::class, 'createCategory'])->middleware([TokenVerificationApiMiddleware::class]);
Route::delete('/delete-category', [CategoryController::class, 'deleteCategory'])->middleware([TokenVerificationApiMiddleware::class]);
Route::get('/category-by-id', [CategoryController::class, 'categoryById'])->middleware([TokenVerificationApiMiddleware::class]);
Route::post('/update-category', [CategoryController::class, 'updateCategory'])->middleware([TokenVerificationApiMiddleware::class]);