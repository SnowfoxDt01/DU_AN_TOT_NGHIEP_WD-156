@extends('layout.client.master')

@push('styles')
    <style>
        .countdown-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-top: 15px;
        }

        .coundown-item {
            text-align: center;
            width: 50px;
        }

        .countdown-number {
            font-size: 15px;
            font-weight: bold;
            display: block;
        }

        h6 {
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
@endpush

@section('content')
    <section class="page-banner bg-image pt-130 pb-130" data-background="assets/images/banner/inner-banner.jpg">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Sản Phẩm Mới</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Home <i
                        class="fa-regular text-white fa-angle-right"></i></a>
                <span>Sản Phẩm Mới</span>
            </div>
        </div>
    </section>

    <section class="product-area pt-130 pb-130">
        <div class="container">
            <div class="pb-20 bor-bottom shop-page-wrp d-flex justify-content-between align-items-center mb-65">
                <p class="fw-600">Tìm thấy {{ count($newProducts) }} sản phẩm mới.</p>
            </div>
            <div class="row g-4">
                <div class="col-xl-3 col-lg-4">
                    <div class="product__left-item sub-bg text-center">
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
                                <h4 class="mb-15"><a class="primary-hover" href="shop-single.html">{{ $flash->name }}</a></h4>
                                @if ($flash->flash_sale_price == 0)
                                    <span class="primary-color ml-10">{{ number_format($flash->base_price) }}.đ</span>
                                @else
                                    <div style="display: inline-flex; align-items: center; white-space: nowrap;">
                                        <del>{{ number_format($flash->base_price) }}.đ</del>
                                        <span class="primary-color ml-10">{{ number_format($flash->flash_sale_price) }}.đ</span>
                                    </div>
                                @endif
                                <div class="star mt-20">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <p>Lượt xem: {{ $flash->views }}</p>
                            </div>
                        @endforeach
                        <div class="product__coundown pt-30 bor-top mt-20 text-center">
                            <span>Ưu đãi kết thúc sau:</span>
                            <div class="d-flex justify-content-center gap-3 flex-wrap mt-25">
                                <div class="coundown-item text-center">
                                    <span id="day" class="countdown-number">00</span>
                                    <h6>Ngày</h6>
                                </div>
                                <div class="coundown-item text-center">
                                    <span id="hour" class="countdown-number">00</span>
                                    <h6>Giờ</h6>
                                </div>
                                <div class="coundown-item text-center">
                                    <span id="min" class="countdown-number">00</span>
                                    <h6>Phút</h6>
                                </div>
                                <div class="coundown-item text-center">
                                    <span id="sec" class="countdown-number">00</span>
                                    <h6>Giây</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="row g-4">
                        @foreach ($newProducts as $product)
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="product__item bor">
                                    <a href="#0" class="wishlist"><i class="fa-regular fa-heart"></i></a>
                                    <a href="{{ route('client.detailProduct', $product->id) }}" class="product__image pt-20 d-block">
                                        @if ($product->images->count() > 0)
                                            <img class="font-image" src="{{ $product->images->first()->image_path }}" alt="image" height="320px">
                                            <img class="back-image" src="{{ $product->images->first()->image_path }}" alt="image" height="320px">
                                        @else
                                            <img src="{{ asset('default_image.jpg') }}" alt="No Image" class="img-thumbnail" width="100">
                                        @endif
                                    </a>
                                    <div class="product__content">
                                        <h4 class="mb-15"><a class="primary-hover" href="{{ route('client.detailProduct', $product->id) }}"
                                                style="display: inline-block; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $product->name }}</a></h4>
                                        @if ($product->sale_price == 0)
                                            <span class="primary-color ml-10">{{ number_format($product->base_price) }}.đ</span>
                                        @elseif($product->flash_sale_price > 0)
                                            <del>{{ number_format($product->base_price) }}.đ</del>
                                            <span class="primary-color ml-10">{{ number_format($product->flash_sale_price) }}.đ</span>
                                        @else
                                            <del>{{ number_format($product->base_price) }}.đ</del>
                                            <span class="primary-color ml-10">{{ number_format($product->sale_price) }}.đ</span>
                                        @endif
                                        @php
                                            $totalReviews = $product->reviews->count();
                                            $averageRating = $totalReviews > 0 ? $product->reviews->avg('rating') : 0;
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
                                        <p>Lượt xem: {{ $product->views }}</p>
                                    </div>
                                    <a class="product__cart d-block bor-top" href="{{ route('client.detailProduct', $product->id) }}">
                                        <i class="fa-regular fa-cart-shopping primary-color me-1"></i>
                                        <span>Chi tiết sản phẩm</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $newProducts->links('pagination::custom') }}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countdownDate = new Date("2024-12-31T23:59:59").getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = countdownDate - now;

                if (distance > 0) {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("day").textContent = days;
                    document.getElementById("hour").textContent = hours;
                    document.getElementById("min").textContent = minutes;
                    document.getElementById("sec").textContent = seconds;
                } else {
                    document.querySelector(".product__coundown").innerHTML = "<span>Khuyến mãi kết thúc!</span>";
                }
            }

            setInterval(updateCountdown, 1000);
        });
    </script>
@endpush
