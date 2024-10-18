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
