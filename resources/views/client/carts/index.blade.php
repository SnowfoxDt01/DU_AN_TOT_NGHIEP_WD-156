@extends('layout.client.master')

@section('content')
<main>
    <section class="page-banner bg-image pt-130 pb-130" data-background="">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Trang giỏ hàng</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{route('client.index')}}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Trang chủ <i class="fa-regular text-white fa-angle-right"></i></a>
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

                <div class="column-labels py-3 px-4 d-flex justify-content-between align-items-center fw-bold text-white text-uppercase">
                    <label class="product-details">Product</label>
                    <label class="product-price">Price</label>
                    <label class="product-quantity">Quantity</label>
                    <label class="product-line-price">Total</label>
                    <label class="product-removal">Edit</label>
                </div>

                @if (isset($shoppingCart) && $shoppingCart->items->count() > 0)
                    @foreach ($shoppingCart->items as $item)
                        <div class="product p-4 bor-bottom d-flex justify-content-between align-items-center">
                            <div class="product-details d-flex align-items-center">
                                <img src="{{ $item->variantProduct->images->first()->image_path }}" alt="image">
                                <h4 class="ps-4 text-capitalize">{{ $item->variantProduct->name }}</h4>
                            </div>
                            <div class="product-price">{{ number_format($item->price, 0, ',', '.') }}</div>
                            <div class="product-quantity">
                                <input type="number" value="{{ $item->quantity }}" min="1">
                            </div>
                            <div class="product-line-price">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                            <div class="product-removal">
                                <button class="remove-product">
                                    <i class="fa-solid fa-x heading-color"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <div class="totals">
                        <div class="totals-item theme-color float-end mt-20">
                            <span class="fw-bold text-uppercase py-2">cart total =</span>
                            <div class="totals-value d-inline py-2 pe-2" id="cart-subtotal">{{ number_format($shoppingCart->items->sum('price' * 'quantity'), 0, ',', '.') }}</div>
                        </div>
                    </div>

                @else
                    <p>Chưa có sản phẩm nào trong giỏ hàng.</p>
                @endif
            </div>
        </div>
    </section>
</main>

@endsection