<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SessionAuthenticate;
use Illuminate\Support\Facades\Route;



//Laravel Vue Page Routing
Route::get('/', [HomeController::class, 'Home'])->name('Home');
Route::get('/registration', [UserController::class, 'Registration'])->name('Registration');
Route::get('/login', [UserController::class, 'Login'])->name('Login');
Route::get('/send-otp', [UserController::class, 'SendOTPPage'])->name('SendOTPPage');
Route::get('/verify-otp', [UserController::class, 'VerifyOTPPage'])->name('VerifyOTPPage');
Route::get('/reset-password', [UserController::class, 'ResetPasswordPage'])->name('ResetPasswordPage');

//Laravel Vue Page Routing For Dashboard
Route::get('/dashboard', [DashboardController::class, 'Dashboard'])->name('Dashboard')->middleware([SessionAuthenticate::class]);
Route::get('/category', [CategoryController::class, 'Category'])->name('Category')->middleware([SessionAuthenticate::class]);
Route::get('/create-and-update-category', [CategoryController::class, 'CreateAndUpdateCategoryPage'])->name('CreateAndUpdateCategoryPage')->middleware([SessionAuthenticate::class]);
Route::get('/customer', [DashboardController::class, 'Customer'])->name('Customer')->middleware([SessionAuthenticate::class]);
Route::get('/product', [DashboardController::class, 'Product'])->name('Product')->middleware([SessionAuthenticate::class]);
Route::get('/invoice', [DashboardController::class, 'Invoice'])->name('Invoice')->middleware([SessionAuthenticate::class]);
Route::get('/sale', [DashboardController::class, 'Sale'])->name('Sale')->middleware([SessionAuthenticate::class]);
Route::get('/profile', [DashboardController::class, 'Profile'])->name('Profile')->middleware([SessionAuthenticate::class]);

//user routes
Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('userRegistration');
Route::post('/login', [UserController::class, 'userLogin'])->name('userLogin');
Route::get('/logout', [UserController::class, 'userLogout'])->name('userLogout');
Route::post('/send-otp', [UserController::class, 'sendOTP'])->name('sendOTP');
Route::post('/verify-otp', [UserController::class, 'verifyOTP'])->name('verifyOTP');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('resetPassword');
Route::get('/user-profile', [UserController::class, 'userProfile'])->middleware([SessionAuthenticate::class]);
Route::post('/update-profile', [UserController::class, 'updateProfile'])->middleware([SessionAuthenticate::class]);

//Category routes
Route::get('/category-list', [CategoryController::class, 'categoryList'])->middleware([SessionAuthenticate::class]);
Route::post('/create-category', [CategoryController::class, 'createCategory'])->middleware([SessionAuthenticate::class]);
Route::delete('/delete-category/{id}', [CategoryController::class, 'deleteCategory'])->middleware([SessionAuthenticate::class]);
Route::get('/category-by-id', [CategoryController::class, 'categoryById'])->middleware([SessionAuthenticate::class]);
Route::post('/update-category', [CategoryController::class, 'updateCategory'])->middleware([SessionAuthenticate::class]);


//Customer routes
Route::get('/customer-list', [CustomerController::class, 'customerList'])->middleware([SessionAuthenticate::class]);
Route::post('/create-customer', [CustomerController::class, 'createCustomer'])->middleware([SessionAuthenticate::class]);
Route::delete('/delete-customer', [CustomerController::class, 'deleteCustomer'])->middleware([SessionAuthenticate::class]);
Route::get('/customer-by-id', [CustomerController::class, 'customerById'])->middleware([SessionAuthenticate::class]);
Route::post('/update-customer', [CustomerController::class, 'updateCustomer'])->middleware([SessionAuthenticate::class]);

//Product routes
Route::get('/product-list', [ProductController::class, 'productList'])->middleware([SessionAuthenticate::class]);
Route::post('/create-product', [ProductController::class, 'createProduct'])->middleware([SessionAuthenticate::class]);
Route::delete('/delete-product', [ProductController::class, 'deleteProduct'])->middleware([SessionAuthenticate::class]);
Route::get('/product-by-id', [ProductController::class, 'productById'])->middleware([SessionAuthenticate::class]);
Route::post('/update-product', [ProductController::class, 'updateProduct'])->middleware([SessionAuthenticate::class]);

//Invoice routes
Route::post('/create-invoice', [InvoiceController::class, 'invoiceCreate'])->middleware([SessionAuthenticate::class]);
Route::get('/select-invoice', [InvoiceController::class, 'invoiceSelect'])->middleware([SessionAuthenticate::class]);
Route::delete('/delete-invoice', [InvoiceController::class, 'invoiceDelete'])->middleware([SessionAuthenticate::class]);
Route::post('/invoice-details', [InvoiceController::class, 'invoiceDetails'])->middleware([SessionAuthenticate::class]);


//Dasboard
//Route::get('/summary', [DashboardController::class, 'summary'])->middleware([SessionAuthenticate::class]);
