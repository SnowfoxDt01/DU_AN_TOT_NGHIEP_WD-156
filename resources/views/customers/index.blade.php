@extends('layout.ad.master')
@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Danh sách khách hàng</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Danh sách khách hàng
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
                    <form method="GET" class="d-flex align-items-center gap-3 w-100"
                        action="{{ route('admin.customers.index') }}">
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-group">
                                <label for="name">Tên khách hàng:</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ request('name') }}">
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" name="email" id="email" class="form-control"
                                    value="{{ request('email') }}">
                            </div>

                            <div class="form-group">
                                <label for="phone">Số điện thoại:</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ request('phone') }}">
                            </div>

                            <div class="form-group">
                                <label for="status">Trạng thái:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">-- Tất cả --</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang hoạt động
                                    </option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Dừng hoạt động
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary d-flex align-items-center mt-auto">
                                <i class="ti ti-filter" style="font-size: 20px"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive border rounded">
                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Email</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Địa chỉ</th>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex align-items-center justify-content-end py-1">
                        {{ $customers->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
