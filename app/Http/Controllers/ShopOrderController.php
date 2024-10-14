<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\ShopOrder;
use Illuminate\Http\Request;

class ShopOrderController extends Controller
{
    public function index()
    {
        $orders = ShopOrder::with('customer')->paginate(5);
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = ShopOrder::with('items.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = ShopOrder::findOrFail($id);
    
        $validated = $request->validate([
            'order_status' => ['required', 'in:' . implode(',', OrderStatus::getValues())],
        ]);
    
        $order->update([
            'order_status' => $validated['order_status'],
        ]);
    
        return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }
    
}
