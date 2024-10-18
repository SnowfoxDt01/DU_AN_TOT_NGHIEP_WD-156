@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Danh sách khách hàng
            <small>Trang chủ</small>
        </h1>
        <ol class="breadcrumb">
            {{-- <li><a href=""><i class="fa fa-dashboard"></i>Home</a></li> --}}
            <li class="active">Khách hàng</li>
        </ol>
    </section>
    <hr>
    <form method="GET" action="{{ route('admin.customers.index') }}">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">Tên khách hàng:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
                </div>
            </div>
    
            <div class="col-md-3">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" class="form-control" value="{{ request('email') }}">
                </div>
            </div>
    
            <div class="col-md-3">
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ request('phone') }}">
                </div>
            </div>
    
            <div class="col-md-2">
                <div class="form-group">
                    <label for="status">Trạng thái:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">-- Tất cả --</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Dừng hoạt động</option>
                    </select>
                </div>
            </div>
    
            <div>
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Chi tiết khách hàng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>
                        @if ($customer->status == 0)
                            <span class="badge bg-red">Dừng hoạt động</span>
                        @elseif($customer->status == 1)
                            <span class="badge bg-green">Đang hoạt động</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.customers.show', $customer->id) }}"><button class="btn btn-primary">
                                <i class="fa-solid fa-circle-info"></i>
                            </button></a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->links() }}
@endsection
