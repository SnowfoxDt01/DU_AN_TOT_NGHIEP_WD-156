@extends('layout.client.master')
@push('styles')
<style>
    .countdown-wrapper {
        display: flex;
        justify-content: center; /* Canh giữa các mục */
        align-items: center; /* Canh giữa theo trục dọc */
        gap: 15px; /* Khoảng cách giữa các mục */
        margin-top: 15px; /* Khoảng cách trên */
    }

    .coundown-item {
        text-align: center; /* Canh giữa nội dung */
        width: 50px; /* Định chiều rộng cố định */
    }

    .countdown-number {
        font-size: 15px; /* Kích thước số */
        font-weight: bold; /* Tô đậm */
        display: block;
    }

    h6 {
        font-size: 12px; /* Kích thước chữ nhỏ */
        margin-top: 5px; /* Khoảng cách giữa số và chữ */
    }
</style>
@endpush
@section('content')
<section class="page-banner bg-image pt-130 pb-130" data-background="assets/images/banner/inner-banner.jpg">
    <div class="container">
        <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Sản Phẩm Bán Chạy</h2>
        <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
            <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Home <i
                    class="fa-regular text-white fa-angle-right"></i></a>
            <span>Sản Phẩm Bán Chạy</span>
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
                <select name="shortList" id="shortList" onchange="filterProducts()">
                    <option value="0">Tất cả sản phẩm</option>
                    <option value="2">Giá từ thấp đến cao</option>
                    <option value="3">Giá từ cao xuống thấp</option>
                </select>

            </div>
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
                    <div class="product__coundown pt-30 bor-top mt-20 text-center">
                        <h4>Nhanh tay lên!</h4>
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
@push('scripts')
<script>
    function filterProducts() {
        var selectedOption = document.getElementById('shortList').value;

        // Lấy tất cả các sản phẩm trong danh sách (bao gồm cả div cột)
        var productColumns = document.querySelectorAll('.col-xl-4.col-lg-6.col-md-6');
        var productsArray = Array.from(productColumns);

        if (selectedOption == '0') {
                // Khi giá trị là 0, reload lại toàn bộ danh sách sản phẩm ban đầu
                location.reload();
                return;
            }
        // Sắp xếp các sản phẩm theo lựa chọn
        if (selectedOption == '2') {
            productsArray.sort(function(a, b) {
                var priceA = parseInt(a.querySelector('.primary-color').textContent.replace(/[^\d]/g, ''));
                var priceB = parseInt(b.querySelector('.primary-color').textContent.replace(/[^\d]/g, ''));
                return priceA - priceB;
            });
        } else if (selectedOption == '3') {
            productsArray.sort(function(a, b) {
                var priceA = parseInt(a.querySelector('.primary-color').textContent.replace(/[^\d]/g, ''));
                var priceB = parseInt(b.querySelector('.primary-color').textContent.replace(/[^\d]/g, ''));
                return priceB - priceA;
            });
        }

        // Xóa tất cả các sản phẩm hiện tại và thêm lại các sản phẩm đã sắp xếp
        var productList = document.querySelector('.col-xl-9 .row.g-4');
        productList.innerHTML = '';
        productsArray.forEach(function(productColumn) {
            productList.appendChild(productColumn);
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        const countdownDate = new Date("2024-12-31T23:59:59").getTime(); // Thay đổi ngày ưu đãi kết thúc tại đây

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = countdownDate - now;

            if (distance > 0) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("day").textContent = days.toString().padStart(2, '0');
                document.getElementById("hour").textContent = hours.toString().padStart(2, '0');
                document.getElementById("min").textContent = minutes.toString().padStart(2, '0');
                document.getElementById("sec").textContent = seconds.toString().padStart(2, '0');
            } else {
                document.querySelector('.product__coundown').innerHTML = `<h4>Ưu đãi đã kết thúc!</h4>`;
            }
        }

        setInterval(updateCountdown, 1000);
    });
</script>
@endpush