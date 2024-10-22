@extends('layout.admin.master')
@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Thống kê đơn hàng</h1>

    <!-- Doanh thu -->
    <div class="mb-4">
        <h2 class="text-primary">Doanh thu</h2>
        <div class="list-group">
            <div class="list-group-item">
                <p class="mb-0">Tổng doanh thu: <strong>{{ number_format($revenue, 0, ',', '.') }} VNĐ</strong></p>
            </div>
        </div>
    </div>

    <!-- Top người dùng đặt hàng nhiều nhất -->
    <div class="mb-4">
        <h2 class="text-primary">Top người dùng đặt hàng nhiều nhất</h2>
        <ul class="list-group">
            @foreach ($topUsers as $user)
                <li class="list-group-item">
                    Tên người dùng : {{$user->name}} - Số đơn hàng: {{$user->order_count}}
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
                    Tên sản phẩm: {{$product->product_name}} - Tổng số bán: {{$product->total_sales}}
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Tổng số đơn hàng -->
    <div class="mb-4">
        <h2 class="text-primary">Tổng số đơn hàng</h2>
        <ul class="list-group">
            <li class="list-group-item">
                <p class="mb-0">Số lượng đơn hàng: <strong>{{$orderCount}}</strong></p>
            </li>
        </ul>
    </div>

    <!-- Tỉ lệ thành công -->
    <div class="mb-4">
        <h2 class="text-primary">Tỉ lệ thành công</h2>
        <ul class="list-group">
            <li class="list-group-item">
                <p class="mb-0">Tỉ lệ thành công: <strong>{{ number_format($successRate, 2) }}%</strong></p>
            </li>
        </ul>
    </div>

    <!-- Nút quay lại -->
    <div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-success">Quay lại danh sách</a>
    </div>
</div>
@endsection
