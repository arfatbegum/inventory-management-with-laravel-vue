<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenverificationMiddleware;
use Illuminate\Support\Facades\Route;


//user routes
Route::post('/registration', [UserController::class, 'userRegistration'])->name('userRegistration');
Route::post('/login', [UserController::class, 'userLogin'])->name('userLogin');
Route::get('/logout', [UserController::class, 'userLogout'])->name('userLogout');
Route::post('/send-otp', [UserController::class, 'sendOTPCode'])->name('sendOTPCode');
Route::post('/verify-otp', [UserController::class, 'verifyOTP'])->name('verifyOTP');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware([TokenverificationMiddleware::class]);
Route::get('/user-profile', [UserController::class, 'userProfile'])->middleware([TokenverificationMiddleware::class]);
Route::post('/update-profile', [UserController::class, 'updateProfile'])->middleware([TokenverificationMiddleware::class]);

//Category routes
Route::get('/category-list', [CategoryController::class, 'categoryList'])->middleware([TokenverificationMiddleware::class]);
Route::post('/create-category', [CategoryController::class, 'createCategory'])->middleware([TokenverificationMiddleware::class]);
Route::delete('/delete-category', [CategoryController::class, 'deleteCategory'])->middleware([TokenverificationMiddleware::class]);
Route::get('/category-by-id', [CategoryController::class, 'categoryById'])->middleware([TokenverificationMiddleware::class]);
Route::post('/update-category', [CategoryController::class, 'updateCategory'])->middleware([TokenverificationMiddleware::class]);


//Customer routes
Route::get('/customer-list', [CustomerController::class, 'customerList'])->middleware([TokenverificationMiddleware::class]);
Route::post('/create-customer', [CustomerController::class, 'createCustomer'])->middleware([TokenverificationMiddleware::class]);
Route::delete('/delete-customer', [CustomerController::class, 'deleteCustomer'])->middleware([TokenverificationMiddleware::class]);
Route::get('/customer-by-id', [CustomerController::class, 'customerById'])->middleware([TokenverificationMiddleware::class]);
Route::post('/update-customer', [CustomerController::class, 'updateCustomer'])->middleware([TokenverificationMiddleware::class]);

//Product routes
Route::get('/product-list', [ProductController::class, 'productList'])->middleware([TokenverificationMiddleware::class]);
Route::post('/create-product', [ProductController::class, 'createProduct'])->middleware([TokenverificationMiddleware::class]);
Route::delete('/delete-product', [ProductController::class, 'deleteProduct'])->middleware([TokenverificationMiddleware::class]);
Route::get('/product-by-id', [ProductController::class, 'productById'])->middleware([TokenverificationMiddleware::class]);
Route::post('/update-product', [ProductController::class, 'updateProduct'])->middleware([TokenverificationMiddleware::class]);

//Invoice routes
Route::post('/create-invoice', [InvoiceController::class, 'invoiceCreate'])->middleware([TokenverificationMiddleware::class]);
Route::get('/select-invoice', [InvoiceController::class, 'invoiceSelect'])->middleware([TokenverificationMiddleware::class]);
Route::delete('/delete-invoice', [InvoiceController::class, 'invoiceDelete'])->middleware([TokenverificationMiddleware::class]);
Route::post('/invoice-details', [InvoiceController::class, 'invoiceDetails'])->middleware([TokenverificationMiddleware::class]);


//Dasboard
Route::get('/summary', [DashboardController::class, 'summary'])->middleware([TokenverificationMiddleware::class]);
