@extends('layout.client.master')
@section('content')
    <section class="page-banner bg-image pt-130 pb-130" data-background="assets/images/banner/inner-banner.jpg">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">{{ $category->name_category }}</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Home <i
                        class="fa-regular text-white fa-angle-right"></i></a>
                <span>{{ $category->name_category }}</span>
            </div>
        </div>
    </section>
    <!-- Page banner area end here -->

    <!-- Product area start here -->
    <section class="product-area pt-130 pb-130">
        <div class="container">
            <div class="pb-20 bor-bottom shop-page-wrp d-flex justify-content-between align-items-center mb-65">
                <p class="fw-600">Tìm thấy {{ count($productsOfCategory) }} sản phẩm.</p>
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
                        <h4 class="mb-30 left-title">Danh mục</h4>
                        @foreach ($categories as $cate)
                            <li><a class="primary-hover"
                                    href="{{ route('client.category', $cate->id) }}">{{ $cate->name_category }}</a></li>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="row g-4">
                        @if (count($productsOfCategory) >= 1)
                            @foreach ($productsOfCategory as $product)
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="product__item bor">
                                        <a href="#0" class="wishlist"><i class="fa-regular fa-heart"></i></a>
                                        <a href="{{ route('client.detailProduct', $product->id) }}"
                                            class="product__image pt-20 d-block">
                                            <img class="font-image" src="{{ $product->image }}" alt="image"
                                                height="320px">
                                            <img class="back-image" src="{{ $product->image }}" height="320px"
                                                alt="image">
                                        </a>
                                        <div class="product__content">
                                            <h4 class="mb-15"><a class="primary-hover"
                                                    href="{{ route('client.detailProduct', $product->id) }}"
                                                    style="display: inline-block; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $product->name }}</a></h4>
                                            @if ($product->sale_price == 0)
                                                <span
                                                    class="primary-color ml-10">{{ number_format($product->base_price) }}.đ</span>
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
                                        <a class="product__cart d-block bor-top" href="#0"><i
                                                class="fa-regular fa-cart-shopping primary-color me-1"></i> <span>Add to
                                                cart</span></a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Chưa có sản phẩm thuộc danh mục này!</p>
                        @endif
                    </div>
                    {{ $productsOfCategory->links('pagination::custom') }}
                </div>
            </div>
        </div>
    </section>
@endsection
