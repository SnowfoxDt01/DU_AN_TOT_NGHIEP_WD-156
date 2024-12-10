@extends('layout.ad.master')

@section('content')
    <section class="content-header">
        <h1>
            Danh sách Banner
            <small> | bảng điều khiển</small>
        </h1>
    </section>
    <hr>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Thêm Banner mới</a>
    <br>
    <br>
    <table class="table">
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
                    <td><img src="{{ asset($banner->image_url) }}" alt="{{ $banner->title }}" width="100"></td>
                    <td>
                        @if($banner->status == 'active')
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-danger">Không hoạt động</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                        <a href="{{ route('admin.banners.show', $banner->id) }}" class="btn btn-info"><i class="fa-solid fa-circle-info"></i></a>
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                        </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
