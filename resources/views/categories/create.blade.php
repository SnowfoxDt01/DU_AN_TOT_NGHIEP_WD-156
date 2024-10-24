@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Tạo mới danh mục
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
            <li class="active">Tạo mới danh mục</li>
        </ol>
    </section>
    <hr>
    <form action="{{ route('admin.categories.store') }}" class="row g-3" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group col-md-4">
            <label for="name_category">Tên danh mục</label>
            <input type="text" name="name_category" class="form-control" value="{{ old('name_category') }}">
            @error('name_category')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="description">Mô tả</label>
            <input type="text" name="description" class="form-control" value="{{ old('description') }}">
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Dừng hoạt động</option>
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Ảnh danh mục</label>
            <input type="file" name="image" class="form-control">
            @error('image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Thêm</button>
        </div>
    </form>
@endsection
