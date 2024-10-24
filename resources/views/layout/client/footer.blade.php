<footer class="footer-area bg-image" data-background="client_ui/assets/images/footer/footer-bg.jpg">
    <div class="container">
        <div class="footer__wrp pt-65 pb-65 bor-top bor-bottom">
            <div class="row g-4">
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                    <div class="footer__item">
                        <h4 class="footer-title">Danh mục</h4>
                        <ul>
                            @foreach ($categories as $category)
                                <li><a href="#"><span></span>{{ $category->name_category }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1.2s" data-wow-delay=".2s">
                    <div class="footer__item">
                        <h4 class="footer-title">Get to Know Us</h4>
                        <ul>
                            <li><a href="about.html"><span></span>About Us</a></li>
                            <li><a href="blog-grid.html"><span></span>News & Blog</a></li>
                            <li><a href="error.html"><span></span>Careers</a></li>
                            <li><a href="error.html"><span></span>Investors</a></li>
                            <li><a href="contact.html"><span></span>Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1.2s" data-wow-delay=".2s">
                    <div class="footer__item">
                        <h4 class="footer-title">Get to Know Us</h4>
                        <ul>
                            <li><a href="about.html"><span></span>About Us</a></li>
                            <li><a href="blog-grid.html"><span></span>News & Blog</a></li>
                            <li><a href="error.html"><span></span>Careers</a></li>
                            <li><a href="error.html"><span></span>Investors</a></li>
                            <li><a href="contact.html"><span></span>Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1.4s" data-wow-delay=".4s">
                    <div class="footer__item newsletter">
                        <h4 class="footer-title">Địa chỉ google map : </h4>
                        <div class="mapouter">
                            <div class="gmap_canvas"><iframe width="350" height="300" id="gmap_canvas"
                                    src="https://maps.google.com/maps?q=Tr%E1%BB%8Bnh%20V%C4%83n%20B%C3%B4&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a
                                    href="https://123movies-i.net">123 movies</a><br>
                                <style>
                                    .mapouter {
                                        position: relative;
                                        text-align: right;
                                        height: 300px;
                                        width: 350px;
                                    }
                                </style><a href="https://www.embedgooglemap.net"></a>
                                <style>
                                    .gmap_canvas {
                                        overflow: hidden;
                                        background: none !important;
                                        height: 300px;
                                        width: 350px;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__copy-text pt-50 pb-50">
                <a href="index-2.html" class="logo d-block">
                    <img src="client_ui/assets/images/logo/mainlogo.png" alt="logo">
                </a>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" style="padding-left: 50px" data-wow-duration="1.4s" data-wow-delay=".4s">
                    <div class="footer__item newsletter">
                        <div class="social-icon mt-40">
                            <a href="#0"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#0"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#0"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#0"><i class="fa-brands fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <a href="#0" class="payment d-block image">
                    <img src="client_ui/assets/images/icon/payment.png" alt="icon">
                </a>
            </div>
        </div>
</footer>
