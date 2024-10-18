@extends('layout.admin.master')
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
        

        <a href="{{ route('admin.variant-products.create') }}" class="btn btn-primary mb-3">Thêm mới</a>
        <hr>
        <a href="{{ route('admin.variant-products.statistics') }}" class="btn btn-primary mb-3">Thống kê sản phẩm</a>
        <hr>
        <form method="GET" action="{{ route('admin.variant-products.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Tìm theo tên sản phẩm" value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <select name="color_id" class="form-control">
                        <option value="">Chọn màu sắc</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}" {{ request('color_id') == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="size_id" class="form-control">
                        <option value="">Chọn kích cỡ</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}" {{ request('size_id') == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-control">
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name_category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Lọc</button>
        </form>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Danh mục</th>
                    <th>Hình ảnh</th>
                    <th>Kích cỡ</th>
                    <th>Màu sắc</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($variantProducts as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->category->name_category }}</td>
                        <td>
                            <img class="img-prd" src="{{ asset($product->image_url) }}" alt="">
                        </td>
                        <td>{{ $product->size->name }}</td>
                        <td>{{ $product->color->name }}</td>
                        <td>{{ $product->status }}</td>
                        <td>
                            <a href="{{ route('admin.variant-products.show', $product->id) }}" class="btn btn-info">Chi tiết</a>
                            <a href="{{ route('admin.variant-products.edit', $product->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('admin.variant-products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('bạn có chắc muốn xóa không?') ">Xóa</button>
                            </form>
                        </td>                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

