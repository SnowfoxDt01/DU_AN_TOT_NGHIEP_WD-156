@extends('layout.admin.master')

@section('content')
    <section class="content-header">
        <h1>
            Chi tiết đơn hàng
            <small>Trang chủ</small>
        </h1>
        <ol class="breadcrumb">
            {{-- <li><a href=""><i class="fa fa-dashboard"></i>Home</a></li> --}}
            <li class="active">Đơn hàng</li>
        </ol>
    </section>
    <hr>
    <div class="container mt-5">
        <h1 class="mb-4">Chi tiết đơn hàng #{{ $order->id }}</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h3>Thông tin khách hàng</h3>
                <hr>
                <p class="card-text"><strong>Khách hàng:</strong> {{ $order->customer->name }}</p>
                <p class="card-text"><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
                </p>
                <p class="card-text"><strong>Phương thức thanh toán:</strong>
                    {{ ucfirst(App\Enums\PaymentMethod::getDescription($order->payment_method)) }}</p>
                <p class="card-text"><strong>Trạng thái:</strong>
                    {{ App\Enums\OrderStatus::getDescription($order->order_status) }}</p>
            </div>
        </div>

        <h2 class="mb-4">Sản phẩm trong đơn hàng</h2>
        <ul class="list-group mb-4">
            @foreach ($order->items as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $item->product->name }}</span>
                    <span>{{ $item->product ? $item->product->name : 'Chưa có tên sản phẩm' }}</span>
                    <img src="{{ asset($item->product->image) }}"
                        style="width: 100px; height: auto; margin-right: 10px;">
                    <span>Số lượng: {{ $item->quantity }}</span>
                    <span>Giá: {{ number_format($item->price, 0, ',', '.') }} VNĐ</span>
                </li>
            @endforeach
        </ul>

        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mb-4">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="order_status">Cập nhật trạng thái:</label>
                <select name="order_status" id="order_status" class="form-control">
                    @foreach (App\Enums\OrderStatus::getValues() as $value)
                        <option value="{{ $value }}" {{ $order->order_status == $value ? 'selected' : '' }}>
                            {{ App\Enums\OrderStatus::getDescription($value) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
