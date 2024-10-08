<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserControler;
use Illuminate\Support\Facades\Auth;

Route::get('/', function(){
    return view('auth.login');
 });

 Auth::routes();

route::get('list-product', [ProductController::class, 'show']);

route::get('get-product/{id}', [ProductController::class, 'getProduct']);

route::get('update-product', [ProductController::class, 'updateProduct']);

Route::resource('users', UserControler::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
