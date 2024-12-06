@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Danh sách bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
            <li class="active">Danh sách bài viết</li>
        </ol>
    </section>
    <hr>
    <div>
        <button class="btn btn-primary"><a href="{{ route('admin.blogs.create') }}" style="color: #fff;">Thêm</a></button>
    </div>

    <hr>
    <table class="table table-striped">
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
                        <img src="{{$blog->image}}" alt="Chưa có ảnh" class="img-thumbnail" width="100">
                    </td>
                    <td>
                        @if ($blog->status == 0)
                            <span class="badge bg-red">Dừng hoạt động</span>
                        @elseif($blog->status == 1)
                            <span class="badge bg-green">Đang hoạt động</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}">
                            <button class="btn btn-success" style="display: inline-block;"><i class="bi bi-pencil-square"></i></button>
                        </a>
                        <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-info">
                            <i class="fa-solid fa-circle-info"></i>
                        </a>
                        <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?')" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" ><i class="bi bi-trash3-fill"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $blogs->links() }}
@endsection
