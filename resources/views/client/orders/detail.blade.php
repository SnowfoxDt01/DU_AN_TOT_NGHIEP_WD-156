@extends('layout.client.master')
@section('content')
    <!-- Banner -->
    <section class="page-banner bg-image pt-130 pb-130" data-background="assets/images/banner/inner-banner.jpg">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Chi tiết đơn hàng</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{ route('client.index') }}" class="primary-hover text-orange">
                    <i class="fa-solid fa-house me-1"></i> Trang chủ
                    <i class="fa-regular fa-angle-right text-white"></i>
                </a>
                <span class="text-light">Chi tiết đơn hàng</span>
            </div>
        </div>
    </section>
    <hr class="divider" style="border-color: #ff7300;">

    <div class="container py-4">
        <div class="row">
            <div class="col-md-4">
                <!-- Thông tin chung -->
                <div class="order-info mt-4">
                    <h3 class="text-orange mb-3">Thông tin đơn hàng: </h3>
                    <p><strong>Mã đơn hàng:</strong> <span class="text-light">{{ $order->id }}</span></p>
                    <p><strong>Ngày đặt:</strong> <span
                            class="text-light">{{ $order->created_at->format('H:i - d/m/Y') }}</span>
                    </p>
                    @if ($order->order_status == 'canceled')
                        <p><strong>Trạng thái:</strong> <span class="text-danger">
                                {{ App\Enums\OrderStatus::getDescription($order->order_status) }}
                            </span></p>
                    @else
                        <p><strong>Trạng thái:</strong> <span class="text-success">
                                {{ App\Enums\OrderStatus::getDescription($order->order_status) }}
                            </span></p>
                    @endif
                    <p><strong>Số tiền được giảm:</strong> <span
                            class="text-danger">-{{ number_format($discountAmount, 0, ',', '.') }}.đ</span></p>
                    <p><strong>Tổng tiền thanh toán:</strong> <span
                            class="text-success">{{ number_format($order->total_price, 0, ',', '.') }}.đ</span></p>
                    <p><strong>Phương thức thanh toán:</strong> <span>
                            {{ App\Enums\PaymentMethod::getDescription($order->payment_method) }}
                        </span></p>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Thông tin người đặt hàng -->
                <div class="order-customer mt-4">
                    <h3 class="text-orange mb-3">Người đặt hàng: </h3>
                    <p><strong>Tên:</strong> <span class="text-light">{{Auth::user()->name}}</span></p>
                    <p><strong>Email:</strong> <span class="text-light">{{Auth::user()->email}}</span></p>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Thông tin khách hàng -->
                <div class="order-customer mt-4">
                    <h3 class="text-orange mb-3">Địa chỉ nhận hàng: </h3>
                    <p><strong>Tên:</strong> <span class="text-light">{{ $order->user->name }}</span></p>
                    <p><strong>Địa chỉ:</strong> <span class="text-light">{{ $order->shipping_address }}</span></p>
                    <p><strong>Số điện thoại:</strong> <span class="text-light">{{ $order->customer->phone }}</span></p>
                </div>
            </div>
        </div>
        <hr>
        <!-- Thông tin sản phẩm -->
        <div class="order-products mt-5">
            <h5 class="text-orange mb-3">Sản phẩm trong đơn hàng</h5>
            <div class="order-items-container"
                style="background-color: #000; color: #ffffff; padding: 20px; border-radius: 10px;">
                <div class="row py-2"
                    style="background-color: #000000; color: #ff4d00; font-weight: bold; border-radius: 5px;">
                    <div class="col-3 text-center">Sản phẩm</div>
                    <div class="col-2 text-center">Màu</div>
                    <div class="col-2 text-center">Kích cỡ</div>
                    <div class="col-1 text-center">Số lượng</div>
                    <div class="col-2 text-center">Giá</div>
                    <div class="col-2 text-center">Tổng</div>
                </div>
                @foreach ($order->items as $item)
                    <div class="row py-3 border-bottom" style="border-color: #ff7300;">
                        <div class="col-3 text-center d-flex align-items-center">
                            <img src="{{ $item->product->images->first()?->image_path ?? 'default.jpg' }}"
                                alt="{{ $item->product->name }}" class="img-thumbnail me-2"
                                style="width: 60px; height: auto; border: 1px solid #ff7300;">
                            {{ $item->product->name }}
                        </div>
                        <div class="col-2 text-center">
                            <span class="badge bg-orange">{{ $item->variantProducts->color->name }}</span>
                        </div>
                        <div class="col-2 text-center">
                            <span class="badge bg-secondary">{{ $item->variantProducts->size->name }}</span>
                        </div>
                        <div class="col-1 text-center">{{ $item->quantity }}</div>
                        <div class="col-2 text-center">{{ number_format($item->price, 0, ',', '.') }}.đ</div>
                        <div class="col-2 text-center">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}.đ
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="order-actions mt-5 d-flex gap-3">
            <a href="#" class="btn btn-orange px-4 py-2">
                <i class="fa-solid fa-print me-1"></i> In hóa đơn
            </a>
            <a href="#" class="btn btn-secondary px-4 py-2">
                <i class="fa-solid fa-phone me-1"></i> Liên hệ hỗ trợ
            </a>
        </div>
    </div>
@endsection
