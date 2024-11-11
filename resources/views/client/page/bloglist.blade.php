@extends('layout.client.master')
@section('content')
    <section class="page-banner bg-image pt-130 pb-130" data-background="assets/images/banner/inner-banner.jpg">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Bài viết</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Trang chủ
                    <i class="fa-regular text-white fa-angle-right"></i></a>
                <span>Bài viết</span>
            </div>
        </div>
    </section>
    <hr>
    <section class="blog pt-130 pb-130">
        <div class="container">
            <div class="row g-4">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog__item-right">
                            <a href="blog-single.html" class="image d-block">
                                <img class="radius-10" src="{{$blog->image}}" alt="image" style="height: 250px">
                            </a>
                            <h3><a href="">{{$blog->title}}</a>
                            </h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="blog__tag">vapers</span>
                                <span>{{$blog->created_at->format('d/m/Y')}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-65">
                <a class="blog-pegi" href="#0">01</a>
                <a class="blog-pegi active" href="#0">02</a>
                <a class="blog-pegi" href="#0">03</a>
                <a href="#0"><i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
        </div>
    </section>
@endsection
