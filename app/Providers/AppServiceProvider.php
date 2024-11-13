<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        View::share('categories', Category::all());

        view()->composer('*', function ($view) {
            $cartQuantity = 0;
            if (auth()->check()) {
                $cart = ShoppingCart::where('user_id', auth()->id())->first();
                $cartQuantity = $cart ? $cart->items()->sum('quantity') : 0;
            }
            $view->with('cartQuantity', $cartQuantity);
        });

        View::composer('*', function ($view) {
            $gioiThieu = Blog::where('title', 'Giới thiệu về Vsneaker Shop')->first();
            $huongDanSize = Blog::where('title', 'Bạn đang khó khăn trong việc chọn size giày? Và đây chính là giải pháp dành cho bạn !!!')->first();

            // Lấy URL của các bài viết, hoặc đặt URL mặc định nếu không tìm thấy bài viết
            $gioiThieuUrl = $gioiThieu ? route('client.blog.detailBlog', ['id' => $gioiThieu->id]) : '#';
            $huongDanSizeUrl = $huongDanSize ? route('client.blog.detailBlog', ['id' => $huongDanSize->id]) : '#';

            // Chia sẻ biến này cho tất cả các view
            $view->with('gioiThieuUrl', $gioiThieuUrl)
                ->with('huongDanSizeUrl', $huongDanSizeUrl);
        });
    }
}
