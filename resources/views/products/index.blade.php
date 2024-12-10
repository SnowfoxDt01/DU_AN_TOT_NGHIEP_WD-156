@extends('layout.ad.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('src/assets/css/index-product.css') }}">
@endpush
@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Danh sách sản phẩm</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Danh sách sản phẩm
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="product-list">
        <div class="card w-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
                    <form method="GET" action="{{ route('admin.products.listProduct') }}" class="d-flex align-items-end">
                        <div class="me-2"> <!-- Khoảng cách bên phải cho các input -->
                            <input type="text" name="name" class="form-control product-name"
                                placeholder="Tên sản phẩm" value="{{ request('name') }}">
                        </div>
                        <div class="me-2">
                            <input type="number" name="min_price" class="form-control" placeholder="Giá tối thiểu"
                                value="{{ request('min_price') }}">
                        </div>
                        <div class="me-2">
                            <input type="number" name="max_price" class="form-control" placeholder="Giá tối đa"
                                value="{{ request('max_price') }}">
                        </div>
                        <div class="me-2">
                            <select name="category_id" class="form-control">
                                <option value="">Tất cả thể loại</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name_category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    <button class="btn btn-primary"><a href="{{ route('admin.products.addProduct') }}"
                            style="color: #fff;">Thêm sản
                            phẩm</a></button>
                </div>
                <div class="table-responsive border rounded">
                    <table class="table align-middle text-nowrap mb-0">
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
                                            <img src="{{ asset($value->images->first()->image_path) }}"
                                                alt="{{ $value->name }}" class="img-thumbnail" width="100">
                                        @else
                                            <img src="{{ asset('default_image.jpg') }}" alt="No Image"
                                                class="img-thumbnail" width="100">
                                        @endif
                                    </td>
                                    <td>{{ $value->getTotalQuantity() }}</td>
                                    <td>{{ $value->category->name_category ?? 'No category' }}</td>

                                    <td>
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ route('admin.products.editProduct', $value->id) }}"
                                                class="btn btn-success">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="{{ route('admin.products.detailProduct', $value->id) }}"
                                                class="btn btn-info">
                                                <i class="bi bi-info-circle-fill"></i>
                                            </a>
                                            {{-- xóa mềm --}}
                                            <form action="{{ route('admin.products.deleteProduct', $value->id) }}"
                                                method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-eye-slash"></i>
                                                </button>
                                            </form>
                                            {{-- xóa cứng --}}
                                            <form action="{{ route('admin.products.hardDeleteProduct', $value->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa cứng không?')">
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
                    <br>
                    <div class="d-flex align-items-center justify-content-end py-1">
                        {{ $listProduct->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
