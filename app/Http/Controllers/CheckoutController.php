<?php

// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopOrder;
use App\Models\ShopOrderItem;

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

    public function process(Request $request)
    {
        $paymentMethod = $request->input('payment_method');

        // Lấy thông tin giỏ hàng
        $shoppingCart = auth()->user()->shoppingCart;

        // Tính tổng giá trị giỏ hàng
        $cartTotal = $shoppingCart->items->sum(function ($item) {
            $price = $item->product->sale_price > 0 
                ? $item->product->sale_price 
                : $item->product->base_price;
            return $price * $item->quantity;
        });

        // Tạo đơn hàng mới
        $order = new ShopOrder();
        $order->user_id = Auth::id();
        $order->customer_id = auth()->user()->id;
        $order->total_price = $cartTotal; // Sử dụng $cartTotal đã tính ở trên
        $order->payment_method = $paymentMethod;
        $order->shipping_address = auth()->user()->customer->first()->address;
        $order->shipping_id = 1;
        $order->save();

        // Lưu chi tiết đơn hàng
        foreach ($shoppingCart->items as $item) {
            $orderItem = new ShopOrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->product->id; 

            // Lấy variant_id từ relationship variantProduct của item
            $orderItem->variant_id = $item->variantProduct->id; 

            $orderItem->quantity = $item->quantity;
            $orderItem->price = $item->product->sale_price > 0 
                ? $item->product->sale_price 
                : $item->product->base_price;
            $orderItem->save();
        }

        // Xóa giỏ hàng
        $shoppingCart->items()->delete();

        // Chuyển hướng người dùng
        if ($paymentMethod === 'cash') {
            return redirect()->route('client.cart.index')->with('message', 'Đơn hàng của bạn đã được đặt thành công!'); // Thay 'client.order.success' bằng route hiển thị đơn hàng thành công
        } else {
            return redirect()->route('client.payment.wallet'); // Thay 'client.payment.wallet' bằng route trang thanh toán ví
        }
    }

}
