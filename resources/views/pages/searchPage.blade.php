@extends('app')

@section('title', 'خانه | نوین باکس')
@section('meta_description', 'تماشای جدیدترین فیلم‌ها و سریال‌ها در نوین باکس با کیفیت بالا و تنوع بی‌نظیر.')

@section('content')


    <div class="site-breadcrumb" style="background: url({{ asset('assets/theme/images/01-bg-ganr.jpeg') }})">
        <div class="container">
            <h2 class="breadcrumb-title"></h2>
        </div>
    </div>

    @include('pages.searchBox' , ['values' => $tags])

    @include('pages.listMovies' , ['movies' => $movies])

@endsection
