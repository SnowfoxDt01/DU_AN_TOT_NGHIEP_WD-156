{{-- checkout/index.blade.php --}}

@extends('layout.client.master')
@push('styles')
<style>
    .decrease-quantity,
    .increase-quantity {
        background-color: transparent;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        padding: 5px;
    }

    .decrease-quantity:hover,
    .increase-quantity:hover {
        background-color: #555;
    }

    .selected {
        font-weight: bold;
        background-color: #007bff;
        /* Màu nền khi chọn */
        color: white;
        /* Màu chữ khi chọn */
    }

    button {
        transition: all 0.3s ease;
        /* Thêm hiệu ứng chuyển động khi thay đổi */
    }
</style>
@endpush

@section('content')
<main>
    <section class="page-banner bg-image pt-130 pb-130" data-background="">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Thông tin thanh toán</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Trang chủ <i class="fa-regular text-white fa-angle-right"></i></a>
                <span>Thanh toán</span>
            </div>
        </div>
    </section>

    <section class="checkout-page pt-130 pb-130">
        <div class="container">
            @if($shoppingCart && $shoppingCart->items->count() > 0)
            @if ($customer)
            <div class="user-info p-4">
                <h3>Thông tin người đặt hàng</h3>
                <p><strong>Họ tên:</strong> {{ $customer->name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $customer->phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $customer->address }}</p>
            </div>
            @else
            <p>Thông tin khách hàng không có hoặc không đầy đủ.</p>
            @endif

            <hr>

            <h3>Chi tiết đơn hàng</h3>
            <div class="order-details">
                <div class="column-labels py-3 px-4 d-flex justify-content-between align-items-center fw-bold text-white text-uppercase">
                    <label class="product-details">Sản phẩm</label>
                    <label class="product-price">Giá</label>
                    <label class="product-quantity">Số lượng</label>
                    <label class="product-line-price">Tổng giá</label>
                </div>

                <?php $cartTotal = 0;
                ?>
                @foreach($shoppingCart->items as $item)
                <div class="product p-4 bor-bottom d-flex justify-content-between align-items-center">
                    <div class="product-details d-flex align-items-center">
                        <img src="{{ $item->variantProduct->images->first()->image_path }}" alt="image">
                        <h4 class="ps-4 text-capitalize">{{ $item->variantProduct->name }}</h4>
                    </div>
                    <div class="product-price">
                        @if ($item->product->sale_price > 0)
                        {{ number_format($item->product->sale_price, 0, ',', '.') }}
                        @else
                        {{ number_format($item->product->base_price, 0, ',', '.') }}
                        @endif
                    </div>
                    <div class="product-quantity">
                        {{ $item->quantity }}
                    </div>
                    <div class="product-line-price">
                        <?php
                        $productPrice = $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->base_price;
                        $totalPrice = $productPrice * $item->quantity;
                        $cartTotal += $totalPrice;
                        ?>
                        {{ number_format($totalPrice, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach

                <div class="totals">
                    <div class="totals-item theme-color float-end mt-20">
                        <span class="fw-bold text-uppercase py-2">Tổng tiền =</span>
                        <div class="totals-value d-inline py-2 pe-2" id="cart-subtotal">
                            {{ number_format($cartTotal, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            @else
            <p>Giỏ hàng của bạn hiện tại trống.</p>
            @endif

            <hr>
            <div class="payment-methods mt-4">
                <h3>Chọn phương thức thanh toán</h3>
                <div class="d-flex justify-content-start">
                    <div class="payment-option me-2">
                        <button type="button" class="d-block text-center btn-two mt-10 px-2 py-2" id="cod-btn">
                            Thanh toán khi nhận hàng
                        </button>
                    </div>

                    <div class="payment-option">
                        <button type="button" class="d-block text-center btn-two mt-10 px-2 py-2" id="wallet-btn">
                            Thanh toán bằng ví
                        </button>
                    </div>
                </div>
            </div>

            <div class="payment-action mt-4">
                <button type="submit" class="d-block text-center btn-two mt-20" id="submit-payment">
                    Đặt hàng
                </button>
            </div>

    </section>
</main>
<script>
    document.getElementById('cod-btn').addEventListener('click', function() {
        document.getElementById('cod-btn').classList.add('selected');
        document.getElementById('wallet-btn').classList.remove('selected');
    });

    document.getElementById('wallet-btn').addEventListener('click', function() {
        document.getElementById('wallet-btn').classList.add('selected');
        document.getElementById('cod-btn').classList.remove('selected');
    });
</script>
@endsection