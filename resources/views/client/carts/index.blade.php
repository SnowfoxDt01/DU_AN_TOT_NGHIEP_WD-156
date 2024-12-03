@extends('layout.client.master')
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
                            <p><strong>Người dùng:</strong> {{ $shoppingCart->user->name }}</p>
                        </div>
                    @endif
                    <hr>
                    <div
                        class="column-labels py-3 px-4 d-flex justify-content-between align-items-center fw-bold text-white text-uppercase">
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
                                        <p class="remaining-quantity">Còn lại {{ $item->variantProduct->quantity }} sản phẩm
                                        </p>
                                    </small>
                                </form>
                                <div class="product-line-price">
                                    <?php
                                    // Tính giá trị cho từng sản phẩm
                                    $productPrice = $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->base_price;
                                    $totalPrice = $productPrice * $item->quantity;
                                    $cartTotal += $totalPrice; // Cộng dồn vào tổng giá trị giỏ hàng
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
                                    {{ number_format($cartTotal, 0, ',', '.') }}.đ
                                </div>
                            </div>
                        </div>
                </div>
                <div class="cart-actions">
                    <a href="{{ route('client.checkout.index') }}"
                        class="d-inline-block text-center btn-two mt-30 px-4 py-3">
                        <span>Thanh toán</span>
                    </a>
                </div>
            @else
                <span class="text-danger">Chưa có sản phẩm nào trong giỏ hàng!</span>
                @endif
            </div>
        </section>
    </main>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.decrease-quantity, .increase-quantity').click(function(event) {
                event.preventDefault();

                var input = $(this).siblings('input');
                var currentVal = parseInt(input.val()); // Lấy giá trị hiện tại của input
                var maxVal = parseInt(input.attr('max')); // Lấy giá trị tối đa từ thuộc tính max của input

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
                    var itemId = $(this).closest('.product').data('item-id'); // Lấy id của item

                    // Gửi yêu cầu AJAX để cập nhật giỏ hàng
                    $.ajax({
                        url: "{{ route('client.cart.update', ':itemId') }}".replace(':itemId',
                            itemId),
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            quantity: input.val()
                        },
                        success: function(response) {
                            // Cập nhật tổng giá của sản phẩm cụ thể
                            if (response.lineTotal) {
                                $(input).closest('.product').find('.product-line-price').text(
                                    response.lineTotal);
                            }

                            // Cập nhật tổng tiền giỏ hàng nếu có
                            if (response.cartTotal) {
                                $('#cart-subtotal').text(response.cartTotal);
                            }

                            console.log('Line Total:', response.lineTotal);
                            console.log('Cart Total:', response.cartTotal);

                            toastr.success('Số lượng sản phẩm đã được cập nhật', 'Thông báo', {
                                "timeOut": 3000,
                                "backgroundColor": "#28a745", // Màu xanh lá
                                "iconClass": "toast-success"
                            });
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
            });
        });


        function confirmDelete() {
            return confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?");
        }
    </script>


@endsection
