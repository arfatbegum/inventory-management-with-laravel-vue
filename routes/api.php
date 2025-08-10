<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
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

//Customer routes
Route::get('/customer-list', [CustomerController::class, 'customerList'])->middleware([TokenVerificationApiMiddleware::class]);
Route::post('/create-customer', [CustomerController::class, 'createCustomer'])->middleware([TokenVerificationApiMiddleware::class]);
Route::delete('/delete-customer', [CustomerController::class, 'deleteCustomer'])->middleware([TokenVerificationApiMiddleware::class]);
Route::get('/customer-by-id', [CustomerController::class, 'customerById'])->middleware([TokenVerificationApiMiddleware::class]);
Route::post('/update-customer', [CustomerController::class, 'updateCustomer'])->middleware([TokenVerificationApiMiddleware::class]);


//Product routes
Route::get('/product-list', [ProductController::class, 'productList'])->middleware([TokenVerificationApiMiddleware::class]);
Route::post('/create-product', [ProductController::class, 'createProduct'])->middleware([TokenVerificationApiMiddleware::class]);
Route::delete('/delete-product', [ProductController::class, 'deleteProduct'])->middleware([TokenVerificationApiMiddleware::class]);
Route::get('/product-by-id', [ProductController::class, 'productById'])->middleware([TokenVerificationApiMiddleware::class]);
Route::post('/update-product', [ProductController::class, 'updateProduct'])->middleware([TokenVerificationApiMiddleware::class]);

//Invoice routes
Route::post('/create-invoice', [InvoiceController::class, 'invoiceCreate'])->middleware([TokenVerificationApiMiddleware::class]);
Route::get('/select-invoice', [InvoiceController::class, 'invoiceSelect'])->middleware([TokenVerificationApiMiddleware::class]);
Route::delete('/delete-invoice', [InvoiceController::class, 'invoiceDelete'])->middleware([TokenVerificationApiMiddleware::class]);
Route::post('/invoice-details', [InvoiceController::class, 'invoiceDetails'])->middleware([TokenVerificationApiMiddleware::class]);
