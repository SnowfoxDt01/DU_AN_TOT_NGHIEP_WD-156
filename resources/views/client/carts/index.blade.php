@extends('layout.client.master')
@push('styles')
    <style>

.decrease-quantity, .increase-quantity {
    background-color: transparent;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    padding: 5px;
}

.decrease-quantity:hover, .increase-quantity:hover {
    background-color: #555;
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
                        <div class="product p-4 bor-bottom d-flex justify-content-between align-items-center">
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
                                    {{ number_format($item->product->sale_price, 0, ',', '.') }}
                                @else
                                    {{ number_format($item->product->base_price, 0, ',', '.') }}
                                @endif
                            </div>
                            <form action="{{ route('client.cart.update', $item->id) }}" method="POST">
                                @csrf
                                <div class="product-quantity">
                                    <button class="decrease-quantity"><i class="fas fa-minus"></i></button>
                                    <input type="number" value="{{ $item->quantity }}" min="1">
                                    <button class="increase-quantity"><i class="fas fa-plus"></i></button>
                                </div>
                            </form>
                            <div class="product-line-price">
                                <?php
                                // Tính giá trị cho từng sản phẩm
                                $productPrice = $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->base_price;
                                $totalPrice = $productPrice * $item->quantity;
                                $cartTotal += $totalPrice; // Cộng dồn vào tổng giá trị giỏ hàng
                                ?>
                                {{ number_format($totalPrice, 0, ',', '.') }}
                              </div>
                            <div class="product-removal">
                                <button class="remove-product">
                                    <i class="fa-solid fa-x heading-color"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <div class="totals">
                        <div class="totals-item theme-color float-end mt-20">
                          <span class="fw-bold text-uppercase py-2">Tổng tiền =</span>
                          <div class="totals-value d-inline py-2 pe-2" id="cart-subtotal">
                            {{ number_format($cartTotal, 0, ',', '.') }}  </div>
                        </div>
                    </div>

                @else
                    <p>Chưa có sản phẩm nào trong giỏ hàng.</p>
                @endif
            </div>
        </div>
    </section>
</main>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.decrease-quantity').click(function() {
            var input = $(this).next('input');
            var currentVal = parseInt(input.val());
            if (currentVal > 1) {
                input.val(currentVal - 1);
            }
        });
    
        $('.increase-quantity').click(function() {
            var input = $(this).prev('input');
            input.val(parseInt(input.val()) + 1);
        });
    });
</script>

@endsection
