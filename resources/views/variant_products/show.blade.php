@extends('layout.admin.master')

@push('styles')
    <style>
        .img-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h1>Chi tiết sản phẩm biến thể</h1>

        <div class="form-group">
            <label for="name">Tên sản phẩm</label>
            <p>{{ $variantProduct->name }}</p>
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <p>{{ $variantProduct->description }}</p>
        </div>

        <div class="form-group">
            <label for="price">Giá</label>
            <p>{{ number_format($variantProduct->price, 0, ',', '.') }} VNĐ</p>
        </div>

        <div class="form-group">
            <label for="quantity">Số lượng</label>
            <p>{{ $variantProduct->quantity }}</p>
        </div>

        <div class="form-group">
            <label for="product_id">Sản phẩm chính</label>
            <p>{{ $variantProduct->product->name }}</p>
        </div>

        <div class="form-group">
            <label for="imageSP">Hình ảnh</label>
            <img src="{{ asset($variantProduct->image_url) }}" alt="Variant Product Image" class="img-preview mt-3">
        </div>

        <div class="form-group">
            <label for="size_id">Kích cỡ</label>
            <p>{{ $variantProduct->size->name }}</p>
        </div>

        <div class="form-group">
            <label for="color_id">Màu sắc</label>
            <p>{{ $variantProduct->color->name }}</p>
        </div>

        <div class="form-group">
            <label for="status">Trạng thái</label>
            <p>{{ $variantProduct->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}</p>
        </div>

        <a href="{{ route('admin.variant-products.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
@endsection
