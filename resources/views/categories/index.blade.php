@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Category
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Categories</li>
        </ol>
    </section>
    <hr>
    <div>
        <button class="btn btn-primary"><a href="{{ route('categories.create') }}" style="color: #fff;">Create</a></button>

        <div class="d-flex justify-content-end">
            <form action="{{ route('categories.index') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Nhập tên danh mục..."
                        value="{{ request('keyword') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name_category }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}">
                            <button class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
@endsection
