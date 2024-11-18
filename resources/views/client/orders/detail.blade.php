@extends('layout.client.master')
@section('content')
    <section class="page-banner bg-image pt-130 pb-130" data-background="assets/images/banner/inner-banner.jpg">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Chi tiết đơn hàng</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Trang chủ
                    <i class="fa-regular text-white fa-angle-right"></i></a>
                <span>Chi tiết đon hàng</span>
            </div>
        </div>
    </section>
    <hr>
    <div class="container py-4">
        <h2>Chi tiết đơn hàng</h2>
        <div class="order-details mt-4">
            <!-- Thông tin chung -->
            <div class="mb-4">
                <h5>Thông tin đơn hàng</h5>
                <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('H:i - d/m/Y') }}</p>
                <p><strong>Trạng thái:
                        {{ App\Enums\OrderStatus::getDescription($order->order_status) }}
                    </strong>
                </p>
                <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }}đ</p>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="mb-4">
                <h5>Sản phẩm trong đơn hàng</h5>
                <table class="table table-bordered" style="background-color: black; color: #fff">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>
                                    <img src="{{ $item->product->images->first()?->image_path ?? 'default.jpg' }}"
                                        alt="{{ $item->product->name }}" class="img-thumbnail" style="width: 80px;">
                                    {{ $item->product->name }}
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Thông tin khách hàng -->
            <div class="mb-4">
                <h5>Thông tin khách hàng</h5>
                <p><strong>Tên:</strong> {{ $order->user->name }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->customer->phone }}</p>
            </div>

            <!-- Hành động -->
            <div class="actions d-flex gap-3">
                @if (in_array($order->order_status, ['confirming', 'confirmed']))
                    <form action="{{ route('client.order.cancel', $order->id) }}" method="POST"
                        onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng?')">
                        @csrf
                        <button class="btn btn-danger">Hủy đơn hàng</button>
                    </form>
                @endif
                <a href="" class="btn btn-orange">In hóa đơn</a>
                <a href="" class="btn btn-secondary">Liên hệ hỗ trợ</a>
            </div>
        </div>
    </div>
@endsection
