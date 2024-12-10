@extends('layout.ad.master')

@section('content')
    <h1>Sửa Banner</h1>
    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}" readonly>
        </div>

        <div class="form-group">
            <label for="image_url">Ảnh banner</label>
            <input type="text" name="image_url" class="form-control" value="{{ old('image_url', $banner->image_url) }}" readonly>
            <img src="{{ asset($banner->image_url) }}" alt="{{ $banner->title }}" width="200">
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea name="description" class="form-control" readonly>{{ old('description', $banner->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select name="status" class="form-control" readonly>
                <option value="active" {{ old('status', $banner->status) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ old('status', $banner->status) == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-warning">Chỉnh sửa</a>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
