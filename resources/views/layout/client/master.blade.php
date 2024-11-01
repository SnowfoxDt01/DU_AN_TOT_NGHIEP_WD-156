<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from gramentheme.com/html/odor/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Oct 2024 10:00:31 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VSNK SHOP</title>
    <base href="{{asset('')}}">
    <!-- Favicon img -->
    <link rel="shortcut icon" href="client_ui/assets/images/logo/favicon.png">
    <!-- Bootstarp min css -->
    <link rel="stylesheet" href="client_ui/assets/css/bootstrap.min.css">
    <!-- All min css -->
    <link rel="stylesheet" href="client_ui/assets/css/all.min.css">
    <!-- Swiper bundle min css -->
    <link rel="stylesheet" href="client_ui/assets/css/swiper-bundle.min.css">
    <!-- Magnigic popup css -->
    <link rel="stylesheet" href="client_ui/assets/css/magnific-popup.css">
    <!-- Animate css -->
    <link rel="stylesheet" href="client_ui/assets/css/animate.css">
    <!-- Nice select css -->
    <link rel="stylesheet" href="client_ui/assets/css/nice-select.css">
    <!-- Style css -->
    <link rel="stylesheet" href="client_ui/assets/css/style.css">
</head>

<body>
    @include('layout.client.header')

    <!-- Preloader area start -->
    <div class="loading">
        <span class="text-capitalize">Đ</span>
        <span>A</span>
        <span>N</span>
        <span>G</span>
        <span></span>
        <span>T</span>
        <span>Ả</span>
        <span>I</span>
        <span>.</span>
        <span>.</span>
        <span>.</span>
    </div>

    <div id="preloader">
    </div>
    <!-- Preloader area end -->

    <!-- Mouse cursor area start here -->
    <div class="mouse-cursor cursor-outer"></div>
    <div class="mouse-cursor cursor-inner"></div>
    <!-- Mouse cursor area end here -->

    <main>
        @yield('content')
    </main>

    <!-- Footer area start here -->
    @include('layout.client.footer')
    <!-- Footer area end here -->

    <!-- Back to top area start here -->
    <div class="scroll-up">
        <svg class="scroll-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- Back to top area end here -->

    <!-- Jquery 3. 7. 1 Min Js -->
    <script src="client_ui/assets/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap min Js -->
    <script src="client_ui/assets/js/bootstrap.min.js"></script>
    <!-- Swiper bundle min Js -->
    <script src="client_ui/assets/js/swiper-bundle.min.js"></script>
    <!-- Counterup min Js -->
    <script src="client_ui/assets/js/jquery.counterup.min.js"></script>
    <!-- Wow min Js -->
    <script src="client_ui/assets/js/wow.min.js"></script>
    <!-- Magnific popup min Js -->
    <script src="client_ui/assets/js/magnific-popup.min.js"></script>
    <!-- Nice select min Js -->
    <script src="client_ui/assets/js/nice-select.min.js"></script>
    <!-- Pace min Js -->
    <script src="client_ui/assets/js/pace.min.js"></script>
    <!-- Isotope pkgd min Js -->
    <script src="client_ui/assets/js/isotope.pkgd.min.js"></script>
    <!-- Waypoints Js -->
    <script src="client_ui/assets/js/jquery.waypoints.js"></script>
    <!-- Script Js -->
    <script src="client_ui/assets/js/script.js"></script>
</body>


<!-- Mirrored from gramentheme.com/html/odor/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Oct 2024 10:01:14 GMT -->

</html>
