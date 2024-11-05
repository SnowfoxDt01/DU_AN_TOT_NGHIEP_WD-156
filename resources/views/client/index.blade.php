@extends('layout.client.master')
@section('content')
    <!-- Banner area start here -->
    <section class="banner-two">
        {{-- <div class="banner-two__shape-left d-none d-lg-block wow bounceInLeft" data-wow-duration="1s" data-wow-delay=".5s">
            <img src="client_ui/assets/images/shape/vape1.png" alt="shape">
        </div> --}}
        <div class="banner-two__shape-right d-none d-lg-block wow bounceInRight" data-wow-duration="1s" data-wow-delay=".1s">
            <img class="sway_Y__animation" src="client_ui/assets/images/logo/mainlogo.png" alt="shape"
                style="margin-right: 100px;"> <!-- Thay đổi giá trị -20px tùy ý -->
        </div>

        <div class="swiper banner-two__slider">
            <div class="swiper-wrapper">
                @foreach ($banners as $banner)
                    <div class="swiper-slide">
                        <div class="slide-bg" data-background="{{ $banner->image_url }}"></div>
                        <div class="container">
                            <div class="banner-two__content">
                                <h4 data-animation="fadeInUp" data-delay="1s"><img
                                        src="client_ui/assets/images/icon/fire.svg" alt="icon"> NHẬN <span
                                        class="primary-color">KHUYẾN MÃI </span> NGAY</h4>
                                <h1 data-animation="fadeInUp" data-delay="1.3s">{{ $banner->title }}<br></h1>
                                <p class="mt-40" data-animation="fadeInUp" data-delay="1.5s">{!! nl2br($banner->description) !!}</p>
                                <div class="btn-wrp mt-65">
                                    <a class="btn-one-light ml-20" href="shop-single.html" data-animation="fadeInUp"
                                        data-delay="1.9s"><span>Xem chi tiết</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="banner-two__arry-btn">
            <button class="arry-prev mb-15 banner-two__arry-prev"><i class="fa-light fa-chevron-left"></i></button>
            <button class="arry-next active banner-two__arry-next"><i class="fa-light fa-chevron-right"></i></button>
        </div>
    </section>
    <!-- Banner area end here -->

    <!-- Category area start here -->
    <section class="category-area category-two pb-130 pt-130">
        <div class="container">
            <div class="bor-bottom pb-130">
                <div class="sub-title text-center mb-65 wow fadeInUp" data-wow-delay=".1s">
                    <h3><span class="title-icon"></span>Danh mục nổi bật<span class="title-icon"></span></h3>
                </div>
                <div class="swiper category__slider">
                    <div class="swiper-wrapper">
                        @foreach ($categories as $category)
                            <div class="swiper-slide">
                                <div class="category__item category-two__item text-center">
                                    <a href="{{ route('client.category', $category->id) }}" class="category__image d-block">
                                        <div class="category-icon">
                                            <img src="{{ $category->image }}" alt="{{ $category->name }}">
                                        </div>
                                    </a>
                                    <h4 class="mt-30">
                                        <a
                                            href="{{ route('client.category', $category->id) }}">{{ $category->name_category }}</a>
                                    </h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category area end here -->

    <!-- View area start here -->
    <section class="view-area">
        <div class="bg-image view__bg" data-background="client_ui/assets/images/bg/view-bg.jpg"></div>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".1s">
                    <div class="view__left-item">
                        <div class="image">
                            <img src="client_ui/assets/images/banner/test.webp" alt="image">
                        </div>
                        <div class="view__left-content sub-bg">
                            <h2><a class="primary-hover" href="shop-single.html">The best e-liqued bundles</a>
                            </h2>
                            <p class="fw-600">Sell globally in minutes with localized currencies languages, and
                                experie
                                in every market. only a variety of vaping
                                products</p>
                            <a class="btn-two" href="shop-single.html"><span>Shop Now</span></a>
                            <a class="off-btn" href="#0"><img class="mr-10"
                                    src="client_ui/assets/images/icon/fire.svg" alt="icon"> GET
                                <span class="primary-color">25%
                                    OFF</span> NOW</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="view__item mb-25 wow fadeInDown" data-wow-delay=".2s">
                        <div class="view__content">
                            <h3><a class="primary-hover" href="shop-single.html">new to vapeing?</a></h3>
                            <p>Whereas recognition of the inherent dignity</p>
                            <a class="btn-two" href="shop-single.html"><span>Shop Now</span></a>
                        </div>
                        <div class="view__image">
                            <img src="client_ui/assets/images/banner/test2.png" alt="image">
                        </div>
                    </div>
                    <div class="view__item wow fadeInUp" data-wow-delay=".3s">
                        <div class="view__content">
                            <h3><a class="primary-hover" href="shop-single.html">Vap mode</a></h3>
                            <p>Whereas recognition of the inherent dignity</p>
                            <a class="btn-two" href="shop-single.html"><span>Shop Now</span></a>
                        </div>
                        <div class="view__image">
                            <img src="client_ui/assets/images/banner/test3.jpg" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- View area end here -->

    <!-- Product area start here -->
    <section class="product-area pt-130 pb-130 mt-130">
        <div class="container">
            <div
                class="product__wrp pb-30 mb-65 bor-bottom d-flex flex-wrap align-items-center justify-content-xl-between justify-content-center">
                <div class="section-header d-flex align-items-center wow fadeInUp" data-wow-delay=".1s">
                    <span class="title-icon mr-10"></span>
                    <h2>NỔI BẬT</h2>
                </div>
                <ul class="nav nav-pills mt-4 mt-xl-0">
                    <li class="nav-item wow fadeInUp" data-wow-delay=".1s">
                        <a href="#new-item" data-bs-toggle="tab" class="nav-link px-4 active">
                            Sản phẩm mới
                        </a>
                    </li>
                    <li class="nav-item wow fadeInUp" data-wow-delay=".2s">
                        <a href="#hot-product" data-bs-toggle="tab" class="nav-link px-4 bor-left bor-right">
                            Top 10 sản phẩm bán chạy
                        </a>
                    </li>
                    <li class="nav-item wow fadeInUp" data-wow-delay=".3s">
                        <a href="#top-rating" data-bs-toggle="tab" class="nav-link ps-4">
                            Top 10 sản phẩm đánh giá cao nhất
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                {{-- Sản phẩm mới --}}
                <div id="new-item" class="tab-pane fade show active">
                    <div class="row g-4">
                        @php $count = 0; @endphp
                        @foreach ($newProducts as $new)
                            @if ($count < 12)
                                <div class="col-xxl-3 col-xl-4 col-md-6">
                                    <div class="product__item bor">
                                        <a href="#0" class="wishlist"><i class="fa-regular fa-heart"></i></a>
                                        <a href="{{ route('client.detailProduct', $new->id) }}"
                                            class="product__image pt-20 d-block">
                                            @if ($new->images->count() > 0)
                                                <img class="font-image" src="{{ $new->images->first()->image_path }}"
                                                    alt="image" height="320px">
                                                <img class="back-image" src="{{ $new->images->first()->image_path }}"
                                                    alt="image" height="320px">
                                            @else
                                                <img src="{{ asset('default_image.jpg') }}" alt="No Image"
                                                    class="img-thumbnail" width="100">
                                            @endif

                                        </a>
                                        <div class="product__content">
                                            <h4 class="mb-15"><a class="primary-hover"
                                                    href="{{ route('client.detailProduct', $new->id) }}"
                                                    style="display: inline-block; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $new->name }}</a>
                                            </h4>
                                            @if ($new->sale_price == 0)
                                                <span
                                                    class="primary-color ml-10">{{ number_format($new->base_price) }}.đ</span>
                                            @else
                                                <del>{{ number_format($new->base_price) }}.đ</del>
                                                <span
                                                    class="primary-color ml-10">{{ number_format($new->sale_price) }}.đ</span>
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
                                                class="fa-regular fa-cart-shopping primary-color me-1"></i>
                                            <span>Thêm vào giỏ hàng</span></a>
                                    </div>
                                </div>
                                @php $count++; @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
                {{-- Top 10 sản phẩm bán chạy --}}
                <div id="hot-product" class="tab-pane fade">
                    <div class="row g-4">
                        @php $count = 0; @endphp
                        @foreach ($topProducts as $top)
                            @if ($count < 12)
                                <div class="col-xxl-3 col-xl-4 col-md-6">
                                    <div class="product__item bor">
                                        <a href="#0" class="wishlist"><i class="fa-regular fa-heart"></i></a>
                                        <a href="{{ route('client.detailProduct', $top->product->id) }}"
                                            class="product__image pt-20 d-block">
                                            <img class="font-image" src="{{ $top->product->image }}" alt="image"
                                                height="320px">
                                            <img class="back-image" src="{{ $top->product->image }}" alt="image"
                                                height="320px">
                                        </a>
                                        <div class="product__content">
                                            <h4 class="mb-15"><a class="primary-hover"
                                                    href="{{ route('client.detailProduct', $top->product->id) }}"
                                                    style="display: inline-block; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $top->product->name }}</a>
                                            </h4>
                                            @if ($top->product->sale_price == 0)
                                                <span
                                                    class="primary-color ml-10">{{ number_format($top->product->base_price) }}.đ</span>
                                            @else
                                                <del>{{ number_format($top->product->base_price) }}.đ</del>
                                                <span
                                                    class="primary-color ml-10">{{ number_format($top->product->sale_price) }}.đ</span>
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
                                                class="fa-regular fa-cart-shopping primary-color me-1"></i>
                                            <span>Thêm vào giỏ hàng</span></a>
                                    </div>
                                </div>
                                @php $count++; @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
                {{-- Top 10 sản phẩm đánh giá cao nhất --}}
                <div id="top-rating" class="tab-pane fade">
                    <div class="row g-4">
                        <div class="col-xxl-3 col-xl-4 col-md-6">
                            <div class="product__item bor">
                                <a href="#0" class="wishlist"><i class="fa-regular fa-heart"></i></a>
                                <a href="shop-single.html" class="product__image pt-20 d-block">
                                    <img class="font-image" src="client_ui/assets/images/product/product-image1.png"
                                        alt="image">
                                    <img class="back-image" src="client_ui/assets/images/product/product-image3.png"
                                        alt="image">
                                </a>
                                <div class="product__content">
                                    <h4 class="mb-15"><a class="primary-hover" href="shop-single.html">Menthol
                                            E-Cigarette Kit</a></h4>
                                    <del>$74.50</del><span class="primary-color ml-10">$49.50</span>
                                    <div class="star mt-20">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>

                                </div>
                                <a class="product__cart d-block bor-top" href="#0"><i
                                        class="fa-regular fa-cart-shopping primary-color me-1"></i>
                                    <span>Thêm vào giỏ hàng</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product area end here -->

    <!-- Get now area start here -->
    <section class="get-now-area pt-130 pb-130">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <h4 class="mb-30 wow fadeInUp" data-wow-delay=".1s"><img src="client_ui/assets/images/icon/fire.svg"
                            alt="icon">
                        GET <span class="primary-color">25% OFF</span> NOW</h4>
                    <div class="section-header d-flex align-items-center wow fadeInUp" data-wow-delay=".2s">
                        <span class="title-icon mr-10"></span>
                        <h2>latest arrival products</h2>
                    </div>
                    <div class="get-now__content">
                        <div class="get-info py-4 wow fadeInUp" data-wow-delay=".2s">
                            <del>$99.00</del> <span>$49.00</span>
                        </div>
                        <p class="fw-600 wow fadeInUp" data-wow-delay=".3s">There are many variations of passages of
                            Lorem Ipsum available, but <br>
                            the
                            majority have
                            suffered alteration in some form,
                            by injected humour, or randomised words which</p>
                        <ul class="pt-30 pb-30 bor-bottom wow fadeInUp" data-wow-delay=".3s">
                            <li>100% Natural</li>
                            <li>Coupon $61.99, Code: W2</li>
                            <li>30 Day Refund</li>
                        </ul>
                        <div class="time-up d-flex flex-wrap align-items-center gap-5 mt-30 wow fadeInUp"
                            data-wow-delay=".4s">
                            <div class="info">
                                <h4>HUNGRY UP !</h4>
                                <span>Offer end in :</span>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <div class="get-time">
                                    <h3 id="day">00</h3>
                                    <span>Day</span>
                                </div>
                                <div class="get-time">
                                    <h3 id="hour">00</h3>
                                    <span>Hr</span>
                                </div>
                                <div class="get-time">
                                    <h3 id="min">00</h3>
                                    <span>Min</span>
                                </div>
                                <div class="get-time">
                                    <h3 id="sec">00</h3>
                                    <span>Sec</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="get-now__image mt-5 mt-xl-0">
                        <div class="get-bg-image">
                            <img src="client_ui/assets/images/bg/nen1.png" alt="image">
                        </div>
                        <div class="swiper get__slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="image">
                                        <img src="client_ui/assets/images/shop/test3.png" alt="image">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="image">
                                        <img src="client_ui/assets/images/shop/flashsale4.png" alt="image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="get-now-arry get-now__arry-left">
                            <i class="fa-light fa-chevron-left"></i>
                        </button>
                        <button class="get-now-arry get-now__arry-right text-warning">
                            <i class="fa-light fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Get now area end here -->

    <!-- Text slider area start here -->
    <div class="container">
        <div class="bor-top pb-40"></div>
    </div>
    <div class="marquee-wrapper text-slider">
        <div class="marquee-inner to-left">
            <ul class="marqee-list d-flex">
                <li class="marquee-item">
                    @foreach ($categories as $category)
                        {{ $category->name_category }} <img src="client_ui/assets/images/icon/title-left.svg"
                            alt="icon">
                    @endforeach
                </li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="bor-top pb-65"></div>
    </div>
    <!-- Text slider area end here -->

    <!-- Gallery area start here -->
    <section class="gallery-area">
        <div class="swiper gallery__slider">
            <div class="swiper-wrapper">
                @foreach ($sale_products as $sale)
                    <div class="swiper-slide">
                        <div class="gallery__item">
                            <div class="off-tag">SALE<br>
                                OFF</div>
                            <br>
                            <div class="gallery__image image">
                                <img src="{{ $sale->image }}" alt="image" height="320px">
                            </div>
                            <div class="gallery__content">
                                <h3 class="mb-10"><a
                                        href="{{ route('client.detailProduct', $sale->id) }}">{{ $sale->name }}</a>
                                </h3>
                                <p
                                    style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 270px;">
                                    {{ $sale->description }}</p>
                                <a href="{{ route('client.detailProduct', $sale->id) }}" class="btn-two mt-25"><span>Mua
                                        ngay</span></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Gallery area end here -->
@endsection
