<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ShopOrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Auth\Client\LoginController;
use App\Http\Controllers\Auth\Client\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\VariantProductController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// http://127.0.0.1:8000/


Route::get('/', [ClientController::class, 'index'])->name('client.index');

Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('password/forgot', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');

Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');

Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'role:super-admin|admin']
], function () {


    Route::group([
        'prefix' => 'reviews',
        'as' => 'reviews.'
    ], function () {

        Route::post('/toggle-visibility/{id}', [ReviewController::class, 'toggleVisibility'])->name('toggleVisibility');
    });

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
        'as' => 'orders.',
        // 'middleware' => ['auth', 'check.pending.order']
    ], function () {
        Route::get('/', [ShopOrderController::class, 'index'])->name('index');

        Route::get('detail/{id}', [ShopOrderController::class, 'show'])->name('show');

        Route::put('update-status/{id}', [ShopOrderController::class, 'updateStatus'])->name('updateStatus');

        Route::delete('delete/{id}', [ShopOrderController::class, 'deleteOrder'])->name('delete');

        Route::delete('hard-delete/{id}', [ShopOrderController::class, 'hardDeleteOrder'])->name('hardDelete');

        Route::get('check-new-orders', [ShopOrderController::class, 'checkNewOrders']);

        Route::get('statistics', [ShopOrderController::class, 'statistics'])->name('statistics');

        Route::get('/export', [ShopOrderController::class, 'export'])->name('export');
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

    Route::resource('users', UserController::class);

    Route::resource('categories', CategoryController::class);

    Route::resource('customers', CustomerController::class);

    Route::resource('vouchers', VoucherController::class);

    Route::resource('blogs', BlogController::class);
});

Route::group([
    'prefix' => 'client',
    'as' => 'client.'
], function () {

    Route::get('/detail/{id}', [ClientController::class, 'detailProduct'])->name('detailProduct');

    Route::get('/shop', [ClientController::class, 'shopProducts'])->name('shop');

    Route::get('/voucherList', [ClientController::class, 'voucherList'])->name('voucherList');

    Route::post('/order/{order}/cancel', [ClientController::class, 'cancelOrder'])->name('order.cancel');

    Route::get('/orders/{order}', [ClientController::class, 'orderDetail'])->name('order.detail');

    Route::get('/category/{id}', [ClientController::class, 'productsOfCategory'])->name('category');

    Route::get('/new', [ClientController::class, 'newProducts'])->name('new');

    Route::get('/top', [ClientController::class, 'topProducts'])->name('top');

    Route::get('/vnpay-return', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.return');

    Route::resource('addresses', AddressController::class);

    Route::get('client/createInfo', [ClientController::class, 'createInfo'])->name('createInfo');

    Route::post('client/createInfo', [ClientController::class, 'createCustomerInfo'])->name('createInfo');

    Route::put('client/{id}/updateInfo', [ClientController::class, 'updateCustomerInfo'])->name('updateInfo');

    Route::post('/save-tab', function (Request $request) {
        session(['active_tab' => $request->tab]);
        return response()->json(['success' => true]);
    })->name('save.tab');



    Route::group([
        'prefix' => 'myaccount',
        'as' => 'myaccount.',
        'middleware' => ['auth', 'check.pending.order']
    ], function () {
        Route::get('/', [ClientController::class, 'myAccount'])->name('myAccount');

        Route::post('/change-password', [UserController::class, 'checkChangePassWord'])->name('checkChangePassWord');

        Route::get('/orders/filter', [ShopOrderController::class, 'filter'])->name('orders.filter');
    });

    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.',
    ], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');

        Route::put('/update', [ProfileController::class, 'updateProfile'])->name('update');

        Route::post('/store', [ProfileController::class, 'store'])->name('store');
    });

    Route::group([
        'prefix' => 'blog',
        'as' => 'blog.',
    ], function () {
        Route::get('/index', [ClientController::class, 'blogList'])->name('index');

        Route::get('/detail/{id}', [ClientController::class, 'detailBlog'])->name('detailBlog');
    });

    Route::post('/products/review', [ReviewController::class, 'store'])->name('comment');

    Route::group([
        'prefix' => 'cart',
        'as' => 'cart.',
    ], function () {
        Route::get('/', [ShoppingCartController::class, 'index'])->name('index');

        Route::post('/add', [ShoppingCartController::class, 'add'])->name('add');

        Route::post('/{item}/update', [ShoppingCartController::class, 'update'])->name('update');

        Route::delete('/{item}/remove', [ShoppingCartController::class, 'remove'])->name('remove');

        Route::post('/cart/save-session', [ShoppingCartController::class, 'saveSelectedItems'])->name('saveSession');

    });

    Route::group([
        'prefix' => 'checkout',
        'as' => 'checkout.',
    ], function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');

        Route::post('/', [CheckoutController::class, 'index'])->name('index');

        Route::post('/process', [CheckoutController::class, 'process'])->name('process');

        Route::post('/apply-voucher', [CheckoutController::class, 'applyVoucher'])->name('applyVoucher');

        Route::post('/vnpay_payment', [CheckoutController::class, 'redirectToVnpay'])->name('redirectToVnpay');
    });
});


Route::middleware('role:super-admin')->group(function () {

    Route::get('/role-permission', [RolePermissionController::class, 'index'])->name('role-permission.index');

    Route::post('/roles/store', [RolePermissionController::class, 'store'])->name('roles.store');

    Route::post('/permissions/create', [RolePermissionController::class, 'createPermission'])->name('permissions.create');

    Route::post('/role-permission/assign-role', [RolePermissionController::class, 'assignRole'])->name('role-permission.assignRole');

    Route::post('/role-permission/assign-permission', [RolePermissionController::class, 'assignPermission'])->name('role-permission.assignPermission');
});
