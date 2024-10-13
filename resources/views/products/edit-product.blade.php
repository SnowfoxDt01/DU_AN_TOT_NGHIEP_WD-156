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
        Edit Product
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active">Edit Product</li>
    </ol>
</section>

<hr>
<form action="{{ route('admin.products.updateProduct', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nameSP">Product Name</label>
        <input type="text" class="form-control" id="nameSP" name="nameSP" value="{{ $product->name }}">
    </div>

    <div class="form-group">
        <label for="descriptionSP">Description</label>
        <textarea class="form-control" id="descriptionSP" name="descriptionSP">{{ $product->description }}</textarea>
    </div>

    <div class="form-group">
        <label for="priceSP">Price</label>
        <input type="number" class="form-control" id="priceSP" name="priceSP" value="{{ $product->price }}">
    </div>

    <div class="form-group">
        <label for="quantitySP">Quantity</label>
        <input type="number" class="form-control" id="quantitySP" name="quantitySP" value="{{ $product->quantity }}">
    </div>

    <div class="form-group">
        <label for="product_category_idSP">Category</label>
        <input type="number" class="form-control" id="product_category_idSP" name="product_category_idSP" value="{{ $product->product_category_id }}">
    </div>

    <div class="form-group">
        <label for="imageSP">Product Image</label>
        <input type="file" class="form-control" id="imageSP" name="imageSP">
        <img src="{{ asset($product->image) }}" alt="Product Image" class="img-preview mt-3">
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('admin.products.listProduct') }}" class="btn btn-primary">Back</a>
</form>
@endsection
