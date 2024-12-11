@extends('layout.ad.master')

@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Danh sách banner</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Danh sách banner
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
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Thêm Banner mới</a>
                </div>
                <div class="table-responsive border rounded">
                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>Ảnh</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->title }}</td>
                                    <td><img src="{{ asset($banner->image_url) }}" alt="{{ $banner->title }}"
                                            width="100"></td>
                                    <td>
                                        @if ($banner->status == 'inactive')
                                            <div class="d-flex align-items-center">
                                                <span class="text-bg-danger p-1 rounded-circle"></span>
                                                <p class="mb-0 ms-2">Dừng hoạt động</p>
                                            </div>
                                        @elseif($banner->status == 'active')
                                            <div class="d-flex align-items-center">
                                                <span class="text-bg-success p-1 rounded-circle"></span>
                                                <p class="mb-0 ms-2">Đang hoạt động</p>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ route('admin.banners.show', $banner->id) }}" class="btn btn-info"><i
                                                    class="bi bi-info-circle-fill"></i></a>
                                            <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                                class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                                style="display:inline-block;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="bi bi-trash3-fill"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
