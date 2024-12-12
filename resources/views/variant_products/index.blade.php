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
        <div class="card card-body">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Danh sách sản phẩm biến thể</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">
                                    <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                        Danh sách sản phẩm biến thể
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
                <a href="{{ route('admin.variant-products.statistics') }}" class="btn btn-primary mb-3">Thống kê sản
                    phẩm</a>
                <br>
                <form method="GET" action="{{ route('admin.variant-products.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="name" class="form-control" placeholder="Tìm theo tên sản phẩm"
                                value="{{ request('name') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="color_id" class="form-control">
                                <option value="">Chọn màu sắc</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}"
                                        {{ request('color_id') == $color->id ? 'selected' : '' }}>
                                        {{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="size_id" class="form-control">
                                <option value="">Chọn kích cỡ</option>
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}"
                                        {{ request('size_id') == $size->id ? 'selected' : '' }}>
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
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary d-flex align-items-center">
                                <i class="ti ti-filter" style="font-size: 20px"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Sản phẩm chính</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Kích cỡ</th>
                            <th scope="col">Màu sắc</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Hành động</th>
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
                                    @if ($product->status == 'inactive')
                                        <div class="d-flex align-items-center">
                                            <span class="text-bg-danger p-1 rounded-circle"></span>
                                            <p class="mb-0 ms-2">Đã hết hàng</p>
                                        </div>
                                    @elseif($product->status == 'active')
                                        <div class="d-flex align-items-center">
                                            <span class="text-bg-success p-1 rounded-circle"></span>
                                            <p class="mb-0 ms-2">Còn hàng</p>
                                        </div>
                                    @endif
                                </td>
                                <td style="display: inline-flex; gap: 5px;">
                                    <a href="{{ route('admin.variant-products.show', $product->id) }}"
                                        class="btn btn-info"><i class="bi bi-info-circle-fill"></i></a>
                                    <a href="{{ route('admin.variant-products.edit', $product->id) }}"
                                        class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('admin.variant-products.destroy', $product->id) }}"
                                        method="POST" style="display:inline;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i
                                                class="bi bi-trash3-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <div class="d-flex align-items-center justify-content-end py-1">
                    {{ $variantProducts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
