@extends('layout.admin.master')

@section('content')
    <section class="content-header">
        <h1>
            Chi tiết sản phẩm biến thể
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
                <p><strong>Mã sản phẩm biến thể:</strong> {{ $variantProduct->id }}</p>
                <p><strong>Số lượng:</strong> {{ $variantProduct->quantity }}</p>
                <p><strong>Nhãn hàng:</strong> {{ $variantProduct->product->category->name_category ?? 'Không có nhãn hàng' }} </p>
                <p><strong>Kích thước:</strong> {{ $variantProduct->size->name ?? 'Không có size' }} </p>
                <p><strong>Màu sắc:</strong> {{ $variantProduct->color->name ?? 'Không có màu' }} </p>
                <p><strong>Ngày tạo:</strong> {{ $variantProduct->created_at->format('d/m/Y') }}</p>
                <p><strong>Ngày cập nhật:</strong> {{ $variantProduct->updated_at->format('d/m/Y') }}</p>
                <p><strong>Trạng thái:</strong> 
                    @if ($variantProduct->status == 'active')
                        <span>Còn hàng</span>
                    @else
                        <span>Không còn hàng</span>
                    @endif
                </p>
            </div>
        </div>
        <hr>
        
        <a href="{{ route('admin.variant-products.index') }}" class="btn btn-success">Quay lại</a>
    </div>
    
@endsection
