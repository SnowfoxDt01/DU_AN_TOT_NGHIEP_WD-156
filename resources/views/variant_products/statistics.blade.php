@extends('layout.admin.master')

@section('content')
<div class="container">
    <h1>Thống kê sản phẩm</h1>
    <div>
        <p>Tổng số sản phẩm: {{ $totalVariantProducts }}</p>
        <p>Tổng số danh mục: {{ $totalProducts }}</p>
        <p>Tổng số kích cỡ: {{ $totalSizes }}</p>
        <p>Tổng số màu sắc: {{ $totalColors }}</p>
    </div>

    <h2>Số lượng sản phẩm theo danh mục</h2>
    <ul>
        @foreach($productsByProduct as $product)
            <li>{{ $product->product->name }}: {{ $product->count }}</li>
        @endforeach
    </ul>

    <h2>Số lượng sản phẩm theo màu</h2>
    <ul>
        @foreach($productsByColor as $product)
            <li>{{ $product->color->name }}: {{ $product->count }}</li>
        @endforeach
    </ul>

    <h2>Số lượng sản phẩm theo kích cỡ</h2>
    <ul>
        @foreach($productsBySize as $product)
            <li>{{ $product->size->name }}: {{ $product->count }}</li>
        @endforeach
    </ul>
    <a href="{{ route('admin.variant-products.index') }}" class="btn btn-primary mt-3">Quay lại</a>
</div>
@endsection
