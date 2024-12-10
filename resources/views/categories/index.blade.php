@extends('layout.ad.master')
@section('content')
    <div class="container-fluid">
        <div class="card card-body">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Danh sách danh mục</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">
                                    <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                        Danh sách danh mục
                                    </span>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-list">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
                        <form class="d-flex align-items-center gap-3" action="{{ route('admin.categories.index') }}"
                            method="GET">
                            <!-- Input tìm kiếm -->
                            <div class="position-relative">
                                <input type="text" name="keyword" value="{{ request('keyword') }}"
                                    class="form-control py-2 ps-5" id="text-srh" placeholder="Nhập tên danh mục">
                                <i
                                    class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </div>

                            <!-- Select trạng thái -->
                            <div>
                                <select name="status" class="form-select py-2">
                                    <option value="">--Lọc theo trạng thái--</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Dừng hoạt động
                                    </option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang hoạt động
                                    </option>
                                </select>
                            </div>

                            <!-- Nút submit -->
                            <div>
                                <button type="submit" class="btn btn-primary d-flex align-items-center">
                                    <i class="bi bi-search me-2"></i> Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive border rounded">
                        <table class="table align-middle text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Danh mục</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>
                                            <p class="mb-0">{{ $category->id }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $category->image }}" class="rounded-circle" alt="materialm-img"
                                                    width="56" height="56">
                                                <div class="ms-3">
                                                    <h6 class="fw-semibold mb-0 fs-4">{{ $category->name_category }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0">{{ $category->description }}</p>
                                        </td>
                                        <td>
                                            @if ($category->status == 0)
                                                <div class="d-flex align-items-center">
                                                    <span class="text-bg-danger p-1 rounded-circle"></span>
                                                    <p class="mb-0 ms-2">Dừng hoạt động</p>
                                                </div>
                                            @elseif($category->status == 1)
                                                <div class="d-flex align-items-center">
                                                    <span class="text-bg-success p-1 rounded-circle"></span>
                                                    <p class="mb-0 ms-2">Đang hoạt động</p>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.categories.edit', $category->id) }}">
                                                <button class="btn btn-success" style="display: inline-block;"><i
                                                        class="bi bi-pencil-square"></i></button>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?')"
                                                style="display: inline-block;">
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
                        <div class="d-flex align-items-center justify-content-end py-1">
                            {{ $categories->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
