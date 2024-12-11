@extends('layout.ad.master')

@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Danh sách hóa đơn</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Danh sách hóa đơn
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="product-list">
        <div class="card">
            <div class="card-body p-3">
                <div class="table-responsive border rounded">
                    <table class="table align-middle text-nowrap mb-0">
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
                                        {{ number_format(
                                            $payment->order->items->sum(function ($item) {
                                                return $item->price * $item->quantity;
                                            }),
                                            0,
                                            ',',
                                            '.',
                                        ) }}
                                        VNĐ
                                    </td>
                                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.payments.show', $payment->id) }}">
                                            <button class="btn btn-primary">
                                                <i class="bi bi-info-circle-fill"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
