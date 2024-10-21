<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Events\NewOrderCreated;
use App\Models\ShopOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PaymentController;
use App\Exports\ShopOrderExport;
use App\Models\ShopOrderItem;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ShopOrderController extends Controller
{
    public function index(Request $request)
{
    $query = ShopOrder::with('customer');

    if ($request->has('order_status') && $request->order_status != '') {
        $query->where('order_status', $request->order_status);
    }

    if ($request->has('start_date') && $request->start_date != '') {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->has('end_date') && $request->end_date != '') {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    if ($request->has('phone') && $request->phone != '') {
        $query->whereHas('customer', function ($q) use ($request) {
            $q->where('phone', 'like', '%' . $request->phone . '%');
        });
    }

    if ($request->has('email') && $request->email != '') {
        $query->whereHas('customer', function ($q) use ($request) {
            $q->where('email', 'like', '%' . $request->email . '%');
        });
    }

    if ($request->has('customer_name') && $request->customer_name != '') {
        $query->whereHas('customer', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->customer_name . '%');
        });
    }

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

        if ($validated['order_status'] == OrderStatus::COMPLETED) {
            if (!$order->payment) {
                PaymentController::createPayment([
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
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

    public function export()
    {
        return Excel::download(new ShopOrderExport, 'shop_orders.xlsx');
    }

    public function statistics(Request $request) {
        // Lấy dữ liệu thống kê
        $revenue = $this->getRevenue($request);
        $topUsers = $this->getTopUsers($request);
        $topSellingProducts = $this->getTopSellingProducts($request);
        $orderCount = $this->getOrderCount($request);
        $successRate = $this->getOrderSuccessRate($request);
        
        return view('orders.statistics', compact('revenue', 'topUsers', 'topSellingProducts',
         'orderCount', 'successRate'));
    }

    private function getRevenue(Request $request) {
        // Logic để tính doanh thu
        return ShopOrder::sum('total_price'); // Giả sử có trường total_amount trong shop_orders
    }

    private function getTopUsers(Request $request) {
        // Logic để lấy top users với tên từ bảng users
        return ShopOrder::select('users.name', 'shop_order.user_id', DB::raw('count(*) as order_count'))
            ->join('users', 'shop_order.user_id', '=', 'users.id') // Join với bảng users
            ->groupBy('shop_order.user_id', 'users.name') // Nhóm theo user_id và name
            ->orderBy('order_count', 'desc')
            ->take(10)
            ->get();
    }
    

    private function getTopSellingProducts(Request $request) {
        // Logic để lấy top sản phẩm bán chạy nhất
        return ShopOrderItem::select('product_id', DB::raw('sum(quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderBy('total_sales', 'desc')
            ->take(10)
            ->get();
    }

    private function getOrderCount(Request $request) {
        // Logic để đếm số đơn hàng
        return ShopOrder::count();
    }

    private function getOrderSuccessRate(Request $request) {
        // Logic để tính tỉ lệ thành công
        $totalOrders = ShopOrder::count();
        $successfulOrders = ShopOrder::where('order_status', 'completed')->count(); // Giả sử có trường status
        return $totalOrders ? ($successfulOrders / $totalOrders) * 100 : 0;
    }
}
