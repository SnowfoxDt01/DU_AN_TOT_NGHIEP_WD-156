@extends('layout.ad.master')

@section('content')
<div class="card card-body">
    <div class="row align-items-center">
        <div class="col-12">
            <div class="d-sm-flex align-items-center justify-space-between">
                <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Lịch sử mua hàng của: {{ $user->name }}</h4>
                <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page">
                            <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                Lịch sử mua hàng
                            </span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
    <div class="container">
        <div class="card">
            <div class="card-body p-3">
                @if ($orders->count())
                    <div class="d-flex justify-content-center">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Tổng giá</th>
                                    <th>Ngày mua</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Phương thức thanh toán</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            @foreach ($order->items as $item)
                                                {{ $item->product->name }}
                                                <br>
                                                <small>Số lượng: {{ $item->quantity }}</small>
                                                <hr>
                                            @endforeach
                                        </td>
                                        <td>{{ $order->items->sum('quantity') }}</td>
                                        <td>{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                                        <td>{{ $order->date_order->format('d/m/Y') }}</td>
                                        <td>{{ $order->order_status->description ?? $order->order_status }}</td>
                                        <td>{{ $order->payment_method->description ?? $order->payment_method }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $orders->links() }}
                @else
                    <p class="text-center">Tài khoản chưa có đơn hàng nào.</p>
                @endif
            </div>
        </div>
    @endsection
