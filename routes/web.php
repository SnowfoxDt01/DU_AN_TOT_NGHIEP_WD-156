<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserControler;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ShopOrderController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {

    Route::group([
        'prefix' => 'products',
        'as' => 'products.'
    ], function () {
        // CRUD products (list, add, update, detail, delete)
        Route::get('/', [ProductController::class, 'listProduct'])->name('listProduct');

        Route::get('add-product', [ProductController::class, 'addProduct'])->name('addProduct');

        Route::post('add-product', [ProductController::class, 'addPostProduct'])->name('addPostProduct');
        // xóa mền
        Route::delete('delete/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
        // xóa cứng
        Route::delete('hard-delete/{id}', [ProductController::class, 'hardDeleteProduct'])->name('hardDeleteProduct');

        Route::get('edit/{id}', [ProductController::class, 'editProduct'])->name('editProduct');

        Route::put('update/{id}', [ProductController::class, 'updateProduct'])->name('updateProduct');

        Route::get('detail/{id}', [ProductController::class, 'detailProduct'])->name('detailProduct');
    });

    Route::group([
        'prefix' => 'orders',
        'as' => 'orders.'
    ], function () {
        Route::get('/', [ShopOrderController::class, 'index'])->name('index'); // Hiển thị danh sách đơn hàng
        Route::get('detail/{id}', [ShopOrderController::class, 'show'])->name('show'); // Hiển thị chi tiết đơn hàng
        Route::put('update-status/{id}', [ShopOrderController::class, 'updateStatus'])->name('updateStatus'); // Cập nhật trạng thái đơn hàng
        Route::delete('delete/{id}', [ShopOrderController::class, 'deleteOrder'])->name('delete'); // Xóa đơn hàng mềm
        Route::delete('hard-delete/{id}', [ShopOrderController::class, 'hardDeleteOrder'])->name('hardDelete'); // Xóa đơn hàng cứng
    });

    Route::resource('categories', CategoryController::class);
});


Route::middleware('role:super-admin')->group(function () {

    Route::get('/role-permission', [RolePermissionController::class, 'index'])->name('role-permission.index');

    Route::post('/roles/store', [RolePermissionController::class, 'store'])->name('roles.store');

    Route::post('/role-permission/assign-role', [RolePermissionController::class, 'assignRole'])->name('role-permission.assignRole');

    Route::post('/role-permission/assign-permission', [RolePermissionController::class, 'assignPermission'])->name('role-permission.assignPermission');

    Route::resource('users', UserControler::class);
});
