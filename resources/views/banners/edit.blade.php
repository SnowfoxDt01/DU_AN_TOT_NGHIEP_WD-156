@extends('layout.ad.master')

@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Chỉnh sửa banner</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Chỉnh sửa banner
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-3">
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
                    <br>
                    <img src="{{ asset($banner->image_url) }}" alt="{{ $banner->title }}" width="200">
                    <input type="file" name="image_url" class="form-control"
                        value="{{ old('image_url', $banner->image_url) }}">

                </div>
                <br>
                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea name="description" class="form-control">{{ old('description', $banner->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ old('status', $banner->status) == 'active' ? 'selected' : '' }}>Hoạt động
                        </option>
                        <option value="inactive" {{ old('status', $banner->status) == 'inactive' ? 'selected' : '' }}>Không
                            hoạt
                            động</option>
                    </select>
                </div>
                <br>
                <button type="submit" class="btn btn-success">Chỉnh sửa</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-light">Quay lại</a>
            </form>
        </div>
    </div>
@endsection
