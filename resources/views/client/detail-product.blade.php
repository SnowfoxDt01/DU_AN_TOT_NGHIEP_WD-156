@extends('layout.client.master')
@section('content')
    <!-- Page banner area start here -->
    <section class="page-banner bg-image pt-130 pb-130" data-background="">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Chi tiết sản
                phẩm</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i>Trang chủ<i
                        class="fa-regular text-orangered fa-angle-right"></i></a>
                <span>Chi tiết sản phẩm</span>
            </div>
        </div>
    </section>
    <!-- Page banner area end here -->
    <hr style="color: #fff">
    <!-- Shop single area start here -->
    <section class="shop-single pt-130 pb-130">
        <div class="container">
            <!-- product-details area start here -->
            <div class="product-details-single pb-40">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="image img">
                            <div class="swiper shop-single-slide">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ $detailProduct->image }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 swiper shop-slider-thumb">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide slide-smoll">
                                        <img src="{{ $detailProduct->image }}" alt="image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="content h24">
                            <h3 class="pb-2 primary-color">{{ $detailProduct->name }}</h3>
                            <div class="star primary-color pb-2">
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
                            @if ($detailProduct->sale_price == 0)
                                <h2 class="pb-3">{{ number_format($detailProduct->base_price) }}.đ</h2>
                            @else
                                <del>{{ number_format($detailProduct->base_price) }}.đ</del>
                                <h2 class="pb-3">{{ number_format($detailProduct->sale_price) }}.đ</h2>
                            @endif
                            <h4 class="pb-2 primary-color">Mô tả sản phẩm</h4>
                            <p class="text-justify mb-10" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 500px;">
                                {{ $detailProduct->description }}
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="details-area">
                                    <div class="category flex-wrap mt-4 d-flex py-3 bor-top bor-bottom">
                                        <h4 class="pe-3">Danh mục :</h4>
                                        <a href="#0"
                                            class="primary-hover">{{ $detailProduct->category->name_category }}</a>
                                    </div>
                                    <div class="d-flex flex-wrap py-3 bor-bottom">
                                        <h4 class="pe-3">Lựa chọn :</h4>
                                        <div class="variant-images d-flex gap-2">
                                            @foreach ($detailProduct->variantProducts as $variant)
                                                <img src="{{ $variant->image_url }}" alt="variant-{{ $variant->name }}"
                                                    class="variant-thumb" style="width: 50px; cursor: pointer;"
                                                    onclick="showVariant({{ $variant->id }})">
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="cart-wrp py-4">
                                        <div class="cart-quantity">
                                            <form id='myform' method='POST' class='quantity' action='#'>
                                                <input type='button' value='-' class='qtyminus minus'>
                                                <input type='text' name='quantity' value='0' class='qty'>
                                                <input type='button' value='+' class='qtyplus plus'>
                                            </form>
                                        </div>
                                    </div>
                                    <a href="#0" class="d-block text-center btn-two mt-40"><span><i
                                                class="fa-solid fa-basket-shopping pe-2"></i>
                                            Thêm vào giỏ hàng</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- product-details area end here -->

            <!-- description review area start here -->
            <div class="shop-singe-tab">
                <ul class="nav nav-pills mb-4 bor-top bor-bottom py-2">
                    <li class="nav-item">
                        <a href="#description" data-bs-toggle="tab" class="nav-link ps-0 pe-3 active">
                            <h4 class="text-uppercase">Mô tả</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#review" data-bs-toggle="tab" class="nav-link">
                            <h4 class="text-uppercase">Đánh giá</h4>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="description" class="tab-pane fade show active">
                        <p class="pb-4 text-justify">{!! nl2br($detailProduct->description )!!}</p>
                    </div>
                    <div id="review" class="tab-pane fade">
                        <div class="review-wrp">
                            @if ($detailProduct->reviews->count() > 0)
                                @foreach ($detailProduct->reviews->take(3) as $review)
                                    <div class="abmin d-flex flex-wrap flex-md-nowrap align-items-center pb-4">
                                        <div class="content p-4 bor">
                                            <div class="head-wrp pb-1 d-flex flex-wrap justify-content-between">
                                                <a href="#0">
                                                    <h4 class="text-capitalize primary-color">
                                                        {{ $review->user->name }}<span
                                                            class="sm-font ms-2 fw-normal">{{ $review->created_at }}</span>
                                                    </h4>
                                                </a>
                                                <div class="star primary-color ms-md-3">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        @if ($i < $review->rating)
                                                            <i class="fas fa-star"></i> <!-- Sao đầy -->
                                                        @else
                                                            <i class="far fa-star"></i> <!-- Sao rỗng -->
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="text-justify">{{ $review->comment }} </p>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            @else
                                <p>Chưa có đánh giá cho sản phẩm này !</p>
                                <hr>
                            @endif
                            <div class="section-title mt-5 py-15 mb-30">
                                <h2 class="text-capitalize primary-color mb-10">Thêm đánh giá của bạn</h2>
                                <p class="mb-20">Email của bạn sẽ không bị công khai. Vui lòng không được bỏ
                                    trống.
                                </p>
                                <div class="shop-single__rate-now">
                                    <p>Chất lượng sản phẩm?</p>
                                    <div class="star">
                                        <span><i class="fa-solid fa-star"></i></span>
                                        <span><i class="fa-solid fa-star"></i></span>
                                        <span><i class="fa-solid fa-star"></i></span>
                                        <span><i class="fa-solid fa-star"></i></span>
                                        <span><i class="fa-solid fa-star"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="comment-form">
                                <form action="#">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <input type="text" class="w-100 mb-4 bor px-4 py-2"
                                                placeholder="Tên của bạn">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" class="w-100 mb-4 bor px-4 py-2"
                                                placeholder="Email của bạn">
                                        </div>
                                    </div>
                                    <textarea class="w-100 mb-4 bor p-4" placeholder="Đánh giá"></textarea>
                                </form>
                                <div class="btn-wrp">
                                    <button class="btn-one"><span>Gửi</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- description review area end here -->
    </section>
    <!-- Shop single area end here -->
@endsection