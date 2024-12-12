@extends('layout.ad.master')
@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Danh sách mã giảm giá</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Danh sách mã giảm giá
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
                    <button class="btn btn-primary"><a href="{{ route('admin.vouchers.create') }}"
                        style="color: #fff;">Thêm</a></button>
                </div>
                <div class="table-responsive border rounded">
                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Mã giảm giá</th>
                                <th scope="col">Giá giảm</th>
                                <th scope="col">Loại giảm giá</th>
                                <th scope="col">Ngày hết hạn</th>
                                <th scope="col">Lượt sử dụng tối đa</th>
                                <th scope="col">Đã sử dụng</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vouchers as $voucher)
                                <tr>
                                    <td>{{ $voucher->id }}</td>
                                    <td>{{ $voucher->code }}</td>
                                    <td>{{ number_format($voucher->discount) }}</td>
                                    <td>
                                        @switch($voucher->discount_type)
                                            @case('fixed')
                                                <span>Giảm theo giá cố định</span>
                                            @break
                
                                            @case('percentage')
                                                <span>Giảm theo phần trăm</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @if ($voucher->expiry_date != null)
                                            {{ $voucher->expiry_date }}
                                        @else
                                            Không giới hạn
                                        @endif
                                    </td>
                                    <td>
                                        @if ($voucher->usage_limit != null)
                                            {{ $voucher->usage_limit }}
                                        @else
                                            Không giới hạn
                                        @endif
                                    </td>
                                    <td>{{ $voucher->usage_count }}</td>
                                    <td>
                                        @if ($voucher->status == 'inactive')
                                            <div class="d-flex align-items-center">
                                                <span class="text-bg-danger p-1 rounded-circle"></span>
                                                <p class="mb-0 ms-2">Dừng hoạt động</p>
                                            </div>
                                        @elseif($voucher->status == 'active')
                                            <div class="d-flex align-items-center">
                                                <span class="text-bg-success p-1 rounded-circle"></span>
                                                <p class="mb-0 ms-2">Đang hoạt động</p>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}">
                                            <button class="btn btn-success" style="display: inline-block;"><i
                                                    class="bi bi-pencil-square"></i></button>
                                        </a>
                                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa không?')" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                                        </form>
                                    </td>
                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <div class="d-flex align-items-center justify-content-end py-1">
                        {{ $vouchers->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
