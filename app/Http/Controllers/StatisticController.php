<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class StatisticController extends Controller
{
    public function revenue(Request $request)
    {
        // Lấy doanh thu theo khoảng thời gian
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        
        $revenue = ShopOrder::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price'); // Giả sử bạn có trường total_price trong bảng orders
        
        return response()->json(['revenue' => $revenue]);
    }

    public function topUsers(Request $request)
    {
        // Thống kê 5 hoặc 10 user đặt hàng nhiều nhất
        $topUsers = ShopOrder::select('user_id', DB::raw('count(*) as total_orders'))
            ->groupBy('user_id')
            ->orderBy('total_orders', 'desc')
            ->take(10)
            ->get();

        return response()->json($topUsers);
    }

    public function topProducts(Request $request)
    {
        // Thống kê 5 hoặc 10 sản phẩm bán chạy nhất
        $topProducts = ShopOrder::with('products') // Giả sử có quan hệ với bảng sản phẩm
            ->select('product_id', DB::raw('count(*) as total_sales'))
            ->groupBy('product_id')
            ->orderBy('total_sales', 'desc')
            ->take(10)
            ->get();

        return response()->json($topProducts);
    }

    public function orders(Request $request)
    {
        // Thống kê đơn hàng theo khoảng thời gian
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();

        return response()->json($orders);
    }

    public function successRate()
    {
        // Thống kê tỉ lệ thành công của đơn hàng
        $totalOrders = Order::count();
        $successfulOrders = Order::where('status', 'success')->count(); // Giả sử có trường status

        $successRate = $successfulOrders / $totalOrders * 100;

        return response()->json(['success_rate' => $successRate]);
    }
}
