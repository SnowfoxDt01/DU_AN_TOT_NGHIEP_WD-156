@extends('layout.admin.master')

@section('content')
    <div class="container">
        <h2>Lịch sử mua hàng của: {{ $customer->name }}</h2>

        @if($orders->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sản phẩm</th>
                        <th>Tổng số lượng</th>
                        <th>Tổng giá</th>
                        <th>Ngày mua</th>
                        <th>Trạng thái đơn hàng</th>
                        <th>Phương thức thanh toán</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                @foreach($order->items as $item)
                                    {{ $item->product->name }} <hr>
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

            {{ $orders->links() }}
        @else
            <p>Khách hàng chưa có đơn hàng nào.</p>
        @endif
    </div>
@endsection
