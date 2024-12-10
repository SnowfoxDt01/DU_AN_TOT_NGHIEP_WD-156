@extends('layout.ad.master')
@push('styles')
    <style>
        .img-prd {
            width: 70px;
            height: 70px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h1>Danh sách sản phẩm biến thể</h1>

        <hr>
        <a href="{{ route('admin.variant-products.statistics') }}" class="btn btn-primary mb-3">Thống kê sản phẩm</a>
        <hr>
        <form method="GET" action="{{ route('admin.variant-products.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Tìm theo tên sản phẩm"
                        value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <select name="color_id" class="form-control">
                        <option value="">Chọn màu sắc</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}" {{ request('color_id') == $color->id ? 'selected' : '' }}>
                                {{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="size_id" class="form-control">
                        <option value="">Chọn kích cỡ</option>
                        @foreach ($sizes as $size)
                            <option value="{{ $size->id }}" {{ request('size_id') == $size->id ? 'selected' : '' }}>
                                {{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="product_id" class="form-control">
                        <option value="">Chọn sản phẩm chính</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Lọc</button>
        </form>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Số lượng</th>
                    <th>Sản phẩm chính</th>
                    <th>Hình ảnh</th>
                    <th>Kích cỡ</th>
                    <th>Màu sắc</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($variantProducts as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->product->name }}</td>
                        <td>
                            @if ($product->images->count() > 0)
                                @foreach ($product->images as $image)
                                    <img src="{{ asset($image->image_path) }}" alt="Ảnh biến thể" class="img-prd">
                                @endforeach
                            @else
                                <span>Không có ảnh</span>
                            @endif
                        </td>
                        <td>{{ $product->size->name }}</td>
                        <td>{{ $product->color->name }}</td>
                        <td>
                            @if ($product->status == 'active')
                                <span class="badge bg-success">Còn hàng</span>
                            @else
                                <span class="badge bg-danger">Không còn hàng</span>
                            @endif
                        </td>
                        <td style="display: inline-flex; gap: 5px;">
                            <a href="{{ route('admin.variant-products.show', $product->id) }}" class="btn btn-info"><i
                                    class="fa-solid fa-circle-info"></i></a>
                            <a href="{{ route('admin.variant-products.edit', $product->id) }}" class="btn btn-warning"><i
                                    class="bi bi-pencil-square"></i></a>
                            <form action="{{ route('admin.variant-products.destroy', $product->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('bạn có chắc muốn xóa không?')"><i
                                        class="bi bi-trash3-fill"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
