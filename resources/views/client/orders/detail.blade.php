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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
                    <p><strong>Chiết khấu:</strong> <span class="text-danger"> -
                            {{ number_format($discountAmount, 0, ',', '.') }}.đ</span></p>
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
                    <p><strong>Tên:</strong> <span class="text-light">{{ Auth::user()->name }}</span></p>
                    <p><strong>Email:</strong> <span class="text-light">{{ Auth::user()->email }}</span></p>
                    <p><strong>Số điện thoại:</strong> <span class="text-light">{{ Auth::user()->customer->phone  }}</span></p>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Thông tin khách hàng -->
                <div class="order-customer mt-4">
                    <h3 class="text-orange mb-3">Địa chỉ nhận hàng: </h3>
                    <p><strong>Tên:</strong> <span class="text-light">{{ $order->recipient_name  }}</span></p>
                    <p><strong>Địa chỉ:</strong> <span class="text-light">{{ $order->shipping_address }}</span></p>
                    <p><strong>Số điện thoại:</strong> <span class="text-light">{{ $order->recipient_phone  }}</span></p>
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
                            <img src="{{ $item->variantProducts->images->first()?->image_path ?? 'default.jpg' }}"
                                alt="{{ $item->variantProducts->name }}" class="img-thumbnail me-2"
                                style="width: 60px; height: auto; border: 1px solid #ff7300;">
                            {{ $item->variantProducts->name }}
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
            @if (in_array($order->order_status, ['confirming', 'confirmed']) && $order->user_id == auth()->id())
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal"
                    data-order-id="{{ $order->id }}">Hủy đơn hàng</button>
            @endif
        </div>
    </div>
@endsection
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: black; color: white;">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Lý do hủy đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="cancelOrderForm" name="cancelOrderForm" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cancel_reason" class="form-label">Lý do hủy</label>
                        <textarea class="form-control" id="cancel_reason" name="cancel_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var cancelOrderModal = document.getElementById('cancelOrderModal');
            cancelOrderModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var orderId = button.getAttribute('data-order-id');
                var form = document.getElementById('cancelOrderForm');
                form.action = '/client/order/' + orderId + '/cancel';
            });
        });
    </script>
@endpush
