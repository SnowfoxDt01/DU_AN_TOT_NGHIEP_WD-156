<?php

// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $shoppingCart = auth()->user()->shoppingCart;

        $customer = Auth::user()->customer->first();

        if (!$shoppingCart) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng của bạn hiện tại trống.');
        }

        return view('checkout.index', compact('shoppingCart', 'customer'));
    }
}
