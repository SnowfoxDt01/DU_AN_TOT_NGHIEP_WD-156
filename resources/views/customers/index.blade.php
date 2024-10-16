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
                <th scope="col">Chi tiết khách hàng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{$customer->email}}</td>
                    <td>{{$customer->phone}}</td>
                    <td>{{$customer->address}}</td>
                    <td>
                        <a href=""><button class="btn btn-primary">
                            <i class="fa-solid fa-circle-info"></i>    
                        </button></a>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->links() }}
@endsection
