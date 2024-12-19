@extends('layout.client.master')
@push('styles')
    <link rel="stylesheet" href="client_ui/assets/css/voucherModal.css">
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
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <section class="checkout-page pt-130 pb-130">
            <div class="container">
                @if ($shoppingCart && $shoppingCart->items->count() > 0)
                    <div class="row">
                        <!-- Cột bên trái -->
                        <div class="col-lg-6">
                            @if ($addresses)
                                <!-- Hiển thị thông tin khách hàng và form sửa -->
                                <div class="user-info p-4 bg-light shadow rounded mb-4">
                                    <h3 class="mb-4">Thông Tin Giao Hàng</h3>
                                    <div id="user-info-display">
                                        <p><strong>Khách hàng:</strong> <span id="user-name">{{ Auth::user()->name }}</span>
                                        </p>
                                        @if ($customer)
                                            <p><strong>Số điện thoại:</strong> <span
                                                    id="user-phone">{{ $customer->phone ?? null }}</span></p>
                                            @if ($defaultAddress)
                                                <div id="selected-address-info" class="mt-3">
                                                    <h4>Địa chỉ nhận hàng:</h4>
                                                    <p><span id="selected-address">
                                                            {{ $defaultAddress->address }},

                                                            @if ($defaultAddress->zip_code)
                                                                (Mã bưu điện: {{ $defaultAddress->zip_code }})
                                                            @endif
                                                        </span></p>
                                                    <p><strong>Người nhận:</strong> <span
                                                            id="selected-recipient-name">{{ $defaultAddress->recipient_name }}</span>
                                                    </p>
                                                    <p><strong>Số điện thoại:</strong> <span
                                                            id="selected-recipient-phone">{{ $defaultAddress->recipient_phone }}</span>
                                                    </p>
                                                </div>
                                            @else
                                                Chưa có địa chỉ.
                                            @endif
                                            <div id="address-list" class="d-flex flex-wrap d-none">
                                                @foreach ($addresses as $address)
                                                    <div class="address-card me-3 mb-3 p-3 border rounded"
                                                        style="cursor: pointer;" data-id="{{ $address->id }}"
                                                        data-recipient-name="{{ $address->recipient_name }}"
                                                        data-recipient-phone="{{ $address->recipient_phone }}"
                                                        data-address="{{ $address->address }}"
                                                        data-zip-code="{{ $address->zip_code }}">
                                                        <strong>{{ $address->address }}</strong><br>
                                                        @if ($address->zip_code)
                                                            <span>Mã bưu điện: {{ $address->zip_code }}</span><br>
                                                        @endif
                                                        <p><strong>Người nhận:</strong> {{ $address->recipient_name }}<br>
                                                            <strong>Số điện thoại:</strong> {{ $address->recipient_phone }}
                                                        </p>
                                                        <form
                                                            action="{{ route('client.addresses.destroy', $address->id) }}"
                                                            id="delete-address-form" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link text-danger"
                                                                onclick="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này không?')">
                                                                Xoá địa chỉ
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <button type="button" class="d-flex text-center btn-two mt-10 px-3 py-2"
                                                id="change-address-btn">
                                                <span>Thay đổi</span>
                                            </button>
                                            <button type="button" class="d-flex text-center btn-two mt-10 px-3 py-2"
                                                id="add-address-btn">
                                                <span>Thêm địa chỉ</span>
                                            </button>
                                            <div id="add-address-section" class="mt-4">
                                                <div id="add-address-form" class="mt-4 d-none p-4 rounded">
                                                    <h4 class="mb-4">Thêm Địa Chỉ Mới</h4>
                                                    <form method="POST" action="{{ route('client.addresses.store') }}">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="recipient_name" class="form-label">Tên người
                                                                nhận</label>
                                                            <input type="text" name="recipient_name" id="recipient_name"
                                                                class="form-control" placeholder="Nhập tên người nhận"
                                                                value="{{ old('recipient_name') }}">
                                                            @error('recipient_name')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="recipient_phone" class="form-label">Số điện
                                                                thoại</label>
                                                            <input type="text" name="recipient_phone"
                                                                id="recipient_phone" class="form-control"
                                                                placeholder="Nhập số điện thoại"
                                                                value="{{ old('recipient_phone') }}">
                                                            @error('recipient_phone')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Địa chỉ cụ
                                                                thể</label>
                                                            <input type="text" name="address" id="address"
                                                                class="form-control" placeholder="Nhập địa chỉ"
                                                                value="{{ old('address') }}">
                                                            @error('address')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="zip_code" class="form-label">Mã bưu điện</label>
                                                            <input type="text" name="zip_code" id="zip_code"
                                                                class="form-control" placeholder="Nhập mã bưu điện (nếu có)"
                                                                value="{{ old('zip_code') }}">
                                                            @error('zip_code')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <button type="submit" class="btn"
                                                            style="background-color: orangered; color: #fff">Lưu Địa
                                                            Chỉ</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            id="cancel-add-address">Hủy</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <p>Bạn cần <a href="{{ route('client.createInfo') }}#warranty"
                                                    style="color: orangered">thêm thông tin cá nhân</a>
                                                để thêm địa chỉ</p>

                                        @endif
                                    </div>
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
                                @foreach ($selectedProducts as $item)
                                    <div class="product p-4 bor-bottom d-flex justify-content-between align-items-center">
                                        <div class="product-details d-flex align-items-center">
                                            <img src="{{ $item->variantProduct->images->first()->image_path }}"
                                                alt="image">
                                            <h4 class="ps-4 text-capitalize">{{ $item->variantProduct->name }}</h4>
                                        </div>
                                        <div class="product-price">
                                            @if ($item->product->flash_sale_price > 0)
                                                {{ number_format($item->product->flash_sale_price, 0, ',', '.') }}.đ
                                            @elseif ($item->product->sale_price > 0)
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
                                            $productPrice = $item->product->flash_sale_price > 0 
                                                ? $item->product->flash_sale_price 
                                                : ($item->product->sale_price > 0 
                                                    ? $item->product->sale_price 
                                                    : $item->product->base_price);
                                            $totalPrice = $productPrice * $item->quantity;
                                        
                                            $cartTotal += $totalPrice;
                                            ?>
                                            {{ number_format($totalPrice, 0, ',', '.') }}.đ
                                        </div>                                        
                                    </div>
                                @endforeach

                                <div id="finalAmountMessage"></div>

                                <div class="totals">
                                    <div class="totals-item theme-color float-end mt-20">
                                        <span class="fw-bold text-uppercase py-2">Tổng tiền =</span>
                                        <div class="totals-value d-inline py-2 pe-2" id="cart-subtotal">
                                            {{ number_format($cartTotal, 0, ',', '.') }}.đ
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>Giỏ hàng của bạn hiện tại trống.</p>
                @endif
                <hr>
                <div class="col-md-6">
                    <!-- Button để mở Popup -->
                    <button type="button" data-bs-toggle="modal" data-bs-target="#voucherModal"
                        class="d-block text-center btn-two px-3 py-2">
                        <span>Chọn hoặc nhập mã giảm giá</span>
                    </button>
                    <!-- Popup Modal -->
                    <div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="voucherModalLabel">Chọn hoặc nhập mã giảm giá</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form nhập mã giảm giá -->
                                    <form id="voucherForm" class="form-inline">
                                        @csrf
                                        <div class="input-container mb-3">
                                            <input type="text" name="code" class="form-control custom-input"
                                                placeholder="Nhập mã giảm giá tại đây...">
                                            @error('$voucher')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="total_amount" value="{{ $cartTotal }}">
                                        <!-- Tổng tiền -->

                                        <!-- Danh sách mã giảm giá có sẵn -->
                                        <div class="voucher-list">
                                            <p>Hoặc chọn mã giảm giá:</p>
                                            <ul class="list-group">
                                                @foreach ($vouchers as $voucher)
                                                    <li class="list-group-item">
                                                        <button type="button" class="btn btn-link select-voucher"
                                                            data-code="{{ $voucher->code }}"
                                                            data-type="{{ $voucher->discount_type }}"
                                                            data-value="{{ $voucher->discount }}">
                                                            {{ $voucher->code }} -
                                                            @if ($voucher->discount_type === 'percentage')
                                                                Giảm {{ $voucher->discount }}%
                                                            @elseif ($voucher->discount_type === 'fixed')
                                                                Giảm {{ number_format($voucher->discount, 0, ',', '.') }}₫
                                                            @endif
                                                        </button>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" form="voucherForm" class="btn btn-success">Áp dụng</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <input type="hidden" name="payment_method" id="payment-method-input" value="cash">
                        <input type="hidden" name="address_id" id="selected-address-id" value="{{ $addressId }}">
                        <input type="hidden" name="final_amount" id="final-amount-input" value="{{ $cartTotal }}">

                        <!-- Truyền ID sản phẩm đã chọn -->
                        @foreach ($selectedProducts as $item)
                            <input type="hidden" name="selected_products[]" value="{{ $item->variantProduct->id }}">
                        @endforeach

                        <!-- Nút Đặt hàng -->
                        <button type="submit" class="d-block text-center btn-two mt-20" id="submit-payment">
                            <span>Đặt hàng</span>
                        </button>
                    </form>
                </div>
            </div>
            </div>
            </div>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý khi người dùng chọn mã giảm giá từ danh sách
            const voucherButtons = document.querySelectorAll('.select-voucher');
            voucherButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const code = this.getAttribute('data-code');
                    document.querySelector('input[name="code"]').value =
                        code; // Điền mã giảm giá vào input
                });
            });

            // Xử lý submit form mã giảm giá
            $('#voucherForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/client/checkout/apply-voucher',
                    data: $(this).serialize(),
                    success: function(response) {
                        var formattedAmount = response.final_amount.toLocaleString('vi-VN');
                        var discount = response.discount_type;

                        // Cập nhật giao diện với thông báo thành công
                        $('#finalAmountMessage')
                            .text("Chúc mừng !!! Bạn đã được giảm: " + discount)
                            .removeClass('text-danger')
                            .addClass('text-success');

                        // Cập nhật tổng tiền hiển thị
                        $('#cart-subtotal').text(formattedAmount + ".đ");
                        $('#final-amount-input').val(response.final_amount);
                    },
                    error: function(xhr) {
                        // Hiển thị thông báo lỗi
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ?
                            xhr.responseJSON.error :
                            'Đã xảy ra lỗi!';

                        $('#finalAmountMessage')
                            .text(errorMessage)
                            .removeClass('text-success')
                            .addClass('text-danger');
                    },
                    complete: function() {
                        // Đóng modal bất kể kết quả
                        const voucherModal = bootstrap.Modal.getInstance(document.querySelector(
                            '#voucherModal'));
                        voucherModal.hide();
                    }
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addressCards = document.querySelectorAll('.address-card');
            const selectedAddressInfo = document.getElementById('selected-address-info');
            const addressList = document.getElementById('address-list');
            const changeAddressBtn = document.getElementById('change-address-btn');
            const selectedAddressInput = document.getElementById('selected-address-id');

            addressCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Lấy ID của địa chỉ đã chọn
                    const addressId = card.getAttribute('data-id');

                    // Lưu ID của địa chỉ đã chọn vào input hidden
                    selectedAddressInput.value = addressId;

                    // Cập nhật thông tin vào các phần tử hiển thị
                    const recipientName = card.getAttribute('data-recipient-name');
                    const recipientPhone = card.getAttribute('data-recipient-phone');
                    const address = card.getAttribute('data-address');
                    const zipCode = card.getAttribute('data-zip-code');

                    document.getElementById('selected-address').textContent =
                        `${address} ${zipCode ? ', Mã bưu điện: ' + zipCode : ''}`;
                    document.getElementById('selected-recipient-name').textContent = recipientName;
                    document.getElementById('selected-recipient-phone').textContent =
                        recipientPhone;

                    // Đánh dấu địa chỉ đã chọn
                    addressCards.forEach(card => card.classList.remove('selected'));
                    card.classList.add('selected');

                    // Ẩn danh sách địa chỉ và hiển thị thông tin địa chỉ đã chọn
                    selectedAddressInfo.classList.remove('d-none');
                    addressList.classList.add('d-none');
                });
            });

            // Khi nhấn "Thay đổi", hiển thị lại danh sách địa chỉ
            changeAddressBtn.addEventListener('click', function() {
                selectedAddressInfo.classList.add('d-none');
                addressList.classList.remove('d-none');
            });
        });
        document.getElementById('add-address-btn').addEventListener('click', function() {
            document.getElementById('add-address-form').classList.remove('d-none');
            this.classList.add('d-none');
        });

        document.getElementById('cancel-add-address').addEventListener('click', function() {
            document.getElementById('add-address-form').classList.add('d-none');
            document.getElementById('add-address-btn').classList.remove('d-none');
        });

        document.getElementById('change-address-btn').addEventListener('click', function() {
            document.getElementById('add-address-form').classList.add('d-none');
            document.getElementById('add-address-btn').classList.remove('d-none');
        });

        document.getElementById('add-address-btn').addEventListener('click', function() {
            document.getElementById('address-list').classList.add('d-none');
            document.getElementById('add-address-btn').classList.remove('d-none');
        });
    </script>
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
@endpush
