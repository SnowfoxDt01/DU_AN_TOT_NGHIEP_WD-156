@extends('layout.admin.master')

@push('styles')
    <style>
        .img-preview{
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
<section class="content-header">
    <h1>
        Sửa sản phẩm
        <small>Trang chủ |</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active">Sửa sản phẩm</li>
    </ol>
</section>

<hr>
<form action="{{ route('admin.products.updateProduct', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nameSP">Tên sản phẩm</label>
        <input type="text" class="form-control" id="nameSP" name="nameSP" value="{{ $product->name }}">
    </div>

    <div class="form-group">
        <label for="descriptionSP">Mô tả</label>
        <textarea class="form-control" id="descriptionSP" name="descriptionSP">{{ $product->description }}</textarea>
    </div>

    <div class="form-group">
        <label for="priceSP">Giá</label>
        <input type="number" class="form-control" id="priceSP" name="priceSP" value="{{ $product->base_price }}">
    </div>

    <div class="form-group">
        <label for="quantitySP">Số lượng</label>
        <input type="number" class="form-control" id="quantitySP" name="quantitySP" value="{{ $product->quantity }}">
    </div>

    <div class="form-group">
        <label for="product_category_idSP">Danh mục</label>
        <input type="number" class="form-control" id="product_category_idSP" name="product_category_idSP" value="{{ $product->product_category_id }}">
    </div>

    <div class="form-group">
        <label for="imageSP">Hình ảnh</label>
        <input type="file" class="form-control" id="imageSP" name="imageSP">
        <img src="{{ asset($product->image) }}" alt="Product Image" class="img-preview mt-3">
    </div>

    <button type="submit" class="btn btn-success">Cập nhật</button>
    <a href="{{ route('admin.products.listProduct') }}" class="btn btn-primary">Trở về</a>
</form>
@endsection
