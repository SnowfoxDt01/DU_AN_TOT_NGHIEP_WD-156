<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserControler;

Route::get('/', function(){
    echo 'abc';
 });

route::get('list-product', [ProductController::class, 'show']);

route::get('get-product/{id}', [ProductController::class, 'getProduct']);

route::get('update-product', [ProductController::class, 'updateProduct']);

Route::resource('users', UserControler::class);
