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
            <div class="sub-title text-center mb-65 wow fadeInUp" data-wow-delay=".1s">
                <h3><span class="title-icon"></span>Bài viết nổi bật<span class="title-icon"></span></h3>
            </div>
            <div class="row g-4">
                @foreach ($blogs as $blog)
                    <div class="col-lg-6">
                        <div class="view__item wow fadeInUp" data-wow-delay=".3s">
                            <div class="view__content">
                                <h3><a class="primary-hover"
                                        href="{{ route('client.blog.detailBlog', $blog->id) }}">{{ $blog->title }}</a></h3>
                                <p>{!! $blog->description !!}</p>
                                <a class="btn-two" href="{{ route('client.blog.detailBlog', $blog->id) }}"><span>Xem
                                        ngay</span></a>
                            </div>
                            <div class="view__image">
                                <img src="{{ $blog->image }}" alt="image">
                            </div>
                        </div>
                    </div>
                @endforeach
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
                </ul>
            </div>
            <div class="tab-content">
                {{-- Sản phẩm mới --}}
                <div id="new-item" class="tab-pane fade show active">
                    <div class="row g-4">
                        @php $count = 0; @endphp
                        @foreach ($newProducts as $new)
                            @if ($count < 8)
                                <div class="col-xxl-3 col-xl-4 col-md-6">
                                    <div class="product__item bor">
                                        <a href="{{ route('client.detailProduct', $new->id) }}" class="wishlist"><i
                                                class="fa-regular fa-heart"></i></a>
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
                                            @if ($new->flash_sale_price > 0)
                                                <del>{{ number_format($new->base_price) }}.đ</del>
                                                <span
                                                    class="primary-color ml-10">{{ number_format($new->flash_sale_price) }}.đ</span>
                                            @elseif ($new->sale_price > 0)
                                                <del>{{ number_format($new->base_price) }}.đ</del>
                                                <span
                                                    class="primary-color ml-10">{{ number_format($new->sale_price) }}.đ</span>
                                            @else
                                                <span
                                                    class="primary-color ml-10">{{ number_format($new->base_price) }}.đ</span>
                                            @endif
                                            @php
                                                $totalReviews = $new->reviews->count();

                                                $averageRating = $totalReviews > 0 ? $new->reviews->avg('rating') : 0;
                                            @endphp
                                            <div class="star mt-20">
                                                @for ($i = 0; $i < 5; $i++)
                                                    @if ($i < floor($averageRating))
                                                        <i class="fas fa-star"></i>
                                                    @elseif ($i < ceil($averageRating) && $averageRating - $i > 0)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p>Lượt xem: {{ $new->views }}</p>
                                        </div>
                                        <a class="product__cart d-block bor-top"
                                            href="{{ route('client.detailProduct', $new->id) }}"><i
                                                class="fa-regular bi bi-eye primary-color me-1"></i>
                                            <span>Chi tiết sản phẩm</span></a>
                                    </div>
                                </div>
                                @php $count++; @endphp
                            @endif
                        @endforeach
                    </div>
                    <!-- Nút Xem thêm cho sản phẩm mới -->
                    <div class="text-center mt-5">
                        <a href="{{ route('client.new') }}" class="btn-one-light"><span>Xem thêm +</span></a>
                    </div>
                </div>
                {{-- Top 10 sản phẩm bán chạy --}}
                <div id="hot-product" class="tab-pane fade">
                    <div class="row g-4">
                        @php $count = 0; @endphp
                        @foreach ($topProducts as $top)
                            @if ($count < 8)
                                <div class="col-xxl-3 col-xl-4 col-md-6">
                                    <div class="product__item bor">
                                        <a href="#0" class="wishlist"><i class="fa-regular fa-heart"></i></a>
                                        <a href="{{ route('client.detailProduct', $top->product->id) }}"
                                            class="product__image pt-20 d-block">
                                            @if ($top->product->images->count() > 0)
                                                <img class="font-image"
                                                    src="{{ $top->product->images->first()->image_path }}" alt="image"
                                                    height="320px">
                                                <img class="back-image"
                                                    src="{{ $top->product->images->first()->image_path }}" alt="image"
                                                    height="320px">
                                            @else
                                                <img src="{{ asset('default_image.jpg') }}" alt="No Image"
                                                    class="img-thumbnail" width="100">
                                            @endif
                                        </a>
                                        <div class="product__content">
                                            <h4 class="mb-15"><a class="primary-hover"
                                                    href="{{ route('client.detailProduct', $top->product->id) }}"
                                                    style="display: inline-block; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $top->product->name }}</a>
                                            </h4>
                                            @if ($top->sale_price == 0)
                                                <span class="primary-color ml-10">{{ number_format($top->product->base_price) }}.đ</span>
                                            @else
                                                <del>{{ number_format($top->product->base_price) }}.đ</del>
                                                <span class="primary-color ml-10">{{ number_format($top->product->sale_price) }}.đ</span>
                                            @endif
                                            <div class="star mt-20">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <p>Lượt xem: {{ $top->product->views }}</p>
                                        </div>
                                        <a class="product__cart d-block bor-top"
                                            href="{{ route('client.detailProduct', $top->product->id) }}"><i
                                                class="bi bi-eye primary-color me-1"></i>
                                            <span>Chi tiết sản phẩm</span></a>
                                    </div>
                                </div>
                                @php $count++; @endphp
                            @endif
                        @endforeach
                    </div>
                    <!-- Nút Xem thêm cho sản phẩm bán chạy -->
                    <div class="text-center mt-5">
                        <a href="{{ route('client.top') }}" class="btn-one-light"><span>Xem thêm +</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product area end here -->

    <!-- Get now area start here -->
    @if ($flash_sale_products)
        <section class="get-now-area pt-130 pb-130">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                        <h4 class="mb-30 wow fadeInUp" data-wow-delay=".1s"><img
                                src="client_ui/assets/images/icon/fire.svg" alt="icon">
                            Nhận <span class="primary-color"> ưu đãi </span> ngay </h4>
                        <div class="section-header d-flex align-items-center wow fadeInUp" data-wow-delay=".2s">
                            <span class="title-icon mr-10"></span>
                            <h2 class="mb-15"><a class="primary-hover" href="{{ route('client.detailProduct', 19) }}">
                                    {{ $flash_sale_products->name }}</a></h2>
                        </div>
                        <div class="get-now__content">
                            <div class="get-info py-4 wow fadeInUp" data-wow-delay=".2s">
                                @if ($flash_sale_products->flash_sale_price == 0)
                                    <span class="primary-color ml-10">{{ number_format($flash->base_price) }}.đ</span>
                                @else
                                    <del>{{ number_format($flash_sale_products->base_price) }}.đ</del>
                                    <span
                                        class="primary-color ml-10">{{ number_format($flash_sale_products->flash_sale_price) }}.đ</span>
                                @endif
                            </div>
                            <p class="fw-600 wow fadeInUp" data-wow-delay=".3s">{!! $flash_sale_products->description !!}</p>
                            <div class="time-up d-flex flex-wrap align-items-center gap-5 mt-30 wow fadeInUp"
                                data-wow-delay=".4s">
                                <div class="info">
                                    <h4>Nhanh tay nào!</h4>
                                    <span>Ưu đãi kết thúc trong :</span>
                                </div>
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="get-time">
                                        <h3 id="day">00</h3>
                                        <span>Ngày</span>
                                    </div>
                                    <div class="get-time">
                                        <h3 id="hour">00</h3>
                                        <span>Giờ</span>
                                    </div>
                                    <div class="get-time">
                                        <h3 id="min">00</h3>
                                        <span>Phút</span>
                                    </div>
                                    <div class="get-time">
                                        <h3 id="sec">00</h3>
                                        <span>Giây</span>
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
                                    @foreach ($flash_sale_products->images as $flimage)
                                        <div class="swiper-slide">
                                            <div class="image">
                                                <img src="{{ $flimage->image_path }}" alt="image">
                                            </div>
                                        </div>
                                    @endforeach
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
    @endif
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
    <hr>
    <div class="swiper gallery__slider">
        <div class="swiper-wrapper">
            @foreach ($sale_products as $sale)
                <div class="swiper-slide">
                    <div class="gallery__item">
                        <div class="off-tag">SALE<br>OFF</div>
                        <br>
                        <div class="gallery__image image">
                            @if ($sale->images->count() > 0)
                                <img src="{{ $sale->images->first()->image_path }}" alt="image" height="320px">
                            @else
                                <img src="{{ asset('default_image.jpg') }}" alt="No Image" class="img-thumbnail"
                                    width="100">
                            @endif
                        </div>
                        <div class="gallery__content">
                            <h3 class="mb-10"><a
                                    href="{{ route('client.detailProduct', $sale->id) }}">{{ $sale->name }}</a></h3>
                            <a href="{{ route('client.detailProduct', $sale->id) }}" class="btn-two mt-25"><span>Mua
                                    ngay</span></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </section>
    <hr>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countdown = setInterval(() => {
                const endDate = new Date('2024-12-31T23:59:59'); // Ngày kết thúc
                const now = new Date();
                const timeRemaining = endDate - now;

                if (timeRemaining <= 0) {
                    clearInterval(countdown);
                    document.getElementById('day').textContent = "00";
                    document.getElementById('hour').textContent = "00";
                    document.getElementById('min').textContent = "00";
                    document.getElementById('sec').textContent = "00";
                    return;
                }

                const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                document.getElementById('day').textContent = days.toString().padStart(2, '0');
                document.getElementById('hour').textContent = hours.toString().padStart(2, '0');
                document.getElementById('min').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('sec').textContent = seconds.toString().padStart(2, '0');
            }, 1000);
        });
    </script>
@endpush
