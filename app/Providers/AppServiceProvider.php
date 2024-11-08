<?php

namespace App\Providers;

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
    }
}
