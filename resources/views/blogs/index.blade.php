@extends('layout.ad.master')
@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Danh sách bài viết</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Danh sách bài viết
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
                    <button class="btn btn-primary"><a href="{{ route('admin.blogs.create') }}" style="color: #fff;">Thêm</a></button>
                </div>
                <div class="table-responsive border rounded">
                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $blog)
                                <tr>
                                    <td>{{ $blog->id }}</td>
                                    <td>{{ $blog->title }}</td>
                                    <td>
                                        <img src="{{ $blog->image }}" alt="Chưa có ảnh" class="img-thumbnail" width="100">
                                    </td>
                                    <td>
                                        @if ($blog->status == 0)
                                            <div class="d-flex align-items-center">
                                                <span class="text-bg-danger p-1 rounded-circle"></span>
                                                <p class="mb-0 ms-2">Dừng hoạt động</p>
                                            </div>
                                        @elseif($blog->status == 1)
                                            <div class="d-flex align-items-center">
                                                <span class="text-bg-success p-1 rounded-circle"></span>
                                                <p class="mb-0 ms-2">Đang hoạt động</p>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.blogs.edit', $blog->id) }}">
                                            <button class="btn btn-success" style="display: inline-block;"><i
                                                    class="bi bi-pencil-square"></i></button>
                                        </a>
                                        <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-info">
                                            <i class="bi bi-info-circle-fill"></i>
                                        </a>
                                        <form action="" method="POST" class="delete-form" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <div class="d-flex align-items-center justify-content-end py-1">
                        {{ $blogs->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
