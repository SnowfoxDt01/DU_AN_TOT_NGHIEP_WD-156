@extends('layout.ad.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('src/assets/css/blogdetail.css') }}">
@endpush
@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Chi tiết bài viết</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Chi tiết bài viết
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-4">
            <div class="container">
                <h2 class="text-center mb-4">{{ $blog->title }}</h2>
                <div class="row justify-content-center mb-4">
                    <div class="col-md-10">
                        <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="img-fluid border rounded">
                    </div>
                </div>
                <div class="content">
                    <p>{!! $blog->content !!}</p>
                </div>
            </div>
            <hr>
            <div class="text-end">
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
