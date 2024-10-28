@extends('layout.admin.master')

@push('styles')
<style>
    .review-container {
        display: flex;
        flex-wrap: wrap; /* Cho phép các review xuống dòng nếu không đủ chỗ */
        gap: 20px; /* Khoảng cách giữa các review */
    }

    .review {
        border: 1px solid #ccc; /* Đường viền cho review */
        padding: 10px; /* Padding cho review */
        border-radius: 5px; /* Bo tròn góc */
        width: calc(33.33% - 20px); /* Đặt chiều rộng cho mỗi review (3 review trên 1 hàng) */
        box-sizing: border-box; /* Bao gồm padding và border vào tổng chiều rộng */
    }

    /* Đảm bảo hiển thị tốt trên màn hình nhỏ hơn */
    @media (max-width: 768px) {
        .review {
            width: calc(50% - 20px); /* 2 review trên 1 hàng */
        }
    }

    @media (max-width: 480px) {
        .review {
            width: 100%; /* 1 review trên 1 hàng */
        }
    }

</style>
@endpush

@section('content')
    <section class="content-header">
        <h1>
            Chi tiết sản phẩm
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">Chi tiết sản phẩm</li>
        </ol>
    </section>

    <hr>

    <div class="container">
        <h2>{{ $product->name }}</h2>

        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                    style="width: 100%; height: 100%; max-width: 500px; max-height: 500px; object-fit: cover; aspect-ratio: 1/1; border: 2px solid black;">
            </div>            
            <div class="col-md-6">
                <h4>Giá: {{ number_format($product->base_price, 0, ',', '.') }} VND</h4>
                <p>
                    <strong>Mô tả:</strong> 
                    <span id="product-description">
                        {{ Str::limit($product->description, 50) }} <!-- Hiển thị tối đa 50 ký tự -->
                    </span>
                    @if (strlen($product->description) > 50) <!-- Kiểm tra nếu mô tả dài hơn 50 ký tự -->
                        <span id="full-description" style="display: none;">{{ $product->description }}</span> <!-- Mô tả đầy đủ ẩn đi -->
                        <a href="#" id="show-more-description" style="color: blue; text-decoration: underline;">Xem thêm</a> <!-- Nút Xem thêm -->
                    @endif
                </p>                
                <p><strong>Số lượng:</strong> {{ $product->quantity }}</p>
                <p><strong>Nhãn hàng:</strong> {{ $product->category->name_category ?? 'No category' }}</p>
                <p><strong>Kích thước:</strong> 
                    {{ $product->variantProducts->pluck('size.name')->unique()->implode(', ') ?? 'Không có' }}
                </p>
                <p><strong>Màu sắc:</strong> 
                    {{ $product->variantProducts->pluck('color.name')->unique()->implode(', ') ?? 'Không có' }}
                </p>
                <p><strong>Ngày tạo:</strong> {{ $product->created_at->format('d/m/Y') }}</p>
                <p><strong>Ngày cập nhật:</strong> {{ $product->updated_at->format('d/m/Y') }}</p>
                <p><strong>Lượt xem:</strong> {{ $product->views }}</p>
                <h2>Thông tin đánh giá</h2>
                <p><strong>Số lượng đánh giá:</strong> {{ $totalReviews }}</p>
                <p><strong>Điểm trung bình:</strong> {{ number_format($averageRating, 1) }}</p>

            </div>
        </div>
        <hr>
        <div class="reviews-section">
            <h3>Đánh giá sản phẩm</h3>
            
            @if($product->reviews->count() > 0)
                <div class="review-container"> <!-- Thêm div để chứa các bình luận -->
                    @foreach ($product->reviews->take(3) as $review) <!-- Chỉ lấy 3 đánh giá đầu tiên -->
                        <div class="review">
                            <p><strong>Người dùng:</strong> {{ $review->user->name ?? 'Ẩn danh' }}</p>
                            <p><strong>Điểm đánh giá:</strong> {{ $review->rating }}/5</p>
                            <p><strong>Bình luận:</strong> {{ $review->comment }}</p>
                            <p>
                                <strong>Trạng thái:</strong> 
                                {{ $review->is_visible ? 'Đang hiển thị' : 'Không hiển thị' }}
                            </p>
                            
                            <form action="{{ route('admin.reviews.toggleVisibility', $review->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-warning">
                                    {{ $review->is_visible ? 'Ẩn' : 'Hiện' }} đánh giá
                                </button>
                            </form>                        
                        </div>
                    @endforeach
                </div>
        
                @if ($product->reviews->count() > 3) <!-- Kiểm tra nếu có nhiều hơn 3 đánh giá -->
                <br>
                    <p><a href="#" class="btn btn-info" id="show-more-reviews">Xem thêm đánh giá</a></p>
                    <div id="more-reviews" style="display: none;"> <!-- Ẩn các đánh giá còn lại -->
                        <div class="review-container"> <!-- Thêm div để chứa các bình luận -->
                            @foreach ($product->reviews->slice(3) as $review) <!-- Hiển thị các đánh giá còn lại -->
                                <div class="review">
                                    <p><strong>Người dùng:</strong> {{ $review->user->name ?? 'Ẩn danh' }}</p>
                                    <p><strong>Điểm đánh giá:</strong> {{ $review->rating }}/5</p>
                                    <p><strong>Bình luận:</strong> {{ $review->comment }}</p>
                                    <p>
                                        <strong>Trạng thái:</strong> 
                                        {{ $review->is_visible ? 'Đang hiển thị' : 'Không hiển thị' }}
                                    </p>
                                    
                                    <form action="{{ route('admin.reviews.toggleVisibility', $review->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-warning">
                                            {{ $review->is_visible ? 'Ẩn' : 'Hiện' }} đánh giá
                                        </button>
                                    </form>                        
        
                                    <hr>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
            @endif
        </div>
        
        
        
        <hr>
        <a href="{{ route('admin.products.listProduct') }}" class="btn btn-success">Quay lại</a>
    </div>
    <script>
        document.getElementById('show-more-reviews').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('more-reviews').style.display = 'block'; // Hiện các đánh giá còn lại
            this.style.display = 'none'; // Ẩn nút "Xem thêm đánh giá"
        });
        document.getElementById('show-more-description')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('product-description').innerText = document.getElementById('full-description').innerText; // Hiển thị mô tả đầy đủ
            this.style.display = 'none'; // Ẩn nút "Xem thêm"
        });
    </script>
    
@endsection
