<?php

namespace App\Http\Controllers;

use App\Models\ShopOrder;
use App\Models\ShopOrderItem;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Exports\ShopOrderExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderStatusTransitions;
use Carbon\Carbon;

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

        $orders = $query->orderBy('created_at', 'desc')->paginate(5);

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

        // Lấy trạng thái hiện tại và trạng thái mới từ yêu cầu  
        $currentStatus = $order->order_status;
        $newStatus = $request->input('order_status');

        // Kiểm tra xem chuyển đổi trạng thái có hợp lệ không  
        if (OrderStatusTransitions::canTransition($currentStatus, $newStatus)) {
            // Tạo mảng dữ liệu cập nhật  
            $updateData = ['order_status' => $newStatus];

            // Nếu trạng thái mới là "canceled", thêm lý do hủy  
            if ($newStatus == 'canceled') {
                $request->validate([
                    'cancel_reason' => 'required|string|max:255',
                ], [
                    'cancel_reason.required' => 'Vui lòng nhập lý do hủy đơn hàng.'
                ]);
                $updateData['cancel_reason'] = $request->input('cancel_reason');
            }

            // Cập nhật đơn hàng  
            $order->update($updateData);

            // Nếu trạng thái mới là "completed", tạo giao dịch thanh toán và chuyển hướng đến trang hóa đơn  
            if ($newStatus == 'completed') {
                if (!$order->payment) {
                    PaymentController::createPayment([
                        'order_id' => $order->id,
                        'user_id' => $order->user_id,
                    ]);
                }
                return redirect()->route('admin.payments.index', $order->id)->with('success', 'Đơn hàng đã hoàn thành. Hóa đơn đã được tạo.');
            }

            return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
        } else {
            // Trạng thái không hợp lệ, chuyển hướng với thông báo lỗi  
            return redirect()->route('admin.orders.index')->with('error', 'Chuyển đổi trạng thái đơn hàng không hợp lệ.');
        }
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
    public function statistics(Request $request)
    {
        // Lấy dữ liệu thống kê tổng số đơn hàng, theo trạng thái đơn hàng
        $revenue = $this->getRevenue($request);
        $topUsers = $this->getTopUsers($request);
        $topSellingProducts = $this->getTopSellingProducts($request);
        $orderCount = $this->getOrderCount($request);
        $successRate = $this->getOrderSuccessRate($request);
        $ordersByStatus = $this->getOrdersByStatus($request);
        $revenueTrend = $this->getRevenueTrend($request);
        // Trả về view với dữ liệu thống kê
        return view('orders.statistics', compact('revenue', 'topUsers', 'topSellingProducts', 'orderCount', 'successRate', 'ordersByStatus', 'revenueTrend'));
    }

    private function getRevenue()
    {
        return ShopOrder::sum('total_price');
    }

    private function getTopUsers()
    {
        return ShopOrder::select('users.name', 'shop_order.user_id', DB::raw('count(*) as order_count'))
            ->join('users', 'shop_order.user_id', '=', 'users.id')
            ->groupBy('shop_order.user_id', 'users.name')
            ->orderBy('order_count', 'desc')
            ->take(5)
            ->get();
    }

    private function getTopSellingProducts()
    {
        return ShopOrderItem::select('products.name as product_name', DB::raw('sum(shop_order_items.quantity) as total_sales'))
            ->join('products', 'shop_order_items.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sales', 'desc')
            ->take(5)
            ->get();
    }

    private function getOrderCount()
    {
        return ShopOrder::count();
    }

    private function getOrderSuccessRate()
    {
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

    private function getOrdersByStatus()
    {
        return ShopOrder::select('order_status', DB::raw('count(*) as count'))
            ->groupBy('order_status')
            ->get();
    }

    private function getRevenueTrend()
    {
        // Lấy doanh thu theo tháng
        return ShopOrder::select(DB::raw('DATE_FORMAT(date_order, "%Y-%m") as month'), DB::raw('SUM(total_price) as total_revenue'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function export()
    {
        return Excel::download(new ShopOrderExport, 'shop_orders.xlsx');
    }

    public function getOrderStatus($id)
    {
        $order = ShopOrder::findOrFail($id);
    
        return response()->json([
            'order_status' => $order->order_status,
        ]);
    }
}
