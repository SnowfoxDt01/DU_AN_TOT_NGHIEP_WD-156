@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Chỉnh sửa danh mục
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
            <li class="active">Chỉnh sửa danh mục</li>
        </ol>
    </section>
    <hr>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name_category">Tên danh mục</label>
            <input type="text" name="name_category" value="{{ $category->name_category }}" class="form-control">
            @error('name_category')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <input type="text" name="description" value="{{ $category->description }}" class="form-control">
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Dừng hoạt động</option>
                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Đang hoạt động</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Ảnh danh mục</label>
            <input type="file" name="image" class="form-control">
            @error('image')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            @if ($category->image)
                <div class="mt-2">
                    <img src="{{ asset($category->image) }}" alt="Category Image" style="max-width: 200px;">
                </div>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Sửa</button>
        </div>
    </form>
@endsection
