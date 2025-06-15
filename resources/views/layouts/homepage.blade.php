@php use App\Repositories\Movie\MovieRepository; @endphp
@extends('app')

@section('title', 'خانه | نوین باکس')
@section('meta_description', 'تماشای جدیدترین فیلم‌ها و سریال‌ها در نوین باکس با کیفیت بالا و تنوع بی‌نظیر.')

@section('content')

    <div class="hero-section">
        <div class="hero-slider owl-carousel owl-theme">
            @foreach(MovieRepository::futureRelease()->lastItems(6) as $item)
            <div class="hero-single" style="background: url('{{ $item->entity->covers->first()->path_link }}')">
                <div class="container">
                    <div class="row align-items-center" dir="rtl">
                        <div class="col-md-8 col-lg-6">
                            <div class="hero-content">
                                @if($item->entity->pre_title)
                                <h6 class="hero-sub-title" data-animation="fadeInDown" data-delay=".25s">
                                    {{ $item->entity->pre_title }}
                                </h6>
                                @endif
                                <h1 class="hero-title" data-animation="fadeInLeft" data-delay=".50s">
                                    {{ $item->title ?? $item->entity->title }}
                                </h1>
                                <div class="hero-info" data-animation="fadeInDown" data-delay=".75s">
                                    <span class="rating"><span><i class="far fa-star"></i> {{ $item->imdb_rate }}</span>IMDB</span>
                                    <span class="year">{{ $item->pro_year }}</span>
                                    <span class="time">{{ $item->duration }} دقیقه</span>
                                    <div class="genre">
                                        @foreach($item->entity->genres()->take(3)->get() as $genre)
                                            <a href="{{ route('genre' , ['genre' => $genre->slug]) }}">{{ $genre->title }}</a>
                                            @if (!$loop->last),
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <p data-animation="fadeInRight" data-delay="1s">
                                    {{ $item->description ?? $item->entity->description }}
                                </p>
                                <div class="hero-btn" data-animation="fadeInUp" data-delay="1.25s">
                                    <a href="#" class="theme-btn"><span class="icon-play-3"></span>مشاهده</a>
                                    <a href="#" class="theme-btn theme-btn2">اطلاعات بیشتر</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-6">
                            <div class="hero-video" data-animation="fadeInLeft" data-delay=".25s">
{{--                                <a href="https://www.youtube.com/watch?v=ckHzmP1evNU"--}}
{{--                                   class="hero-video-btn popup-youtube">--}}
{{--                                    <span class="video-icon"><i class="icon-play-4"></i></span>--}}
{{--                                    <span class="video-text">مشاهده تریلر</span>--}}
{{--                                </a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

@endsection
