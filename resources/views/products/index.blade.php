@extends('layout.admin.master')

@push('styles')
    <style>
        .img-prd{
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
<section class="content-header">
    <h1>
        Product
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        {{-- <li><a href=""><i class="fa fa-dashboard"></i>Home</a></li> --}}
        <li class="active">Products</li>
    </ol>
</section>
<hr>
        <button class="btn btn-primary"><a href="{{  route('admin.products.addProduct') }}" style="color: #fff;">Create</a></button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Image</th>
                <th scope="col">Quantity</th>
                <th scope="col">Category</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listProduct as $key => $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->description }}</td>
                    <td>{{ $value->price }}</td>
                    <td>
                        <img class="img-prd" src="{{ asset($value->image) }}" alt="">
                    </td>
                    <td>{{ $value->quantity }}</td>
                    <td>{{ $value->category->name_category ?? 'No category' }}</td>

                    <td>
                    <a href="{{ route('admin.products.editProduct', $value->id) }}" class="btn btn-warning">Sửa</a>
                        <button class="btn btn-info">Chi tiết</button>
                            
                        <form action="{{ route('admin.products.deleteProduct', $value->id) }}" method="POST" onsubmit="return confirm('Ban co muon xoa khong?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $listProduct->links('pagination::bootstrap-5') }}
@endsection
