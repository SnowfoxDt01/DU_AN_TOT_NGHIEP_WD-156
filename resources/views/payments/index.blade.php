@extends('layout.ad.master')

@section('content')
    <h1>Danh Sách Hóa Đơn</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã Hóa Đơn</th>
                <th>Tên Khách Hàng</th>
                <th>Tổng Tiền</th>
                <th>Ngày Thanh Toán</th>
                <th>Chi Tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->order->customer->name ?? 'Không có' }}</td>
                    <td>
                        {{ number_format($payment->order->items->sum(function ($item) {
                            return $item->price * $item->quantity;
                        }), 0, ',', '.') }} VNĐ
                    </td>
                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.payments.show', $payment->id) }}">
                            <button class="btn btn-primary">
                                <i class="fa-solid fa-circle-info"></i>    
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
