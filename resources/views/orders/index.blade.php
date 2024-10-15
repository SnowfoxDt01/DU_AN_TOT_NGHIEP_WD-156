@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Đơn hàng
            <small>Trang chủ</small>
        </h1>
        <ol class="breadcrumb">
            {{-- <li><a href=""><i class="fa fa-dashboard"></i>Home</a></li> --}}
            <li class="active">Đơn hàng</li>
        </ol>
    </section>
    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">Tổng tiền</th>
                <th scope="col">Trạng thái đơn hàng</th>
                <th scope="col">Chi tiết đơn hàng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                    <td>{{ App\Enums\OrderStatus::getDescription($order->order_status) }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}"><button class="btn btn-primary">
                            <i class="fa-solid fa-circle-info"></i>    
                        </button></a>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
@endsection
