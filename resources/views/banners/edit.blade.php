@extends('layout.ad.master')

@section('content')
    <section class="content-header">
        <h1>
            Chỉnh sửa Banner
        </h1>
        <ol class="breadcrumb">
            <li class="active"> Chỉnh sửa Banner</li>
        </ol>
    </section>

    <hr>
    <div class="border border-3 p-4 rounded">
        <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}"
                    required>
            </div>

            <div class="form-group">
                <label for="image_url">Ảnh banner</label>
                <img src="{{ asset($banner->image_url) }}" alt="{{ $banner->title }}" width="200">
                <input type="file" name="image_url" class="form-control"
                    value="{{ old('image_url', $banner->image_url) }}">

            </div>

            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea name="description" class="form-control">{{ old('description', $banner->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ old('status', $banner->status) == 'active' ? 'selected' : '' }}>Hoạt động
                    </option>
                    <option value="inactive" {{ old('status', $banner->status) == 'inactive' ? 'selected' : '' }}>Không hoạt
                        động</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Chỉnh sửa</button>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
