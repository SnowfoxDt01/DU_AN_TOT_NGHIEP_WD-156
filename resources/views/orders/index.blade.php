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
<div id="newOrderAlert" style="display: none;">
    <p>Bạn có <span id="newOrderCount"></span> đơn hàng mới!</p>
</div>
<form action="{{ route('admin.orders.index') }}" method="GET">
    <div class="form-group">
        <label for="order_status">Lọc theo trạng thái đơn hàng:</label>
        <select name="order_status" id="order_status" class="form-control">
            <option value="">Tất cả</option>
            @foreach (App\Enums\OrderStatus::getValues() as $status)
            <option value="{{ $status }}" {{ request('order_status') == $status ? 'selected' : '' }}>
                {{ App\Enums\OrderStatus::getDescription($status) }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="start_date">Từ ngày:</label>
        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
    </div>

    <div class="form-group">
        <label for="end_date">Đến ngày:</label>
        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
    </div>

    <button type="submit" class="btn btn-primary">Lọc</button>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Reset</a>
</form>


<hr>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên khách hàng</th>
            <th scope="col">Tổng tiền</th>
            <th scope="col">Thời gian đặt hàng</th> <!-- Thêm cột thời gian -->
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
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td> <!-- Hiển thị thời gian -->
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

@push('scripts')
<script type="text/javascript">
    function checkNewOrders() {
        $.ajax({
            url: 'orders/check-new-orders',
            method: 'GET',
            success: function(response) {
                var newOrders = response.newOrders;
                var newOrdersList = $('#newOrdersList');

                if (newOrders > 0) {
                    $('#orderNotificationCount').text(newOrders)
                        .show();
                    newOrdersList.empty();
                    response.orders.forEach(function(order) {
                        var orderItem = '<a class="dropdown-item" href="/admin/orders/detail/' + order.id +
                            '">' +
                            'Đơn hàng # ' + order.id + '  từ  ' + order.customer.name + '</a>';
                        newOrdersList.append(orderItem);
                    });
                } else {
                    $('#orderNotificationCount').hide();
                    newOrdersList.html('<p class="dropdown-item">Không có đơn hàng mới</p>');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    setInterval(checkNewOrders, 5000);
</script>
@endpush