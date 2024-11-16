@extends('layout.client.master')
@section('content')
    <section class="page-banner bg-image pt-130 pb-130" data-background="assets/images/banner/inner-banner.jpg">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Sản phẩm</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Home <i
                        class="fa-regular text-white fa-angle-right"></i></a>
                <span>Sản phẩm</span>
            </div>
        </div>
    </section>
    <!-- Page banner area end here -->

    <!-- Product area start here -->
    <section class="product-area pt-130 pb-130">
        <div class="container">
            <div class="pb-20 bor-bottom shop-page-wrp d-flex justify-content-between align-items-center mb-65">
                <p class="fw-600">Tìm thấy {{ count($products) }} sản phẩm.</p>
                <div class="short">
                    <select name="shortList" id="shortList">
                        <option value="0">Short by popularity</option>
                        <option value="1">E-Cigarette</option>
                        <option value="2">POP Extra</option>
                        <option value="3">Charger Kit</option>
                        <option value="4">100ml Nic</option>
                        <option value="5">Salt Juice</option>
                    </select>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-xl-3 col-lg-4">
                    <div class="product__left-item sub-bg">
                        <h4 class="mb-30 left-title">Deal chớp nhoáng!</h4>
                        @foreach ($flash_sale_products as $flash)
                            <div class="image pt-40 mb-30 bor-top mt-40">
                                @if ($flash->images->count() > 0)
                                    <img src="{{ $flash->images->first()->image_path }}" alt="image">
                                @else
                                    <img src="{{ asset('default_image.jpg') }}" alt="No Image" class="img-thumbnail"
                                        width="100">
                                @endif
                            </div>
                            <div class="product__content p-0">
                                <h4 class="mb-15"><a class="primary-hover" href="shop-single.html">
                                        {{ $flash->name }}</a></h4>
                                @if ($flash->flash_sale_price == 0)
                                    <span class="primary-color ml-10">{{ number_format($flash->base_price) }}.đ</span>
                                @else
                                    <div style="display: inline-flex; align-items: center; white-space: nowrap;">
                                        <del>{{ number_format($flash->base_price) }}.đ</del>
                                        <span
                                            class="primary-color ml-10">{{ number_format($flash->flash_sale_price) }}.đ</span>
                                    </div>
                                @endif
                                <div class="star mt-20">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                            </div>
                        @endforeach
                        <div class="product__coundown pt-30 bor-top mt-40">
                            <h4>Hurry Up!</h4>
                            <span>offer ends in</span>
                            <div class="d-flex align-items-center gap-3 flex-wrap mt-25">
                                <div class="coundown-item">
                                    <span id="day"></span>
                                    <h6>Day</h6>
                                </div>
                                <div class="coundown-item">
                                    <span id="hour"></span>
                                    <h6>hour</h6>
                                </div>
                                <div class="coundown-item">
                                    <span id="min"></span>
                                    <h6>min</h6>
                                </div>
                                <div class="coundown-item">
                                    <span id="sec"></span>
                                    <h6>Sec</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="row g-4">
                        @foreach ($products as $product)
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="product__item bor">
                                    <a href="#0" class="wishlist"><i class="fa-regular fa-heart"></i></a>
                                    <a href="{{ route('client.detailProduct', $product->id) }}"
                                        class="product__image pt-20 d-block">
                                        @if ($product->images->count() > 0)
                                            <img class="font-image" src="{{ $product->images->first()->image_path }}"
                                                alt="image" height="320px">
                                            <img class="back-image" src="{{ $product->images->first()->image_path }}"
                                                alt="image" height="320px">
                                        @else
                                            <img src="{{ asset('default_image.jpg') }}" alt="No Image"
                                                class="img-thumbnail" width="100">
                                        @endif
                                    </a>
                                    <div class="product__content">
                                        <h4 class="mb-15"><a class="primary-hover"
                                                href="{{ route('client.detailProduct', $product->id) }}"
                                                style="display: inline-block; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $product->name }}</a></h4>
                                        @if ($product->sale_price == 0)
                                            <span
                                                class="primary-color ml-10">{{ number_format($product->base_price) }}.đ</span>
                                        @elseif($product->flash_sale_price > 0)
                                            <del>{{ number_format($product->base_price) }}.đ</del>
                                            <span
                                                class="primary-color ml-10">{{ number_format($product->flash_sale_price) }}.đ</span>
                                        @else
                                            <del>{{ number_format($product->base_price) }}.đ</del>
                                            <span
                                                class="primary-color ml-10">{{ number_format($product->sale_price) }}.đ</span>
                                        @endif
                                        <div class="star mt-20">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                        </div>

                                    </div>
                                    <a class="product__cart d-block bor-top"
                                        href="{{ route('client.detailProduct', $product->id) }}"><i
                                            class="fa-regular fa-cart-shopping primary-color me-1"></i>
                                        <span>Chi tiết sản phẩm</span></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $products->links('pagination::custom') }}
                </div>
            </div>
        </div>
    </section>
@endsection
