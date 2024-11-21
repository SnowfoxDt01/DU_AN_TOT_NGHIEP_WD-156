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

    .user-info {
        background-color: #191919 !important;
    }

    .user-info .text-white {
        color: white;
    }

    .selected {
        font-weight: bold;
        background-color: #007bff;
        color: white;
    }

    .column-labels .product-line-price {
        width: 84px;
        /* Cài đặt chiều rộng cố định cho cột Tổng giá */
    }

    button {
        transition: all 0.3s ease;
    }

    #default-payment {
        padding: 10px 15px;
        background-color: #191919;
        border-radius: 5px;
    }

    #payment-options {
        padding: 10px 15px;
        background-color: #191919;
        border-radius: 5px;
    }

    #vnpay-btn {
        margin-left: 20px;
    }
</style>
@endpush

@section('content')
<main>
    <section class="page-banner bg-image pt-130 pb-130" data-background="">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Thông tin thanh toán</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Trang
                    chủ <i class="fa-regular text-white fa-angle-right"></i></a>
                <span>Thanh toán</span>
            </div>
        </div>
    </section>

    <section class="checkout-page pt-130 pb-130">
        <div class="container">
            @if ($shoppingCart && $shoppingCart->items->count() > 0)
            <div class="row">
                <!-- Cột bên trái -->
                <div class="col-lg-6">
                    @if ($customer)
                    <!-- Hiển thị thông tin khách hàng và form sửa -->
                    <div class="user-info p-4 bg-light shadow rounded mb-4">
                        <h3 class="mb-4">Thông Tin Giao Hàng</h3>
                        <div id="user-info-display">
                            <p><strong>Địa chỉ:</strong> <span id="user-address">{{ $customer->address }}</span></p>
                            <p><strong>Họ tên:</strong> <span id="user-name">{{ $customer->name }}</span></p>
                            <p><strong>Số điện thoại:</strong> <span id="user-phone">{{ $customer->phone }}</span></p>
                            <button type="button" class="d-block text-center btn-two mt-10 px-3 py-2" id="edit-info-btn">
                              <span>Thay đổi</span>  
                            </button>
                        </div>
                        <div id="edit-form" class="mt-4" style="display:none;">
                            <h4 class="mb-3">Địa Chỉ Của Tôi</h4>
                            <form method="POST" action="{{ route('client.profile.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ Tên Người Nhận</label>
                                    <input type="text" name="name" id="name" value="{{ $customer->name }}"
                                        class="form-control" placeholder="Nhập họ tên" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số Điện Thoại</label>
                                    <input type="text" name="phone" id="phone" value="{{ $customer->phone }}"
                                        class="form-control" placeholder="Nhập số điện thoại" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa Chỉ Nhận Hàng</label>
                                    <input type="text" name="address" id="address" value="{{ $customer->address }}"
                                        class="form-control" placeholder="Nhập địa chỉ" required>
                                </div>
                                <button type="submit" class="text-center btn-one mt-1 px-3 py-2">Cập nhật</button>
                                <button type="button" class="text-center btn-two mt-1 px-3 py-2" id="cancel-edit-btn">Hủy</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <!-- Thêm mới thông tin khách hàng -->
                    <div class="user-info p-4 bg-light shadow rounded">
                        <h3 class="mb-4">Thêm Thông Tin Khách Hàng</h3>
                        <form method="POST" action="{{ route('client.profile.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ Tên</label>
                                <input type="text" name="name" id="name"
                                    class="form-control" placeholder="Nhập họ tên" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số Điện Thoại</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control" placeholder="Nhập số điện thoại" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa Chỉ</label>
                                <input type="text" name="address" id="address"
                                    class="form-control" placeholder="Nhập địa chỉ" required>
                            </div>
                            <input type="hidden" name="id_user" value="{{ auth()->id() }}">
                            <button type="submit" class="btn btn-primary">Thêm Khách Hàng</button>
                        </form>
                    </div>
                    @endif
                </div>

                <!-- Cột bên phải -->
                <div class="col-lg-6">
                    <h3>Chi tiết đơn hàng</h3>
                    <div class="order-details">
                        <div
                            class="column-labels py-2 px-3 d-flex justify-content-between align-items-center fw-bold text-white text-uppercase">
                            <label class="product-details">Sản phẩm</label>
                            <label class="product-price">Giá</label>
                            <label class="product-quantity">Số lượng</label>
                            <label class="product-line-price">Tổng giá</label>
                        </div>

                        <?php $cartTotal = 0; ?>
                        @foreach ($shoppingCart->items as $item)
                        <div class="product p-4 bor-bottom d-flex justify-content-between align-items-center">
                            <div class="product-details d-flex align-items-center">
                                <img src="{{ $item->variantProduct->images->first()->image_path }}" alt="image">
                                <h4 class="ps-4 text-capitalize">{{ $item->variantProduct->name }}</h4>
                            </div>
                            <div class="product-price">
                                @if ($item->product->sale_price > 0)
                                {{ number_format($item->product->sale_price, 0, ',', '.') }}.đ
                                @else
                                {{ number_format($item->product->base_price, 0, ',', '.') }}.đ
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
                                {{ number_format($totalPrice, 0, ',', '.') }}.đ
                            </div>
                        </div>
                        @endforeach

                        <div class="totals">
                            <div class="totals-item theme-color float-end mt-20">
                                <span class="fw-bold text-uppercase py-2">Tổng tiền =</span>
                                <div class="totals-value d-inline py-2 pe-2" id="cart-subtotal">
                                    {{ number_format($cartTotal, 0, ',', '.') }}.đ
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <p>Giỏ hàng của bạn hiện tại trống.</p>
                    @endif

                    <div class="col-md-4">
                        <form id="voucherForm" class="form-inline mt-5">
                            @csrf
                            <div class="input-container">
                                <input type="text" name="code" class="mb-20 form-control custom-input" placeholder="Nhập mã giảm giá tại đây...">
                            </div>
                            @error('$voucher')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <input type="hidden" name="total_amount" value="{{ $cartTotal }}"> <!-- Tổng tiền -->
                            <button type="submit" class="d-inline-block text-center btn-two ">
                                <span>Áp dụng</span>
                            </button>
                        </form>
                        <div id="finalAmountMessage"></div>
                    </div>
                    <hr>
                    <div class="payment-methods mt-4">
                        <h3>Chọn phương thức thanh toán</h3>
                        <hr>
                        <div id="default-payment" class="d-flex align-items-center justify-content-between">
                            <span id="selected-payment-method" class="fw-bold">Thanh toán khi nhận hàng</span>
                            <button type="button" id="change-payment-btn" class="d-block text-center btn-two px-3 py-2">
                             <span>Thay đổi</span>   
                            </button>
                        </div>
                        <div id="payment-options" class="mt-3 d-none">
                            <div class="d-flex justify-content-start">
                                <div class="payment-option me-2">
                                    <button type="button" class="d-block text-center btn-two px-2 py-2" id="cod-btn">
                                        <span>Thanh toán khi nhận hàng</span>
                                    </button>
                                </div>
                                <div class="payment-option">
                                    <button type="button" class="d-block text-center btn-two px-2 py-2" id="vnpay-btn">
                                        <span>Thanh toán bằng VnPay</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="payment-action mt-4">
                        <form id="order-form" action="{{ route('client.checkout.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_method" id="payment-method-input" value="">
                            <button type="submit" class="d-block text-center btn-two mt-20" id="submit-payment">
                              <span>Đặt hàng</span>  
                            </button>
                        </form>
                    </div>
                </div>
            </div>
    </section>
</main>

<script>
    document.getElementById('cod-btn').addEventListener('click', function() {
        document.getElementById('cod-btn').classList.add('selected');
        document.getElementById('vnpay-btn').classList.remove('selected');
        document.getElementById('payment-method-input').value = 'cash';
    });

    document.getElementById('vnpay-btn').addEventListener('click', function() {
        document.getElementById('vnpay-btn').classList.add('selected');
        document.getElementById('cod-btn').classList.remove('selected');
        document.getElementById('payment-method-input').value = 'vnpay';
    });

    document.getElementById('edit-info-btn').addEventListener('click', function() {
        document.getElementById('user-info-display').style.display = 'none';
        document.getElementById('edit-form').style.display = 'block';
    });
    document.getElementById('cancel-edit-btn').addEventListener('click', function() {
        document.getElementById('edit-form').style.display = 'none';
        document.getElementById('user-info-display').style.display = 'block';
    });
    document.getElementById('change-payment-btn').addEventListener('click', function() {
        const paymentOptions = document.getElementById('payment-options');
        paymentOptions.classList.toggle('d-none');
    });

    document.getElementById('cod-btn').addEventListener('click', function() {
        document.getElementById('payment-method-input').value = 'cash';
        document.getElementById('selected-payment-method').innerText = 'Thanh toán khi nhận hàng';
        document.getElementById('payment-options').classList.add('d-none');
    });

    document.getElementById('vnpay-btn').addEventListener('click', function() {
        document.getElementById('payment-method-input').value = 'vnpay';
        document.getElementById('selected-payment-method').innerText = 'Thanh toán bằng VnPay';
        document.getElementById('payment-options').classList.add('d-none');
    });
</script>
@endsection
@push('scripts')
<script>
    $('#voucherForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/client/checkout/apply-voucher',
            data: $(this).serialize(),
            success: function(response) {
                var formattedAmount = response.final_amount.toLocaleString('vi-VN');
                var discount = response.discount_type;
                $('#finalAmountMessage').text("Chúc mừng !!! Bạn đã được giảm : " + discount).removeClass(
                    'text-danger').addClass('text-success');
                // Thay đổi $cartTotal = formattedAmount
                $('#cart-subtotal').text(formattedAmount + ".đ");
                $('#final-amount-input').val(response.final_amount);
            },
            error: function(xhr) {
                // Khi có lỗi, hiển thị thông báo lỗi
                var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON
                    .error : 'Đã xảy ra lỗi!';

                $('#finalAmountMessage')
                    .text(errorMessage)
                    .removeClass('text-success') // Loại bỏ lớp text-success nếu có
                    .addClass('text-danger'); // Thêm lớp text-danger để hiển thị màu đỏ
            }
        });
    });
</script>
@endpush