<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ShopOrder;
use App\Models\ShopOrderItem;
use App\Models\TotalOrders;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Events\NewOrderCreated;
use App\Exports\ShopOrderExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\PaymentController;

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
    //Thống Kê Đơn DH
    public function statistics( Request $request)
    {
        // Lấy dữ liệu thống kê tổng số đơn hàng, theo trạng thái đơn hàng
        $revenue = $this-> getRevenue($request);
        $topUsers = $this->getTopUsers($request);
        $topSellingProducts = $this->getTopSellingProducts($request);
        $orderCount = $this->getOrderCount($request);
        $successRate = $this->getOrderSuccessRate($request);
       
        // Trả về view với dữ liệu thống kê
        return view('orders.statistics', compact('revenue', 'topUsers', 'topSellingProducts','orderCount','successRate'));
    }
    private function getRevenue(Request $request){
        return ShopOrder::sum('total_price');
    }
    private function getTopUsers(Request $request){
        return ShopOrder::select('users.name','shop_order.user_id', DB::raw('count(*) as order_count'))
        ->join('users', 'shop_order.user_id', '=','users.id')
        ->groupBy('shop_order.user_id','users.name')
        ->orderBy('order_count','desc')
        ->take(10)
        ->get();
    }
    private function getTopSellingProducts(Request $request){
        return ShopOrderItem::select('product_id', DB::raw('sum(quantity) as total_sales'))
        ->groupBy('product_id')
        ->orderBy('total_sales', 'desc')
        ->take(10)
        ->get();
    }
    private function getOrderCount(Request $request){
        return ShopOrder::count();
    }
    private function getOrderSuccessRate(Request $request) {
        $totalOrders = ShopOrder::count();
        $successfulOrders = ShopOrder::where('order_status', 'completed')->count();
        if ($totalOrders > 0) {
            $successRate = ($successfulOrders / $totalOrders) * 100;
        } else {
            $successRate = 0;
        }
    
        // Trả về tỷ lệ thành công
        return $successRate;
    }
    public function export()
    {
        return Excel::download(new ShopOrderExport, 'shop_orders.xlsx');
    }
}
