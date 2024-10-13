@extends('layout.admin.master')

@section('content')
<section class="content-header">
    <h1>
        Product Details
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active">Product Details</li>
    </ol>
</section>

<hr>

<div class="container">
    <h2>{{ $product->name }}</h2>
    
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: auto; object-fit: cover;">
        </div>
        <div class="col-md-6">
            <h4>Price: {{ number_format($product->price, 0, ',', '.') }} VND</h4>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
            <p><strong>Category:</strong> {{ $product->category->name_category ?? 'No category' }}</p>
        </div>
    </div>

    <a href="{{ route('admin.products.listProduct') }}" class="btn btn-success">Back</a>
</div>
@endsection
