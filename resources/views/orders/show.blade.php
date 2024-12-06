@extends('layout.admin.master')

@section('content')
    <section class="content-header">
        <h1 style="font-size: 1.75rem; font-weight: 700; color: #0073aa;">
            Chi tiết đơn hàng
            <small style="font-size: 0.875rem; color: #555;">Trang chủ</small>
        </h1>
        <ol class="breadcrumb" style="background-color: #f7f7f7;">
            <li class="active">Đơn hàng</li>
        </ol>
    </section>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container mt-5" style="background: #fff; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="font-size: 1.5rem; color: #333;">Chi tiết đơn hàng #{{ $order->id }}</h1>

        <div class="card mb-4" style="border: 1px solid #ccd0d4; background-color: #f9f9f9; padding: 20px;">
            <h3 style="color: #0073aa;">Thông tin đơn hàng</h3>
            <hr style="border-color: #e1e1e1;">
            <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
            <p><strong>Ngày đặt hàng:</strong> {{ $order->date_order->format('d/m/Y') }}</p>
            <p><strong>Tổng tiền:</strong>
                {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
            </p>
            <p><strong>Phương thức thanh toán:</strong>
                {{ ucfirst(App\Enums\PaymentMethod::getDescription($order->payment_method)) }}</p>
            <p><strong>Trạng thái:</strong> {{ App\Enums\OrderStatus::getDescription($order->order_status) }}</p>
            @if ($order->cancel_reason != null)
                <p><strong>Lí do hủy đơn:</strong> <span>{{ $order->cancel_reason }}</span></p>
            @endif
        </div>

        <div class="card mb-4" style="border: 1px solid #ccd0d4; background-color: #f9f9f9; padding: 20px;">
            <h3 style="color: #0073aa;">Thông tin khách hàng</h3>
            <hr style="border-color: #e1e1e1;">
            <div>
                <p><strong>Người Đặt Hàng:</strong> {{ $order->customer->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->customer->user->email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->customer->phone }}</p>
                <hr style="border-color: #e1e1e1;">
                <p><strong>Người nhận:</strong> {{ $order->customer->name }}</p>
                <p><strong>Email:</strong> {{ $order->customer->email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->customer->phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->customer->address }}</p>
            </div>
        </div>

        <h2 style="font-size: 1.25rem; font-weight: 600; color: #0073aa;">Sản phẩm trong đơn hàng</h2>
        <ul class="list-group mb-4">
            @foreach ($order->items as $item)
                <li class="list-group-item"
                    style="display: flex; align-items: center; padding: 15px; border: 1px solid #ccd0d4;">
                    <div style="width: 10%; text-align: center;">
                        @if ($item->variantProducts && $item->variantProducts->images->first())
                            <img src="{{ asset($item->variantProducts->images->first()->image_path) }}"
                                alt="{{ $item->product->name }}"
                                style="width: 80px; height: auto; border: 1px solid #ddd; padding: 4px;">
                        @else
                            <img src="{{ asset('path/to/default/image.jpg') }}" alt="Hình ảnh mặc định"
                                style="width: 80px; height: auto; border: 1px solid #ddd; padding: 4px;">
                        @endif
                    </div>
                    <div style="width: 90%; padding-left: 15px;">
                        <p style="margin: 0; color: #333;"><strong>Mã sản phẩm:</strong> {{ $item->product_id }}</p>
                        <p style="margin: 0; color: #555;"><strong>Tên sản phẩm:</strong>
                            {{ $item->product ? $item->product->name : 'Không có tên sản phẩm' }}</p>
                        <p style="margin: 0; color: #555;"><strong>Màu:</strong>
                            {{ $item->variantProducts->color->name ?? 'Không có màu' }}</p>
                        <p style="margin: 0; color: #555;"><strong>Kích cỡ:</strong>
                            {{ $item->variantProducts->size->name ?? 'Không có size' }}</p>
                        <p style="margin: 0; color: #555;"><strong>Số lượng:</strong> {{ $item->quantity }}</p>

                        @php
                            $productPrice =
                                $item->product->sale_price > 0
                                    ? $item->product->sale_price
                                    : $item->product->base_price;
                        @endphp
                        <p style="margin: 0; color: #555;"><strong>Giá sản phẩm:</strong>
                            {{ number_format($productPrice, 0, ',', '.') }} VNĐ</p>
                        <p style="margin: 0; color: #555;"><strong>Thành tiền:</strong>
                            {{ number_format($productPrice * $item->quantity, 0, ',', '.') }} VNĐ</p>
                    </div>
                </li>
            @endforeach
        </ul>

        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="margin-top: 20px;">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="order_status" style="font-weight: 600;">Cập nhật trạng thái:</label>
                <select name="order_status" id="order_status" class="form-control"
                    style="border: 1px solid #ccd0d4; border-radius: 4px;" onchange="toggleCancelReason(this.value)">
                    @foreach (App\Enums\OrderStatus::getValues() as $value)
                        <option value="{{ $value }}" {{ $order->order_status == $value ? 'selected' : '' }}>
                            {{ App\Enums\OrderStatus::getDescription($value) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="cancel_reason_container" style="display: none;">
                <label for="cancel_reason" style="font-weight: 600;">Lý do hủy:</label>
                <textarea name="cancel_reason" id="cancel_reason" class="form-control" rows="3"
                    placeholder="Nhập lý do hủy đơn hàng..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="background-color: #0073aa; border: none;">Cập
                nhật</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
        </form>

    </div>
    <script>
        function toggleCancelReason(status) {
            const cancelReasonContainer = document.getElementById('cancel_reason_container');
            if (status === 'canceled') {
                cancelReasonContainer.style.display = 'block';
            } else {
                cancelReasonContainer.style.display = 'none';
            }
        }
    </script>
@endsection
