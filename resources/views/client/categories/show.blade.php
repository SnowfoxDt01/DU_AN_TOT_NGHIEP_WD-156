@extends('layout.client.master')
@push('styles')
    <style>
        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
    </style>
@endpush
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
    <hr>
    <!-- Product area start here -->
    <section class="product-area pt-130 pb-130">
        <div class="container">
            <div class="pb-20 bor-bottom shop-page-wrp d-flex justify-content-between align-items-center mb-65">
                <p class="fw-600">Tìm thấy {{ count($productsOfCategory) }} sản phẩm.</p>
                <div class="short">
                    <select name="shortList" id="shortList" onchange="filterProducts()">
                        <option value="0">Tất cả sản phẩm</option>
                        <option value="1">Giá từ thấp đến cao</option>
                        <option value="2">Giá từ cao xuống thấp</option>
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

                <!-- Phần hiển thị sản phẩm sau khi lọc -->
                <div class="col-xl-9 col-lg-8">
                    <div class="product-list">
                        @if (count($productsOfCategory) >= 1)
                            @foreach ($productsOfCategory as $product)
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
                                            <img src="{{ asset('default_image.jpg') }}" alt="No Image" class="img-thumbnail"
                                                width="100">
                                        @endif
                                    </a>
                                    <div class="product__content">
                                        <h4 class="mb-15">
                                            <a class="primary-hover"
                                                href="{{ route('client.detailProduct', $product->id) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h4>
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
                                    <a class="product__cart d-block bor-top"
                                        href="{{ route('client.detailProduct', $product->id) }}">
                                        <i class="fa-regular fa-cart-shopping primary-color me-1"></i>
                                        <span>Chi tiết sản phẩm</span>
                                    </a>
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

@push('scripts')
    <script>
        function filterProducts() {
            var selectedOption = document.getElementById('shortList').value;

            // Lấy tất cả các sản phẩm trong danh sách
            var products = document.querySelectorAll('.product__item');
            var productsArray = Array.from(products);

            if (selectedOption == '0') {
                // Khi giá trị là 0, reload lại toàn bộ danh sách sản phẩm ban đầu
                location.reload();
                return;
            }
            // Sắp xếp các sản phẩm theo lựa chọn
            if (selectedOption == '1') {
                productsArray.sort(function(a, b) {
                    var priceA = parseInt(a.querySelector('.primary-color').textContent.replace(/[^\d]/g, ''));
                    var priceB = parseInt(b.querySelector('.primary-color').textContent.replace(/[^\d]/g, ''));
                    return priceA - priceB;
                });
            } else if (selectedOption == '2') {
                productsArray.sort(function(a, b) {
                    var priceA = parseInt(a.querySelector('.primary-color').textContent.replace(/[^\d]/g, ''));
                    var priceB = parseInt(b.querySelector('.primary-color').textContent.replace(/[^\d]/g, ''));
                    return priceB - priceA;
                });
            }
            // Xóa tất cả các sản phẩm hiện tại và thêm các sản phẩm đã sắp xếp
            var productList = document.querySelector('.product-list');
            productList.innerHTML = '';
            productsArray.forEach(function(product) {
                productList.appendChild(product);
            }); 
        }
        document.querySelectorAll('.product__content h4 a').forEach(function(el) {
            if (el.textContent.length > 100) {
                el.textContent = el.textContent.substring(0, 72) + '...';
            }
        });
    </script>
@endpush
