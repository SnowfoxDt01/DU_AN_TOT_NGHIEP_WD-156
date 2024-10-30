@extends('layout.admin.master')

@push('styles')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    h2, h3 {
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

    .product-info, .review-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top: 20px;
    }

    .product-info img {
        max-width: 50%; 
        height: 500px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .product-info p, .product-info h4 {
        margin-bottom: 8px;
        color: #555;
        font-family: Arial, sans-serif;
    }

    .product-info h4 {
        font-weight: bold;
    }

    .btn {
        padding: 10px 20px;
        background-color: #0073aa;
        border: none;
        border-radius: 5px;
        color: white;
        text-decoration: none;
    }

    .btn:hover {
        background-color: #005d8a;
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

</style>
@endpush

@section('content')
    <section class="content-header">
        <h1>Chi tiết sản phẩm</h1>
        <ol class="breadcrumb">
            <li class="active">Chi tiết sản phẩm</li>
        </ol>
    </section>

    <div class="container">
        <h2>{{ $product->name }}</h2>
        <div class="product-info">
            <div>
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
            </div>
            <div>
                <h4>Giá: {{ number_format($product->base_price, 0, ',', '.') }} VND</h4>
                <p><strong>Mô tả:</strong> <span id="product-description">{{ Str::limit($product->description, 100) }}</span>
                    @if (strlen($product->description) > 100)
                        <span id="full-description" style="display: none;">{{ $product->description }}</span>
                        <span class="show-more-link" id="show-more-description">Xem thêm</span>
                    @endif
                </p>
                <p><strong>Số lượng:</strong> {{ $product->quantity }}</p>
                <p><strong>Nhãn hàng:</strong> {{ $product->category->name_category ?? 'No category' }}</p>
                <p><strong>Kích thước:</strong> {{ $product->variantProducts->pluck('size.name')->unique()->implode(', ') ?? 'Không có' }}</p>
                <p><strong>Màu sắc:</strong> {{ $product->variantProducts->pluck('color.name')->unique()->implode(', ') ?? 'Không có' }}</p>
                <p><strong>Ngày tạo:</strong> {{ $product->created_at->format('d/m/Y') }}</p>
                <p><strong>Ngày cập nhật:</strong> {{ $product->updated_at->format('d/m/Y') }}</p>
                <p><strong>Lượt xem:</strong> {{ $product->views }}</p>
            </div>
        </div>

        <div class="reviews-section">
            <h3>Đánh giá sản phẩm</h3>
            
            <!-- Hiển thị số lượng đánh giá và điểm trung bình -->
            <p><strong>Số lượng đánh giá:</strong> {{ $product->reviews->count() }}</p>
            <p><strong>Điểm đánh giá trung bình:</strong> 
                {{ $product->reviews->count() > 0 ? number_format($product->reviews->avg('rating'), 1) : 'Chưa có đánh giá' }}/5
            </p>
        
            @if($product->reviews->count() > 0)
                <div class="review-container">
                    @foreach ($product->reviews->take(3) as $review)
                        <div class="review">
                            <p><strong>Người dùng:</strong> {{ $review->user->name ?? 'Ẩn danh' }}</p>
                            <p><strong>Điểm đánh giá:</strong> {{ $review->rating }}/5</p>
                            <p><strong>Bình luận:</strong> {{ $review->comment }}</p>
                            <p><strong>Trạng thái:</strong> {{ $review->is_visible ? 'Đang hiển thị' : 'Không hiển thị' }}</p>
                            <form action="{{ route('admin.reviews.toggleVisibility', $review->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning">{{ $review->is_visible ? 'Ẩn' : 'Hiện' }} đánh giá</button>
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
                                    <form action="{{ route('admin.reviews.toggleVisibility', $review->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">{{ $review->is_visible ? 'Ẩn' : 'Hiện' }} đánh giá</button>
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
        <a href="{{ route('admin.products.listProduct') }}" class="btn">Quay lại</a>
    </div>

    <script>
        document.getElementById('show-more-description')?.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('product-description').innerText = document.getElementById('full-description').innerText;
            this.style.display = 'none';
        });

        document.getElementById('show-more-reviews')?.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('more-reviews').style.display = 'block';
            this.style.display = 'none';
        });
    </script>
@endsection
