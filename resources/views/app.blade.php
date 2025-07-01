<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'تماشای فیلم و سریال با نوین باکس')</title>
    <meta name="description" content="@yield('meta_description', 'نوین باکس، مرجع تماشای آنلاین فیلم، سریال، انیمیشن و مستند با کیفیت عالی و بدون محدودیت.')">
    <meta name="keywords" content="فیلم, سریال, انیمیشن, مستند, پخش آنلاین, تماشای فیلم, نوین باکس, vod">
    <meta name="author" content="نوین باکس">

    <meta name="language" content="fa">
    <meta name="robots" content="index, follow">

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', 'نوین باکس - تماشای فیلم و سریال')">
    <meta property="og:description" content="@yield('og_description', 'آرشیو کامل فیلم‌ها و سریال‌های ایرانی و خارجی با کیفیت بالا')">
    <meta property="og:image" content="@yield('og_image', asset('images/cover.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="نوین باکس">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'نوین باکس - تماشای فیلم و سریال')">
    <meta name="twitter:description" content="@yield('twitter_description', 'با نوین باکس فیلم و سریال ببینید، آنلاین و بی‌وقفه')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/cover.jpg'))">

    <link rel="stylesheet" href="{{ asset('assets/theme/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/all-fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/style.css') }}">

{{--    @vite('resources/css/app.css')--}}

    <link href="{{ asset('assets/css/fonts.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: Vazirmatn;
        }
    </style>
    @stack('head')
</head>
<body class="home-4">

    <div class="preloader d-none">
        <div class="loader-ripple">
            <div></div>
            <div></div>
        </div>
    </div>


@include('layouts.header')


    <main class="main">
        @yield('content')
    </main>


    @include('layouts.footer')

<a href="#" id="scroll-top"><i class="far fa-arrow-up-from-arc"></i></a>

<script src="{{ asset('assets/theme/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/modernizr.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/jquery.appear.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/counter-up.js') }}"></script>
<script src="{{ asset('assets/theme/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/main.js') }}"></script>

@stack('footer')
</body>
</html>
