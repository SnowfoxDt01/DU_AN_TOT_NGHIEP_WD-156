@extends('layout.client.master')
@section('content')
    <section class="page-banner bg-image pt-130 pb-130" data-background="assets/images/banner/inner-banner.jpg">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Chi tiết bài viết</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Trang chủ
                    <i class="fa-regular text-white fa-angle-right"></i></a>
                <a href="{{ route('client.blog.index') }}" class="primary-hover">Bài viết
                    <i class="fa-regular text-white fa-angle-right"></i></a>
                <span>Chi tiết bài viết</span>
            </div>
        </div>
    </section>
    <hr>
    <section class="blog-slingle pt-130 pb-130">
        <div class="container">
            <div class="row g-4">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="image mb-30">
                            <img src="{{ $blog->image }}" alt="image">
                        </div>
                        <div class="item">
                            <div class="info">
                                <span class="info_dot"></span>
                                <span>{{ $blog->created_at->format('d/m/Y') }}</span>
                            </div>
                            <h3 class="text-capitalize mt-30 mb-3">{{ $blog->title }}
                            </h3>
                            <p class="mt-3 mb-3">{!! $blog->content !!}</p>
                        </div>
                        <div class="tag-share py-4 bor-top bor-bottom">
                            <div class="tag">
                                <strong class="me-2">Tags:</strong>
                                <a href="#0">Creative</a>
                                <a href="#0">Agency</a>
                                <a href="#0">Business</a>
                            </div>
                            <div class="share">
                                <strong class="me-2">Share:</strong>
                                <a href="#0"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#0"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#0"><i class="fa-brands fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h4 class="mb-30">Bài viết nổi bật:</h4>
                    <div class="recent-posts-container d-flex flex-wrap">
                        @foreach ($blogs as $hot)
                            <div class="recent-post p-0 bor-bottom pb-4 mb-4 sub-bg">
                                <div class="img">
                                    <img src="{{ $hot->image }}" alt="image">
                                </div>
                                <div class="con">
                                    <span>{{ $hot->created_at->format('d/m/Y') }}</span>
                                    <h5><a href="{{ route('client.blog.detailBlog', $hot->id) }}">{{ $hot->title }}</a>
                                    </h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
