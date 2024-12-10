@extends('layout.ad.master')
@section('content')
    <section class="content-header">
        <h1>
            Danh sách mã giảm giá
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
            <li class="active">Danh sách mã giảm giá</li>
        </ol>
    </section>
    <hr>
    <div>
        <button class="btn btn-primary"><a href="{{ route('admin.vouchers.create') }}" style="color: #fff;">Thêm</a></button>
    </div>

    <hr>
    <table class="table table-striped">
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
                        @switch($voucher->status)
                            @case('inactive')
                                <span class="badge bg-red">Dừng hoạt động</span>
                            @break

                            @case('active')
                                <span class="badge bg-green">Đang hoạt động</span>
                            @break

                            @default
                                <span class="badge bg-gray">Không xác định</span>
                        @endswitch
                    </td>
                    <td>
                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}">
                            <button class="btn btn-success" style="display: inline-block;"><i
                                    class="bi bi-pencil-square"></i></button>
                        </a>
                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?')" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" ><i class="bi bi-trash3-fill"></i></button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $vouchers->links() }}
@endsection
