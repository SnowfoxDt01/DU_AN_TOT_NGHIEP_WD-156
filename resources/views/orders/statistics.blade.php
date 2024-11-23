@extends('layout.admin.master')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Thống kê đơn hàng</h1>

    <div class="row">
        <!-- Doanh thu -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-header">Doanh thu</div>
                <div class="card-body">
                    <h5 class="card-title">Tổng doanh thu</h5>
                    <p class="card-text"><strong>{{ number_format($revenue, 0, ',', '.') }} VNĐ</strong></p>
                </div>
            </div>
        </div>

        <!-- Tổng số đơn hàng -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-info">
                <div class="card-header">Tổng số đơn hàng</div>
                <div class="card-body">
                    <h5 class="card-title">Số lượng đơn hàng</h5>
                    <p class="card-text"><strong>{{ $orderCount }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Tỉ lệ thành công -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-header">Tỉ lệ thành công</div>
                <div class="card-body">
                    <h5 class="card-title">Tỉ lệ thành công</h5>
                    <p class="card-text"><strong>{{ number_format($successRate, 2) }}%</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top người dùng đặt hàng nhiều nhất -->
    <div class="mb-4">
        <h2 class="text-primary">Top người dùng đặt hàng nhiều nhất</h2>
        <ul class="list-group">
            @foreach ($topUsers as $user)
                <li class="list-group-item">
                    Tên người dùng: <strong>{{$user->name}}</strong> - Số đơn hàng: <strong>{{$user->order_count}}</strong>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Top sản phẩm bán chạy nhất -->
    <div class="mb-4">
        <h2 class="text-primary">Top sản phẩm bán chạy nhất</h2>
        <ul class="list-group">
            @foreach ($topSellingProducts as $product)
                <li class="list-group-item">
                    Tên sản phẩm: <strong>{{$product->product_name}}</strong> - Tổng số bán: <strong>{{$product->total_sales}}</strong>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Số lượng đơn hàng theo trạng thái -->
    <div class="mb-4">
        <h2 class="text-primary">Số lượng đơn hàng theo trạng thái</h2>
        <ul class="list-group">
            @foreach ($ordersByStatus as $status)
                <li class="list-group-item">
                    Trạng thái: <strong>{{ App\Enums\OrderStatus::getDescription($status->order_status) }}</strong> - Số lượng: <strong>{{ $status->count }}</strong>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Xu hướng doanh thu -->
    <div class="mb-4">
        <h2 class="text-primary">Xu hướng doanh thu theo tháng</h2>
        <canvas id="revenueTrendChart"></canvas>
    </div>

    <!-- Nút quay lại -->
    <div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-success">Quay lại danh sách</a>
    </div>
    
    <!-- Script để hiển thị biểu đồ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueTrendChart').getContext('2d');
        const revenueData = {
            labels: @json($revenueTrend->pluck('month')),
            datasets: [{
                label: 'Doanh thu',
                data: @json($revenueTrend->pluck('total_revenue')),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        };

        const revenueTrendChart = new Chart(ctx, {
            type: 'line',
            data: revenueData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>
@endsection
