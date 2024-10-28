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
        <h2>{{ $variantProduct->name }}</h2>

        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset($variantProduct->image_url) }}" alt="{{ $variantProduct->name }}"
                    style="width: 100%; height: 100%; max-width: 500px; max-height: 500px; object-fit: cover; aspect-ratio: 1/1; border: 2px solid black;">
            </div>            
            <div class="col-md-6">
                <h4>Giá: {{ number_format($variantProduct->price, 0, ',', '.') }} VND</h4>
                <p><strong>Mô tả:</strong> {{ $variantProduct->description }}</p>
                <p><strong>Số lượng:</strong> {{ $variantProduct->quantity }}</p>
                <p><strong>Nhãn hàng:</strong> {{ $variantProduct->product->category->name_category ?? 'Không có nhãn hàng' }} </p>
                <p><strong>Kích thước:</strong> {{ $variantProduct->sizes->name ?? 'Không có size' }} </p>
                <p><strong>Màu sắc:</strong> {{ $variantProduct->colors->name ?? 'Không có màu' }} </p>
                <p><strong>Ngày tạo:</strong> {{ $variantProduct->description }}</p>
                <p><strong>Ngày cập nhật:</strong> {{ $variantProduct->description }}</p>
            </div>
        </div>
        <hr>
        
        <a href="{{ route('admin.variant-products.index') }}" class="btn btn-success">Quay lại</a>
    </div>
    
@endsection
