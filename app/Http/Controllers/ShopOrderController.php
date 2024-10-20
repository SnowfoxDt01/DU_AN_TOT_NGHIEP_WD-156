<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Events\NewOrderCreated;
use App\Models\ShopOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PaymentController;

class ShopOrderController extends Controller
{
    public function index(Request $request)
{
    $query = ShopOrder::with('customer');

    // Lọc theo trạng thái đơn hàng nếu có
    if ($request->has('order_status') && $request->order_status != '') {
        $query->where('order_status', $request->order_status);
    }

    // Lọc theo khoảng thời gian (Từ ngày - Đến ngày)
    if ($request->has('start_date') && $request->start_date != '') {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->has('end_date') && $request->end_date != '') {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    // Paginate kết quả
    $orders = $query->paginate(5);

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

        // Kiểm tra nếu đơn hàng đã hoàn thành, thì tạo bản ghi thanh toán
        if ($validated['order_status'] == OrderStatus::COMPLETED) {
            if (!$order->payment) {
                PaymentController::createPayment([
                    'order_id' => $order->id,
                    'user_id' => $order->user_id, // Use user_id from ShopOrder
                ]);
            }
            return redirect()->route('admin.payments.index')->with('success', 'Đơn hàng đã hoàn thành, chuyển sang trang hóa đơn.');
        }

        return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }

    public function checkNewOrders()
    {
        $newOrders = ShopOrder::with('customer')->where('order_status', OrderStatus::CONFIRMING)->get();

        return response()->json([
            'newOrders' => $newOrders->count(),
            'orders' => $newOrders
        ]);
    }
}
