@extends('layout.admin.master')

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
                    style="width: 100%; height: auto; object-fit: cover;border: 2px solid black;">
            </div>
            <div class="col-md-6">
                <h4>Giá: {{ number_format($product->base_price, 0, ',', '.') }} VND</h4>
                <p><strong>Mô tả:</strong> {{ $product->description }}</p>
                <p><strong>Số lượng:</strong> {{ $product->quantity }}</p>
                <p><strong>Thể loại:</strong> {{ $product->category->name_category ?? 'No category' }}</p>
            </div>
        </div>
        <hr>
        <div class="reviews-section">
            <h3>Đánh giá sản phẩm</h3>
            
            @if($product->reviews->count() > 0)
                @foreach ($product->reviews as $review)
                    <div class="review">
                        <p><strong>Người dùng:</strong> {{ $review->user->name }}</p>
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
            @else
                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
            @endif
        </div>
        <hr>
        <a href="{{ route('admin.products.listProduct') }}" class="btn btn-success">Quay lại</a>
    </div>
    
@endsection
