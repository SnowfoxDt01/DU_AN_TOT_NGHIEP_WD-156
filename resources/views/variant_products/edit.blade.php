@extends('layout.ad.master')

@push('styles')
    <style>
        .img-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Chỉnh sửa sản phẩm biến thể</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Chỉnh sửa sản phẩm biến thể
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body p-3">
            <div class="container">
                <h3>Chỉnh sửa sản phẩm biến thể</h3>
                <form action="{{ route('admin.variant-products.update', $variantProduct->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $variantProduct->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="quantity">Số lượng</label>
                                <input type="number" name="quantity" class="form-control"
                                    value="{{ $variantProduct->quantity }}" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="product_id">Sản phẩm chính</label>
                                <select name="product_id" class="form-control" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $product->id == $variantProduct->product_id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="size_id">Kích cỡ</label>
                                <select name="size_id" class="form-control" required>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}"
                                            {{ $size->id == $variantProduct->size_id ? 'selected' : '' }}>
                                            {{ $size->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="color_id">Màu sắc</label>
                                <select name="color_id" class="form-control" required>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}"
                                            {{ $color->id == $variantProduct->color_id ? 'selected' : '' }}>
                                            {{ $color->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Trạng thái</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" {{ $variantProduct->status == 'active' ? 'selected' : '' }}>Còn
                                        hàng
                                    </option>
                                    <option value="inactive" {{ $variantProduct->status == 'inactive' ? 'selected' : '' }}>
                                        Không
                                        còn hàng
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image_path">Hình ảnh</label>
                        <input type="file" class="form-control" id="image_path" name="image_path">

                        <div class="mt-3">
                            @if ($variantProduct->images->count() > 0)
                                @foreach ($variantProduct->images as $image)
                                    <img src="{{ asset($image->image_path) }}" alt="Ảnh biến thể" class="img-preview">
                                @endforeach
                            @else
                                <span>Không có ảnh</span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Cập nhật sản phẩm biến thể</button>
                    <a href="{{ route('admin.variant-products.index') }}" class="btn btn-light">Quay lại</a>

                </form>
            </div>
        </div>
    </div>
@endsection
