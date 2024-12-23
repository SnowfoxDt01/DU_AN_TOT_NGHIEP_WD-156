@extends('layout.ad.master')

@push('styles')
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2,
        h3 {
            color: #333;
            font-family: Arial, sans-serif;
            margin-bottom: 15px;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            font-size: 0.9em;
        }

        .breadcrumb .active {
            color: #0073aa;
        }

        .content-header h1 {
            font-size: 24px;
            color: #333;
        }

        .product-info,
        .review-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }

        .product-info img {
            max-width: 50%;
            height: 500px;
            border: 1px solid #ffffff;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-info p,
        .product-info h4 {
            margin-bottom: 8px;
            color: #555;
            font-family: Arial, sans-serif;
        }

        .product-info h4 {
            font-weight: bold;
        }

        .reviews-section {
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 20px;
        }

        .review-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .review {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .review p {
            margin: 0 0 10px;
            color: #555;
        }

        .btn-warning {
            background-color: #ffb900;
            border: none;
            color: white;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .show-more-link {
            color: #0073aa;
            cursor: pointer;
            font-weight: bold;
            text-decoration: underline;
        }

        .product-images-grid {
            display: flex;
            overflow-x: scroll;
            /* Enable horizontal scroll */
            white-space: nowrap;
            /* Prevent images from wrapping */
            gap: 10px;
        }

        .product-images-grid img {
            max-width: 100px;
            /* Set desired width for thumbnails */
            height: auto;
            /* Maintain aspect ratio */
            border: 1px solid #ddd;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Chi tiết sản phẩm</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Chi tiết sản phẩm
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body p-3">
            <div class="container">
                <h2>{{ $product->name }}</h2>
                <div class="row">
                    <div class="col-md-4">
                        @if ($product->images->count() > 0)
                            <div class="product-image-main">
                                <img src="{{ asset($product->images->first()->image_path) }}" alt="{{ $product->name }}"
                                    class="img-fluid border">
                            </div>
                            <br>
                            <div class="product-images-grid">
                                @foreach ($product->images->skip(1) as $image)
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}"
                                        class="img-fluid border">
                                @endforeach
                            </div>
                        @else
                            <img src="{{ asset('default_image.jpg') }}" alt="No Image" class="img-fluid border">
                        @endif
                    </div>
                    <div class="col-md-6" style="margin-left: 50px">
                        <div>
                            <h4>Giá: {{ number_format($product->base_price, 0, ',', '.') }} VND</h4>
                            <p><strong>Số lượng:</strong> {{ $product->getTotalQuantity() }}</p>
                            <p><strong>Nhãn hàng:</strong> {{ $product->category->name_category ?? 'No category' }}</p>
                            <p><strong>Kích thước:</strong>
                                {{ $product->variantProducts->pluck('size.name')->unique()->implode(', ') ?? 'Không có' }}
                            </p>
                            <p><strong>Màu sắc:</strong>
                                {{ $product->variantProducts->pluck('color.name')->unique()->implode(', ') ?? 'Không có' }}
                            </p>
                            <p><strong>Trạng thái sản phẩm:</strong>
                                @if ($product->new === 0)
                                    Hàng trong kho
                                @elseif ($product->new === 1)
                                    Hàng mới
                                @else
                                    Không xác định
                                @endif
                            </p>
                            <p><strong>Ngày tạo:</strong> {{ $product->created_at->format('d/m/Y') }}</p>
                            <p><strong>Ngày cập nhật:</strong> {{ $product->updated_at->format('d/m/Y') }}</p>
                            <p><strong>Lượt xem:</strong> {{ $product->views }}</p>
                        </div>
                    </div>
                </div>
                <div class="product-info">
                    <p><strong>Mô tả:</strong> <span id="product-description">{!! nl2br($product->description) !!}</span>
                    </p>
                </div>

                <div class="reviews-section">
                    <h3>Đánh giá sản phẩm</h3>

                    <!-- Hiển thị số lượng đánh giá và điểm trung bình -->
                    <p><strong>Số lượng đánh giá:</strong> {{ $product->reviews->count() }}</p>
                    <p><strong>Điểm đánh giá trung bình:</strong>
                        {{ $product->reviews->count() > 0 ? number_format($product->reviews->avg('rating'), 1) : 'Chưa có đánh giá' }}/5
                    </p>

                    @if ($product->reviews->count() > 0)
                        <div class="review-container">
                            @foreach ($product->reviews->take(3) as $review)
                                <div class="review">
                                    <p><strong>Người dùng:</strong> {{ $review->user->name ?? 'Ẩn danh' }}</p>
                                    <p><strong>Điểm đánh giá:</strong> {{ $review->rating }}/5</p>
                                    <p><strong>Bình luận:</strong> {{ $review->comment }}</p>
                                    <p><strong>Trạng thái:</strong>
                                        {{ $review->is_visible ? 'Đang hiển thị' : 'Không hiển thị' }}
                                    </p>
                                    <form action="{{ route('admin.reviews.toggleVisibility', $review->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-warning">{{ $review->is_visible ? 'Ẩn' : 'Hiện' }}
                                            đánh giá</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                        @if ($product->reviews->count() > 3)
                            <div id="more-reviews" style="display: none;">
                                <div class="review-container">
                                    @foreach ($product->reviews->slice(3) as $review)
                                        <div class="review">
                                            <p><strong>Người dùng:</strong> {{ $review->user->name ?? 'Ẩn danh' }}</p>
                                            <p><strong>Điểm đánh giá:</strong> {{ $review->rating }}/5</p>
                                            <p><strong>Bình luận:</strong> {{ $review->comment }}</p>
                                            <p><strong>Trạng thái:</strong>
                                                {{ $review->is_visible ? 'Đang hiển thị' : 'Không hiển thị' }}
                                            </p>
                                            <form action="{{ route('admin.reviews.toggleVisibility', $review->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-warning">{{ $review->is_visible ? 'Ẩn' : 'Hiện' }} đánh
                                                    giá</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <br>

                            <span class="btn btn-info" id="show-more-reviews">Xem thêm đánh giá</span>
                        @endif
                    @else
                        <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                    @endif
                </div>

                <hr>
                <br>
                <a href="{{ route('admin.products.listProduct') }}" class="btn btn-light">Quay lại</a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('show-more-description')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('product-description').innerText = document.getElementById('full-description')
                .innerText;
            this.style.display = 'none';
        });

        document.getElementById('show-more-reviews')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('more-reviews').style.display = 'block';
            this.style.display = 'none';
        });
    </script>
    <script src="path/to/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.product-images-grid').owlCarousel({
                items: 3, // Number of images to show initially
                nav: true, // Show navigation arrows
                dots: false, // Hide dots navigation
                margin: 10,
                autoplay: false, // Disable autoplay
                autoplayTimeout: 5000, // Set autoplay timeout if enabled
                autoplayHoverPause: true, // Pause autoplay on hover
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });
        });
    </script>
@endsection
