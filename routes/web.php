<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserControler;
use Illuminate\Support\Facades\Auth;

Route::get('/', function(){
    return view('auth.login');
 });

Auth::routes();

Route::resource('/users', UserControler::class);

route::get('list-product', [ProductController::class, 'show']);

route::get('get-product/{id}', [ProductController::class, 'getProduct']);

route::get('update-product', [ProductController::class, 'updateProduct']);

Route::middleware('role:super-admin')->group(function () {

    Route::get('/role-permission', [RolePermissionController::class, 'index'])->name('role-permission.index');

    Route::post('/roles/store', [RolePermissionController::class, 'store'])->name('roles.store');

    Route::post('/role-permission/assign-role', [RolePermissionController::class, 'assignRole'])->name('role-permission.assignRole');

    Route::post('/role-permission/assign-permission', [RolePermissionController::class, 'assignPermission'])->name('role-permission.assignPermission');

    Route::resource('users', UserControler::class);
});

