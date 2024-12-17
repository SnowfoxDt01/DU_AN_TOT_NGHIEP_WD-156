@extends('layout.client.master')
@push('styles')
    <style>
        .column-labels {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-select {
            flex: 1;
            text-align: center;
        }

        .product-details {
            flex: 3;
            display: flex;
            justify-content: start;
            align-items: center;
        }

        .product-size,
        .product-line-price,
        .product-removal {
            flex: 1;
            text-align: center;
        }

        .column-labels .product-color {
            margin-left: 45px;
        }

        .column-labels label {
            padding: 0 10px;
            white-space: nowrap;
        }

        .product-checkbox {
            transform: scale(1.75);
            accent-color: #fa4f09;
        }
    </style>
@endpush
@section('content')
    <main>
        <section class="page-banner bg-image pt-130 pb-130" data-background="">
            <div class="container">
                <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Trang giỏ hàng</h2>
                <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                    <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Trang
                        chủ <i class="fa-regular text-white fa-angle-right"></i></a>
                    <span>Giỏ hàng</span>
                </div>
            </div>
        </section>

        <section class="cart-page pt-130 pb-130">
            <div class="container">
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
                <div class="shopping-cart radius-10 bor sub-bg">
                    @if (isset($shoppingCart))
                        <div class="user-info p-4">
                            <h3>Thông tin người dùng</h3>
                            <p><strong>Người dùng:</strong> {{ Auth::user()->name }}</p>
                        </div>
                    @endif
                    <hr>
                    <div
                        class="column-labels py-3 px-4 d-flex justify-content-between align-items-center fw-bold text-white text-uppercase">
                        <label class="product-select">
                            <input type="checkbox" id="select-all" class="product-checkbox">
                        </label>
                        <label class="product-details">Sản phẩm</label>
                        <label class="product-color">Màu</label>
                        <label class="product-size">Kích cỡ</label>
                        <label class="product-price">Giá</label>
                        <label class="product-quantity">Số lượng</label>
                        <label class="product-line-price">Tổng giá</label>
                        <label class="product-removal">Xóa</label>
                    </div>


                    @if (isset($shoppingCart) && $shoppingCart->items->count() > 0)
                        <?php
                        $cartTotal = 0; // Khởi tạo tổng giá trị giỏ hàng
                        ?>
                        @foreach ($shoppingCart->items as $item)
                            <div class="product p-4 bor-bottom d-flex justify-content-between align-items-center"
                                data-item-id="{{ $item->id }}">
                                <div class="product-select d-flex justify-content-center align-items-center">
                                    <input type="checkbox" class="product-checkbox" name="selected_items[]"
                                        value="{{ $item->id }}">
                                </div>
                                <div class="product-details d-flex align-items-center">
                                    <img src="{{ $item->variantProduct->images->first()->image_path }}" alt="image">
                                    <h4 class="ps-4 text-capitalize">{{ $item->variantProduct->name }}</h4>
                                </div>
                                <div class="product-color">
                                    <h4 class="ps-4 text-capitalize">{{ $item->variantProduct->color->name }}</h4>
                                </div>
                                <div class="product-size">
                                    <h4 class="ps-4 text-capitalize">{{ $item->variantProduct->size->name }}</h4>
                                </div>
                                <div class="product-price">
                                    @if ($item->product->sale_price > 0)
                                        {{ number_format($item->product->sale_price, 0, ',', '.') }}.đ
                                    @else
                                        {{ number_format($item->product->base_price, 0, ',', '.') }}.đ
                                    @endif
                                </div>
                                <form action="{{ route('client.cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    <div class="product-quantity">
                                        <button class="decrease-quantity"><i class="fas fa-minus"></i></button>
                                        <input type="number" value="{{ $item->quantity }}" min="1"
                                            max="{{ $item->variantProduct->quantity }}">
                                        <button class="increase-quantity"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <small>
                                        <p class="remaining-quantity">Còn lại {{ $item->variantProduct->quantity }} sản
                                            phẩm</p>
                                    </small>
                                </form>
                                <div class="product-line-price">
                                    <?php
                                    $productPrice = $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->base_price;
                                    $totalPrice = $productPrice * $item->quantity;
                                    $cartTotal += $totalPrice;
                                    ?>
                                    {{ number_format($totalPrice, 0, ',', '.') }}.đ
                                </div>
                                <div class="product-removal">
                                    <form id="delete-form-{{ $item->id }}"
                                        action="{{ route('client.cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $item->id }})">
                                            <i class="fa-solid fa-x heading-color"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <div class="totals">
                            <div class="totals-item theme-color float-end mt-20">
                                <span class="fw-bold text-uppercase py-2">Tổng tiền =</span>
                                <div class="totals-value d-inline py-2 pe-2" id="cart-subtotal">
                                    0 đ
                                </div>
                            </div>
                        </div>

                </div>
                <form action="{{ route('client.checkout.index') }}" method="POST" id="checkout-form">
                    @csrf
                    <input type="hidden" name="selected_items" id="selected_items">
                    <button type="submit" class="d-inline-block text-center btn-two mt-30 px-4 py-3">
                        <span>Thanh toán</span>
                    </button>
                </form>
            @else
                <span class="text-danger">Chưa có sản phẩm nào trong giỏ hàng!</span>
                @endif
            </div>
        </section>
    </main>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cập nhật tổng tiền khi tăng/giảm số lượng hoặc thay đổi checkbox
            function updateCartTotal() {
                var cartTotal = 0;

                // Duyệt qua tất cả checkbox được chọn (trừ checkbox "Chọn tất cả")
                $('.product-checkbox:checked').not('#select-all').each(function() {
                    var productElement = $(this).closest('.product'); // Lấy sản phẩm tương ứng với checkbox
                    var linePrice = productElement.find('.product-line-price').text().replace(/[^0-9]/g,
                        ''); // Lấy giá trị
                    cartTotal += parseInt(linePrice); // Cộng giá trị vào tổng tiền
                });

                // Cập nhật tổng tiền hiển thị
                $('#cart-subtotal').text(cartTotal.toLocaleString('vi-VN') + ' đ');
            }

            // Xử lý sự kiện tăng/giảm số lượng
            $('.decrease-quantity, .increase-quantity').click(function(event) {
                event.preventDefault();

                var input = $(this).siblings('input');
                var currentVal = parseInt(input.val()); // Lấy giá trị hiện tại
                var maxVal = parseInt(input.attr('max')); // Giá trị tối đa
                var updateCart = false;

                if ($(this).hasClass('decrease-quantity') && currentVal > 1) {
                    input.val(currentVal - 1);
                    updateCart = true;
                } else if ($(this).hasClass('increase-quantity') && currentVal < maxVal) {
                    input.val(currentVal + 1);
                    updateCart = true;
                } else if ($(this).hasClass('increase-quantity') && currentVal >= maxVal) {
                    toastr.warning('Số lượng sản phẩm không đủ', 'Cảnh báo', {
                        "timeOut": 3000,
                        "backgroundColor": "#ff0000",
                        "iconClass": "toast-warning"
                    });
                }

                if (updateCart) {
                    var itemId = $(this).closest('.product').data('item-id'); // Lấy ID của sản phẩm

                    // Gửi yêu cầu AJAX để cập nhật số lượng
                    $.ajax({
                        url: "{{ route('client.cart.update', ':itemId') }}".replace(':itemId',
                            itemId),
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            quantity: input.val()
                        },
                        success: function(response) {
                            // Cập nhật tổng giá cho sản phẩm này
                            if (response.lineTotal) {
                                $(input).closest('.product').find('.product-line-price').text(
                                    response.lineTotal + '.Đ');
                            }

                            // Cập nhật tổng tiền cho các sản phẩm được chọn
                            updateCartTotal();

                            toastr.success('Số lượng sản phẩm đã được cập nhật', 'Thông báo', {
                                "timeOut": 3000,
                                "backgroundColor": "#28a745",
                                "iconClass": "toast-success"
                            });
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
            });

            // Cập nhật tổng tiền khi chọn/bỏ chọn sản phẩm
            $('.product-checkbox').change(function() {
                if (!$(this).is('#select-all')) {
                    // Kiểm tra trạng thái của checkbox "Chọn tất cả"
                    if ($('.product-checkbox:checked').not('#select-all').length === $('.product-checkbox')
                        .not('#select-all').length) {
                        $('#select-all').prop('checked', true);
                    } else {
                        $('#select-all').prop('checked', false);
                    }
                }

                updateCartTotal();
            });

            // Xử lý sự kiện nhấp vào checkbox "Chọn tất cả"
            $('#select-all').change(function() {
                var isChecked = $(this).is(':checked'); // Kiểm tra trạng thái checkbox "Chọn tất cả"
                $('.product-checkbox').not('#select-all').prop('checked',
                    isChecked); // Chọn hoặc bỏ chọn tất cả sản phẩm
                updateCartTotal(); // Cập nhật tổng tiền
            });
        });

        function confirmDelete() {
            return confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?");
        }
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            var selectedItems = [];
            // Lấy tất cả checkbox đã được chọn
            document.querySelectorAll('.product-checkbox:checked').forEach(function(checkbox) {
                selectedItems.push(checkbox.value); // Lưu giá trị của sản phẩm đã chọn (ID)
            });

            // Kiểm tra nếu không có sản phẩm nào được chọn
            if (selectedItems.length === 0) {
                alert("Vui lòng chọn sản phẩm để thanh toán.");
                e.preventDefault(); // Ngừng gửi form
            } else {
                // Đưa các sản phẩm đã chọn vào input hidden
                document.getElementById('selected_items').value = selectedItems.join(',');
            }
        });
    </script>
@endsection
