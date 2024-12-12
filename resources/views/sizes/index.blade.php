@extends('layout.ad.master')

@section('content')
    <div class="container">
        <div class="card card-body">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Danh sách kích thước</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">
                                    <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                        Danh sách kích thước
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
                        <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary">Thêm Kích Thước</a>
                    </div>
                    <div class="table-responsive border rounded">
                        <table class="table align-middle text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sizes as $size)
                                    <tr>
                                        <td>{{ $size->id }}</td>
                                        <td>{{ $size->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.sizes.edit', $size) }}" class="btn btn-warning"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('admin.sizes.destroy', $size) }}" method="POST"
                                                style="display:inline;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <div class="d-flex align-items-center justify-content-end py-1">
                            {{ $sizes->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
