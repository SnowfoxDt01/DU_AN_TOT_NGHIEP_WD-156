@extends('layout.ad.master')
@section('content')
    <section class="content-header">
        <h1>Blog detail</h1>
        <ol class="breadcrumb">
            <li class="active">Blog detail</li>
        </ol>
    </section>

    <div class="container">
        <h2><center>{{ $blog->title }}</center></h2>
        <div class="row">
            <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="img-fluid border">
        </div>
        <div>
            <p>{!! $blog->content !!}</p>
        </div>
    </div>
    <hr>
    <button class="btn btn-primary">
        <a href="{{ route('admin.blogs.index') }}" style="color: #fff">
            Back
        </a>
    </button>
    </div>
@endsection
