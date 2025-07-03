<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TwoFactorController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[SiteController::class,'getLogin'])->name('login');
Route::get('/register',[SiteController::class,'getRegister']);
Route::post('post-login',[SiteController::class,'postLogin']);
Route::post('post-register',[SiteController::class,'postRegisgter']);
Route::middleware('userAuth')->group(function(){
    Route::get('/dashbard',[SiteController::class,'getDashboard'])->name('dashboard');
    Route::get('get-product',[SiteController::class,'getProduct'])->name('product');
    Route::post('logout',[SiteController::class,'postLogout']);
    Route::post('add-product',[SiteController::class,'postAddProduct'])->name('add-product');    
    Route::post('get-product-data',[SiteController::class,'getProductData'])->name('get-product-data');
    Route::post('product-update',[SiteController::class,'ProductUpdate'])->name('product-update');
    Route::get('get-profile',[SiteController::class,'getProfile'])->name('profile');
        
});
Route::get('/2fa/setup', [TwoFactorController::class, 'setup'])->name('2fa.setup');
Route::get('/2fa/disable', [TwoFactorController::class, 'showDisableForm'])->name('2fa.disable.form');
Route::post('/2fa/enable', [TwoFactorController::class, 'enable'])->name('2fa.enable');
Route::post('/2fa/disable', [TwoFactorController::class, 'disable'])->name('2fa.disable');
// Route::middleware(['auth'])->group(function () {
// // });

Route::middleware(['auth', '2fa'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/2fa', function () {
        return redirect()->intended('/home');
    })->name('2fa');
});