@extends('layout.admin.master')

@section('content')
    <div class="container">
        <h1>Chi tiết sản phẩm: {{ $variantProduct->name }}</h1>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tên sản phẩm: {{ $variantProduct->name }}</h5>
                <p class="card-text">Mô tả: {{ $variantProduct->description }}</p>
                <p class="card-text">Giá: {{ $variantProduct->price }}</p>
                <p class="card-text">Số lượng: {{ $variantProduct->quantity }}</p>
                <p class="card-text">Danh mục: {{ $variantProduct->category->name_category }}</p>
                <p class="card-text">Kích cỡ: {{ $variantProduct->size->name }}</p>
                <p class="card-text">Màu sắc: {{ $variantProduct->color->name }}</p>
                <p class="card-text">Trạng thái: {{ $variantProduct->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}</p>
                @if($variantProduct->image_url)
                    <img src="{{ $variantProduct->image_url }}" alt="Hình ảnh sản phẩm" class="img-fluid">
                @endif
            </div>
        </div>

        <a href="{{ route('admin.variant-products.index') }}" class="btn btn-primary mt-3">Quay lại</a>
    </div>
@endsection
