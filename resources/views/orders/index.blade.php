@extends('layout.ad.master')
@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Danh sách đơn hàng</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Danh sách đơn hàng
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
                <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
                    <form action="{{ route('admin.orders.index') }}" method="GET">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="order_status">Trạng thái đơn hàng:</label>
                                <select name="order_status" id="order_status" class="form-control">
                                    <option value="">Tất cả</option>
                                    @foreach (App\Enums\OrderStatus::getValues() as $status)
                                        <option value="{{ $status }}"
                                            {{ request('order_status') == $status ? 'selected' : '' }}>
                                            {{ App\Enums\OrderStatus::getDescription($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- lọc --}}
                            <div class="form-group col-md-2">
                                <label for="customer_name">Tên khách hàng:</label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control"
                                    value="{{ request('customer_name') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="phone">Số điện thoại:</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ request('phone') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ request('email') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="start_date">Từ ngày:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="end_date">Đến ngày:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Lọc</button>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-danger">Reset</a>
                                <a href="{{ route('admin.orders.statistics') }}" class="btn btn-info">Xem thống kê</a>
                                <a href="{{ route('admin.orders.export') }}" class="btn btn-success">Xuất Excel</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive border rounded">
                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Email</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Ngày đặt hàng</th>
                                <th scope="col">Trạng thái đơn hàng</th>
                                <th scope="col">Chi tiết đơn hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>{{ $order->customer->phone }}</td>
                                    <td>{{ $order->customer->email }}</td>
                                    <td>
                                        {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
                                    </td>
                                    <td>{{ $order->date_order->format('d/m/Y') }}</td>
                                    <td>{{ App\Enums\OrderStatus::getDescription($order->order_status) }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}">
                                            <button class="btn btn-primary">
                                                <i class="bi bi-info-circle-fill"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex align-items-center justify-content-end py-1">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
