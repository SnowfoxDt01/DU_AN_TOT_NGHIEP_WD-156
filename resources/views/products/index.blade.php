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
<section class="content-header">
    <h1>
        Danh sách sản phẩm
        <small> | bảng điều khiển</small>
    </h1>
    <ol class="breadcrumb">
        {{-- <li><a href=""><i class="fa fa-dashboard"></i>Home</a></li> --}}
        <li class="active">Sản phẩm</li>
    </ol>
</section>

<hr>

<button class="btn btn-primary"><a href="{{  route('admin.products.addProduct') }}" style="color: #fff;">Thêm sản phẩm</a></button>
<br>
<br>
<div class="text-end">
    <form method="GET" action="{{ route('admin.products.listProduct') }}" class="d-flex align-items-end">
        <div class="me-2"> <!-- Khoảng cách bên phải cho các input -->
            <input type="text" name="name" class="form-control" placeholder="Tên sản phẩm" value="{{ request('name') }}">
        </div>
        <div class="me-2">
            <input type="number" name="min_price" class="form-control" placeholder="Giá tối thiểu" value="{{ request('min_price') }}">
        </div>
        <div class="me-2">
            <input type="number" name="max_price" class="form-control" placeholder="Giá tối đa" value="{{ request('max_price') }}">
        </div>
        <div class="me-2">
            <select name="category_id" class="form-control">
                <option value="">Tất cả thể loại</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name_category }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
        </div>
    </form>
</div>



<br>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên</th>
            <th scope="col">Giá</th>
            <th scope="col">Giá khuyến mãi</th>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Số lượng</th>
            <th scope="col">Danh mục</th>
            <th scope="col">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listProduct as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ number_format($value->base_price) }}.đ</td>
            <td>{{ number_format($value->sale_price) }}.đ</td>
            <td>
                @if ($value->images->count() > 0)
                    <img src="{{ asset($value->images->first()->image_path) }}" alt="{{ $value->name }}" class="img-thumbnail" width="100">
                @else
                    <img src="{{ asset('default_image.jpg') }}" alt="No Image" class="img-thumbnail" width="100">
                @endif
            </td>
            <td>{{ $value->getTotalQuantity() }}</td>
            <td>{{ $value->category->name_category ?? 'No category' }}</td>

            <td>
                <div style="display: flex; gap: 5px;">
                    <a href="{{ route('admin.products.editProduct', $value->id) }}" class="btn btn-success">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="{{ route('admin.products.detailProduct', $value->id) }}" class="btn btn-info">
                        <i class="fa-solid fa-circle-info"></i>
                    </a>
                    {{-- xóa mềm --}}
                    <form action="{{ route('admin.products.deleteProduct', $value->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>
                    </form>
                    {{-- xóa cứng --}}
                    <form action="{{ route('admin.products.hardDeleteProduct', $value->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa cứng không?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $listProduct->links('pagination::bootstrap-5') }}
@endsection