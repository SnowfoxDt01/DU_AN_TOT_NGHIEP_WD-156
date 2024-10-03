<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function(){
    echo 'abc';
 });

route::get('list-product', [ProductController::class, 'show']);
route::get('get-product/{id}', [ProductController::class, 'getProduct']);
route::get('update-product', [ProductController::class, 'updateProduct']);