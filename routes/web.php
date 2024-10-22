<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserControler;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ShopOrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\VariantProductController;
use App\Http\Controllers\BannerController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
// http://127.0.0.1:8000/
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'auth'
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
        Route::get('/', [ShopOrderController::class, 'index'])->name('index');

        Route::get('detail/{id}', [ShopOrderController::class, 'show'])->name('show');

        Route::put('update-status/{id}', [ShopOrderController::class, 'updateStatus'])->name('updateStatus');

        Route::delete('delete/{id}', [ShopOrderController::class, 'deleteOrder'])->name('delete');

        Route::delete('hard-delete/{id}', [ShopOrderController::class, 'hardDeleteOrder'])->name('hardDelete');

        Route::get('check-new-orders', [ShopOrderController::class, 'checkNewOrders']);

        Route::get('statistics', [ShopOrderController::class, 'statistics'])->name('statistics');

        Route::get('/export', [ShopOrderController::class, 'export'])->name('export');
      
        // thống kê đơn hàng
        Route::get('/statistics', [ShopOrderController::class, 'statistics'])->name('statistics');
    });

    Route::group([
        'prefix' => 'payments',
        'as' => 'payments.'
    ], function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');

        Route::get('show/{id}', [PaymentController::class, 'show'])->name('show'); // Xem chi tiết

        Route::get('export/{id}', [PaymentController::class, 'exportPDF'])->name('export'); // Xuất PDF

        Route::get('send-email/{id}', [PaymentController::class, 'sendInvoiceByEmail'])->name('sendEmail'); // Xem chi tiết
    });

    Route::group([
        'prefix' => 'colors',
        'as' => 'colors.'
    ], function () {

        Route::get('/', [ColorController::class, 'index'])->name('index'); // Danh sách màu sắc
        Route::get('/create', [ColorController::class, 'create'])->name('create'); // Tạo màu mới
        Route::post('/', [ColorController::class, 'store'])->name('store'); // Lưu màu mới
        Route::get('/{color}/edit', [ColorController::class, 'edit'])->name('edit'); // Sửa màu
        Route::put('/{color}', [ColorController::class, 'update'])->name('update'); // Cập nhật màu
        Route::delete('/{color}', [ColorController::class, 'destroy'])->name('destroy'); // Xóa màu
    });

    Route::group([
        'prefix' => 'variant-products',
        'as' => 'variant-products.'
    ], function () {

        Route::get('/statistics', [VariantProductController::class, 'statistics'])->name('statistics');
    });

    Route::resource('banners', BannerController::class);

    Route::resource('variant-products', VariantProductController::class);

    Route::resource('sizes', SizeController::class);

    Route::resource('users', UserControler::class);

    Route::resource('categories', CategoryController::class);

    Route::resource('customers', CustomerController::class);
});

Route::group([
    'prefix' => 'client',
    'as' => 'client.',
    'middleware' => 'auth'
], function () {

    Route::get('/index', [ClientController::class, 'index'])->name('index');
});


Route::middleware('role:super-admin')->group(function () {

    Route::get('/role-permission', [RolePermissionController::class, 'index'])->name('role-permission.index');

    Route::post('/roles/store', [RolePermissionController::class, 'store'])->name('roles.store');

    Route::post('/role-permission/assign-role', [RolePermissionController::class, 'assignRole'])->name('role-permission.assignRole');

    Route::post('/role-permission/assign-permission', [RolePermissionController::class, 'assignPermission'])->name('role-permission.assignPermission');
});
