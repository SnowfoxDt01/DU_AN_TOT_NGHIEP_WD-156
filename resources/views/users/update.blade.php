@extends('layout.ad.master')
@section('content')
    <div class="border border-3 p-4 rounded">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Tên</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" disabled>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" disabled>
            </div>

            <div class="form-group">
                <label for="" class="form-label">Trạng thái</label>
                <select name="status" id="" class="form-select">
                    <option {{ $user->status == 1 ? 'selected' : '' }} value="1">Đang hoạt động</option>
                    <option {{ $user->status == 0 ? 'selected' : '' }} value="0">Dừng hoạt động</option>
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-success">Cập nhật</button>
        </form>
    </div>
@endsection
