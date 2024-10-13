@extends('layout.admin.master')
@section('content')
<div class="container">
    <section class="content-header">
        <h1>
            Tạo mới sản phẩm
        </h1>
        <ol class="breadcrumb">
            {{-- <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> | --}}
            <li class="active">Tạo mới sản phẩm</li>
        </ol>
    </section>
    <hr>
    <form action="{{ route('admin.products.addPostProduct') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nameSP">Tên sản phẩm</label>
            <input type="text" name="nameSP" class="form-control">
        </div>
        <div class="form-group">
            <label for="descriptionSP">Mô tả sản phẩm</label>
            <input type="text" name="descriptionSP" class="form-control">
        </div>
        <div class="form-group">
            <label for="priceSP">Giá</label>
            <input type="text" name="priceSP" class="form-control">
        </div>
        <div class="form-group">
            <label for="imageSP">Ảnh</label>
            <input type="file" name="imageSP" class="form-control">
        </div>
        <div class="form-group">
            <label for="quantitySP">Số lượng</label>
            <input type="text" name="quantitySP" class="form-control">
        </div>
        <div class="form-group">
            <label for="product_category_id">Thể loại</label>
            <select name="product_category_idSP" class="form-control">
                <option value="">Chọn thể loại</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name_category }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Thêm</button>
        </div>
    </form>
</div>
    
@endsection
