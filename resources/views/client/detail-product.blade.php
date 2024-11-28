@extends('layout.client.master')
@push('styles')
    @push('styles')
        <style>
            .size-option.disabled,
            .color-option.disabled {
                opacity: 0.5;
                pointer-events: none;
            }
        </style>
    @endpush
@endpush
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
                            @if ($detailProduct->images->count() > 0)
                                <div class="swiper shop-single-slide">
                                    <div class="swiper-wrapper">
                                        @foreach ($detailProduct->images as $image)
                                            <div class="swiper-slide slide-smoll">
                                                <img src="{{ $image->image_path }}" style="height:650px;" alt="image">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @if ($detailProduct->images->count() > 1)
                                    <div class="mt-3 swiper shop-slider-thumb">
                                        <div class="swiper-wrapper">
                                            @foreach ($detailProduct->images as $image)
                                                <div class="swiper-slide slide-smoll">
                                                    <img src="{{ $image->image_path }}"
                                                        style="height: 100px; object-fit: cover;" alt="image">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="content h24">
                            <h3 class="pb-2 primary-color"
                                style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 500px;">
                                {{ $detailProduct->name }}</h3>
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
                            <div class="description">
                                <h4 class="pb-2 primary-color">Mô tả sản phẩm</h4>
                                <p class="text-justify mb-10">
                                    {!! $detailProduct->description !!}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="details-area">
                                    <div class="category flex-wrap mt-4 d-flex py-3 bor-top bor-bottom">
                                        <h4 class="pe-3">Danh mục :</h4>
                                        <a href="#0"
                                            class="primary-hover">{{ $detailProduct->category->name_category }}</a>
                                    </div>

                                    <form id='myform' method='POST' action="{{ route('client.cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $detailProduct->id }}">
                                        <input type="hidden" name="variant_id" id="variant_id" value="">
                                        <input type="hidden" name="size_id" id="size_id" value="">

                                        <div class="d-flex flex-wrap py-3 bor-bottom">
                                            <h4 class="pe-3">Màu sắc:</h4>
                                            <div class="variant-colors d-flex gap-2">
                                                @foreach ($detailProduct->variantProducts->pluck('color')->unique('id') as $color)
                                                    @php
                                                        $variant = $detailProduct->variantProducts
                                                            ->where('color_id', $color->id)
                                                            ->first();
                                                    @endphp
                                                    @if ($variant)
                                                        <div class="color-option" data-color-id="{{ $color->id }}"
                                                            style="padding: 5px 10px; border: 1px solid #ccc; cursor: pointer; display: flex; align-items: center; position: relative;"
                                                            onclick="selectVariant('{{ $color->id }}', {{ $variant->id }}, '{{ $variant->name }}')"
                                                            tabindex="0">
                                                            @if ($variant->images->count() > 0)
                                                                <img src="{{ $variant->images->first()->image_path }}"
                                                                    alt="variant-{{ $variant->name }}"
                                                                    style="width: 50px; height: 50px; object-fit: cover; margin-right: 5px;">
                                                            @endif
                                                            <span>{{ $variant->name }}</span>
                                                            <span class="selected-mark"
                                                                style="display: none; position: absolute; top: 5px; right: 5px; background-color: green; color: white; padding: 2px 5px; border-radius: 50%;">✓</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap py-3 bor-bottom">
                                            <small>
                                                <p>Số lượng : <span
                                                        id="quantity-label">{{ $detailProduct->getTotalQuantity() }}</span>
                                                </p>
                                            </small>
                                        </div>
                                        <div class="d-flex flex-wrap py-3 bor-bottom">
                                            <h4 class="pe-3">Kích thước:</h4>
                                            <div class="variant-sizes d-flex gap-2">
                                                @foreach ($sizes as $size)
                                                    @php
                                                        $variant = $detailProduct->variantProducts
                                                            ->where('size_id', $size->id)
                                                            ->first();
                                                    @endphp
                                                    <div class="size-option {{ $variant ? '' : 'disabled' }}"
                                                        data-size-id="{{ $size->id }}"
                                                        style="padding: 5px 10px; border: 1px solid #ccc; cursor: {{ $variant ? 'pointer' : 'not-allowed' }}; position: relative;"
                                                        onclick="selectSize('{{ $size->id }}', '{{ $size->name }}')"
                                                        tabindex="0">
                                                        {{ $size->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="cart-wrp py-4">
                                            <div class="cart-quantity">
                                                <input type='button' value='-' class='qtyminus minus'>
                                                <input type='text' name='quantity' value='1' class='qty'>
                                                <input type='button' value='+' class='qtyplus plus'>
                                            </div>
                                            <h2 class="product-price" id="product-price" style="display: none;">
                                                {{ number_format($detailProduct->sale_price ?? $detailProduct->base_price) }}.đ
                                            </h2>
                                        </div>
                                        <button type="submit" class="d-block text-center btn-two mt-40">
                                            <span><i class="fa-solid fa-basket-shopping pe-2" id="add-to-cart-btn"></i>
                                                Thêm vào giỏ hàng</span>
                                        </button>
                                    </form>
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
                        <p class="pb-4 text-justify">{!! nl2br($detailProduct->description) !!}</p>
                    </div>
                    <div id="review" class="tab-pane fade">
                        <div class="review-wrp">
                            @if ($detailProduct->reviews->count() > 0)
                                @php
                                    $reviews = $detailProduct->reviews()->where('is_visible', true)->paginate(4);
                                @endphp
                                @foreach ($reviews as $review)
                                    <div class="abmin d-flex flex-wrap flex-md-nowrap align-items-center pb-4">
                                        <div class="content p-4 bor">
                                            <div class="head-wrp pb-1 d-flex flex-wrap justify-content-between">
                                                <a href="#0">
                                                    <h4 class="text-capitalize primary-color">
                                                        {{ $review->user->name }}<span
                                                            class="sm-font ms-2 fw-normal">{{ $review->created_at->format('d/m/Y') }}</span>
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
                                {{ $reviews->links('pagination::custom') }}
                            @else
                                <p>Chưa có đánh giá cho sản phẩm này !</p>
                                <hr>
                            @endif
                            @if (Auth::check())
                                <div class="section-title mt-5 py-15 mb-30">
                                    <h2 class="text-capitalize primary-color mb-10">Thêm đánh giá của bạn</h2>
                                    <p class="mb-20">Email của bạn sẽ không bị công khai. Vui lòng không được bỏ
                                        trống.
                                    </p>
                                    <form action="{{ route('admin.reviews.comment') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $detailProduct->id }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                        <div class="shop-single__rate-now">
                                            <p>Chất lượng sản phẩm?</p>
                                            <div class="star">
                                                <span data-value="1"><i class="fa-regular fa-star"></i></span>
                                                <span data-value="2"><i class="fa-regular fa-star"></i></span>
                                                <span data-value="3"><i class="fa-regular fa-star"></i></span>
                                                <span data-value="4"><i class="fa-regular fa-star"></i></span>
                                                <span data-value="5"><i class="fa-regular fa-star"></i></span>
                                            </div>
                                            <input type="hidden" id="rating-value" name="rating" value="0">
                                            @error('rating')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="comment-form">
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <input type="text" value="{{ Auth::user()->name }}"
                                                        class="w-100 mb-4 bor px-4 py-2" placeholder="Tên của bạn">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" value="{{ Auth::user()->email }}"
                                                        class="w-100 mb-4 bor px-4 py-2" placeholder="Email của bạn">
                                                </div>
                                            </div>
                                            <textarea class="w-100 mb-4 bor p-4" name="comment" id="comment" placeholder="Đánh giá"></textarea>
                                            @error('comment')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            <div class="btn-wrp">
                                                <button class="btn-one" type="submit"><span>Gửi</span></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <span>Bạn cần <a href="{{route('login')}}"><p id="login-review">đăng nhập</p></a> để bình luận !</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        const totalQuantity = {{ $detailProduct->getTotalQuantity() }}; // Tổng số lượng
        const variantData = @json(collect($detailProduct->variantProducts)->groupBy('color_id')->map(function ($variants) {
                    return $variants->groupBy('size_id')->map(function ($groupedVariants) {
                        return $groupedVariants->first();
                    });
                }));

        // Hàm cập nhật hiển thị số lượng
        function updateQuantityDisplay(colorId = null, sizeId = null) {
            const quantityLabel = document.getElementById('quantity-label');
            let quantity = totalQuantity; // Mặc định là tổng số lượng

            // Nếu có màu và kích thước đã chọn, lấy số lượng từ biến thể
            if (colorId && sizeId && variantData[colorId] && variantData[colorId][sizeId]) {
                quantity = variantData[colorId][sizeId].quantity;
            }

            quantityLabel.textContent = quantity;
        }

        // Hàm cập nhật các lựa chọn kích thước khi chọn màu
        function updateOptions(selectedColorId) {
            document.querySelectorAll('.size-option').forEach(el => {
                const sizeId = el.getAttribute('data-size-id');
                el.classList.add('disabled'); // Vô hiệu hóa tất cả kích thước

                if (selectedColorId && variantData[selectedColorId] && variantData[selectedColorId][sizeId] &&
                    variantData[selectedColorId][sizeId].quantity > 0) {
                    el.classList.remove('disabled');
                }
            });

            // Kiểm tra kích thước đã chọn
            const selectedSizeId = document.getElementById('size_id').value;
            if (selectedSizeId && (!variantData[selectedColorId] || !variantData[selectedColorId][selectedSizeId] ||
                    variantData[selectedColorId][selectedSizeId].quantity <= 0)) {
                // Nếu kích thước không hợp lệ, xóa lựa chọn
                document.getElementById('size_id').value = '';
                document.querySelectorAll('.size-option').forEach(option => {
                    option.style.border = '1px solid #ccc'; // Reset border
                });
            }
        }

        // Hàm chọn màu sắc
        function selectVariant(colorId, variantId) {
            document.getElementById('variant_id').value = variantId;

            // Highlight màu đã chọn
            document.querySelectorAll('.color-option').forEach(option => {
                option.style.border = '1px solid #ccc';
            });
            document.querySelector(`.color-option[data-color-id="${colorId}"]`).style.border = '2px solid red';

            // Cập nhật kích thước khả dụng và số lượng
            updateOptions(colorId);

            // Cập nhật số lượng
            updateQuantityDisplay(colorId, document.getElementById('size_id').value);
        }

        // Hàm chọn kích thước
        function selectSize(sizeId, sizeName) {
            const selectedColorId = document.querySelector('.color-option[style*="border: 2px solid red;"]')?.dataset
                .colorId;
            const variant = variantData[selectedColorId]?.[sizeId];
            const variantId = variant ? variant.id : null;

            document.getElementById('variant_id').value = variantId;
            document.getElementById('size_id').value = sizeId;

            // Highlight kích thước đã chọn
            document.querySelectorAll('.size-option').forEach(option => {
                option.style.border = '1px solid #ccc';
            });
            document.querySelector(`.size-option[data-size-id="${sizeId}"]`).style.border = '2px solid red';

            // Cập nhật số lượng
            updateQuantityDisplay(selectedColorId, sizeId);
        }

        document.addEventListener("DOMContentLoaded", () => {
            const qtyInput = document.querySelector(".qty");

            document.querySelectorAll(".qtyminus, .qtyplus").forEach(button => {
                button.addEventListener("click", () => {
                    let quantity = parseInt(qtyInput.value) || 1; // Đảm bảo giá trị hợp lệ
                    const maxQuantity = parseInt(document.getElementById('quantity-label')
                        .textContent) || 0;

                    if (button.classList.contains("qtyminus") && quantity > 1) {
                        quantity -= 1;
                    } else if (button.classList.contains("qtyplus")) {
                        if (quantity < maxQuantity) {
                            quantity += 1;
                        }
                    }

                    qtyInput.value = quantity; // Cập nhật giá trị hiển thị
                });
            });

            // Đồng bộ số lượng khi biến thể thay đổi
            document.addEventListener("change", () => {
                const maxQuantity = parseInt(document.getElementById('quantity-label').textContent) || 0;
                let quantity = parseInt(qtyInput.value) || 1;

                if (quantity > maxQuantity) {
                    qtyInput.value = maxQuantity; // Nếu vượt quá số lượng tối đa, tự động giảm xuống
                }
            });
        });

        // Đồng bộ hiển thị khi trang tải
        document.addEventListener('DOMContentLoaded', function() {
            updateQuantityDisplay(); // Hiển thị số lượng tổng khi tải trang
            updateOptions(null); // Khởi tạo danh sách kích thước
        });
    </script>

    <script>
        const stars = document.querySelectorAll('.star span');
        const ratingInput = document.getElementById('rating-value');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const selectedRating = this.getAttribute('data-value');
                ratingInput.value = selectedRating; // Gán giá trị cho input ẩn

                // Đổi lớp cho các ngôi sao theo rating đã chọn
                stars.forEach((s, index) => {
                    const icon = s.querySelector('i');
                    if (index < selectedRating) {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                    }
                });
            });
        });
    </script>
@endpush
