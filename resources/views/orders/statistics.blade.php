@extends('layout.admin.master')

@section('content')
<div class="container">
    <h1>Thống Kê Đơn Hàng</h1>

    <h2>Doanh Thu</h2>
    <p>Tổng doanh thu: {{ number_format($revenue, 0, ',', '.') }} VNĐ</p>

    <h2>Top Người Dùng Đặt Hàng Nhiều Nhất</h2>
    <ul>
        @foreach($topUsers as $user)
            <li>Tên người dùng: {{ $user->name }} - Số đơn hàng: {{ $user->order_count }}</li>
        @endforeach
    </ul>

    <h2>Top Sản Phẩm Bán Chạy Nhất</h2>
    <ul>
        @foreach($topSellingProducts as $product)
            <li>Product ID: {{ $product->product_id }} - Tổng số bán: {{ $product->total_sales }}</li>
        @endforeach
    </ul>

    <h2>Tổng Số Đơn Hàng</h2>
    <p>Số lượng đơn hàng: {{ $orderCount }}</p>

    <h2>Tỉ Lệ Thành Công Đơn Hàng</h2>
    <p>Tỉ lệ thành công: {{ number_format($successRate, 2) }}%</p>
</div>
<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
@endsection
