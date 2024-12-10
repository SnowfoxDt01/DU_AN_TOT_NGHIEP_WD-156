@extends('layout.ad.master')

@section('content')
<div class="container">
    <h1 class="my-4">Thống kê sản phẩm</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h5 class="card-title">Tổng số sản phẩm</h5>
                    <p class="card-text display-4">{{ $totalVariantProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h5 class="card-title">Tổng số danh mục</h5>
                    <p class="card-text display-4">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h5 class="card-title">Tổng số kích cỡ</h5>
                    <p class="card-text display-4">{{ $totalSizes }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h5 class="card-title">Tổng số màu sắc</h5>
                    <p class="card-text display-4">{{ $totalColors }}</p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-5">Số lượng sản phẩm theo danh mục</h2>
    <ul class="list-group mb-4">
        @foreach($categories as $category)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $category->name_category }}
                <span class="badge badge-primary badge-pill">{{$category->products->count()}}</span>
            </li>
        @endforeach
    </ul>

    <h2 class="mt-5">Số lượng sản phẩm theo màu</h2>
    <ul class="list-group mb-4">
        @foreach($productsByColor as $product)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $product->color->name }}
                <span class="badge badge-primary badge-pill">{{ $product->count }}</span>
            </li>
        @endforeach
    </ul>

    <h2 class="mt-5">Số lượng sản phẩm theo kích cỡ</h2>
    <ul class="list-group mb-4">
        @foreach($productsBySize as $product)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $product->size->name }}
                <span class="badge badge-primary badge-pill">{{ $product->count }}</span>
            </li>
        @endforeach
    </ul>

    <h2 class="mt-5">Số lượng sản phẩm theo trạng thái</h2>
    <ul class="list-group mb-4">
        @foreach($productsByStatus as $product)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @if($product->status == 'active')
                    Còn hàng
                @elseif($product->status == 'inactive')
                    Hết hàng
                @endif
                <span class="badge badge-primary badge-pill">{{ $product->count }}</span>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('admin.variant-products.index') }}" class="btn btn-primary mt-3">Quay lại</a>
</div>
@endsection
