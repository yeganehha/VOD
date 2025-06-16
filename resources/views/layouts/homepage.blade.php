@php use App\Repositories\Movie\MovieRepository; @endphp
@extends('app')

@section('title', 'خانه | نوین باکس')
@section('meta_description', 'تماشای جدیدترین فیلم‌ها و سریال‌ها در نوین باکس با کیفیت بالا و تنوع بی‌نظیر.')

@section('content')

    <div class="hero-section">
        <div class="hero-slider owl-carousel owl-theme">
            @foreach(MovieRepository::futureRelease()->lastItems(6) as $item)
            <div class="hero-single" data-entityId="{{ $item->entity_id }}">
                <div class="container h-100">
                    <div class="row align-items-center h-100">
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
                                    <a href="{{ route('movie.short' , $item->id ) }}" class="theme-btn gap-1"><span class="icon-play-3"></span>مشاهده</a>
                                    <a href="{{ route('movie.short' , $item->id ) }}" class="theme-btn theme-btn2">اطلاعات بیشتر</a>
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

    <div class="movie-area pt-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="site-heading-inline">
                        <h2 class="site-title">جدیدترین فیلم ها</h2>
                        <a href="#" class="theme-btn  gap-1">مشاهده همه<i class="far fa-angles-left"></i></a>
                    </div>
                </div>
            </div>
            <div class="movie-slider owl-carousel owl-theme">
                @foreach(MovieRepository::futureRelease()->lastItems(20) as $item)
                <div class="movie-item">
{{--                    <span class="movie-quality">اچ دی</span>--}}
                    <div class="movie-img">
                        <img data-ratio="3/4" style="aspect-ratio: 3 / 4;" data-entityId="{{ $item->entity_id }}" src="https://storage.googleapis.com/proudcity/mebanenc/uploads/2021/03/placeholder-image-300x225.png" alt="{{ $item->title ?? $item->entity->title }}">
                        <a href="{{ route('movie.short' , $item->id ) }}" class="movie-play"><i class="icon-play-3"></i></a>
                    </div>
                    <div class="movie-content">
                        <h6 class="movie-title"><a href="{{ route('movie.short' , $item->id ) }}">{{ $item->title ?? $item->entity->title }}</a></h6>
                        <div class="movie-info">
                            <span class="movie-time">{{ $item->duration }} دقیقه</span>
                            <div class="movie-genre">
                                @foreach($item->entity->genres()->take(3)->get() as $genre)
                                    <a href="{{ route('genre' , ['genre' => $genre->slug]) }}">{{ $genre->title }}</a>
                                    @if (!$loop->last),
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="cta-area pb-60 pt-70">
        <div class="container">
            <div class="cta-wrapper">
                <div class="row align-items-center">
                    <div class="col-lg-7 mx-auto">
                        <div class="cta-content">
                            <h1>دوره آزمایشی رایگان ۳۰ روزه را شروع کنید.</h1>
                            <p>این یک واقعیت ثابت طولانی مدت است که خواننده با محتوای خواندنی پرت می شود.</p>
                            <a href="#" class="theme-btn gap-1">شروع کنید<i class="fas fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="movie-area pt-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="site-heading-inline">
                        <h2 class="site-title">جدیدترین سریال ها</h2>
                        <a href="#" class="theme-btn  gap-1">مشاهده همه<i class="far fa-angles-left"></i></a>
                    </div>
                </div>
            </div>
            <div class="movie-slider owl-carousel owl-theme">
                @foreach(MovieRepository::series()->lastItems(20) as $item)
                <div class="movie-item">
                    <span class="movie-quality">قسمت {{ $item->episode }} @if($item->entity->type == \App\Enums\EntityType::MultiSeasonSeries) فصل {{ $item->season }}@endif </span>
                    <div class="movie-img">
                        <img data-ratio="3/4" style="aspect-ratio: 3 / 4;" data-entityId="{{ $item->entity_id }}" src="https://storage.googleapis.com/proudcity/mebanenc/uploads/2021/03/placeholder-image-300x225.png" alt="{{ $item->title ?? $item->entity->title }}">
                        <a href="{{ route('movie.short' , $item->id ) }}" class="movie-play"><i class="icon-play-3"></i></a>
                    </div>
                    <div class="movie-content">
                        <h6 class="movie-title"><a href="{{ route('movie.short' , $item->id ) }}">{{ $item->title ?? $item->entity->title }}</a></h6>
                        <div class="movie-info">
                            <span class="movie-time">{{ $item->duration }} دقیقه</span>
                            <div class="movie-genre">
                                @foreach($item->entity->genres()->take(3)->get() as $genre)
                                    <a href="{{ route('genre' , ['genre' => $genre->slug]) }}">{{ $genre->title }}</a>
                                    @if (!$loop->last),
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>


    <div class="choose-area bg py-80 mt-70" >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="choose-content wow fadeInUp" data-wow-delay=".25s">
                        <div class="site-heading mb-3">
                            <span class="site-title-tagline">چرا ما را انتخاب کنید ؟</span>
                            <h2 class="site-title">
                                ما به رضایت <span>مشتریان</span> خود اهمیت می دهیم
                            </h2>
                        </div>
                        <p>
                            انواع مختلفی از معابر موجود است اما اکثریت آن ها را دارند
                            با تزریق طنز واژگان تصادفی به شکلی دچار تغییر شده است که اینطور نیست
                            نگاه حتی تمایل به تکرار از پیش تعریف شده کمی باورپذیر است.
                        </p>
                        <div class="choose-wrapper">
                            <div class="choose-item">
                                <div class="choose-icon">
                                    <i class="icon-stream-3"></i>
                                </div>
                                <div class="choose-item-content">
                                    <h4>بهترین پلتفرم استریمینگ</h4>
                                    <p>تنوع زیادی از معابر در دسترس اکثریت وجود دارد
                                        دچار تغییر شوخ طبعی تزریق شده اند.</p>
                                </div>
                            </div>
                            <div class="choose-item">
                                <div class="choose-icon">
                                    <i class="icon-stream-4"></i>
                                </div>
                                <div class="choose-item-content">
                                    <h4>پخش جریانی بدون وقفه</h4>
                                    <p>تنوع‌های زیادی از قسمت‌ها وجود دارد که اکثر آنها در دسترس هستند
                                        دچار تغییر طنز تزریق شده اند.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="choose-img wow fadeInRight" data-wow-delay=".25s">
                        <img src="{{ asset('assets/theme/images/01_1.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="blog-area py-80" dir="rtl">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline">وبلاگ ما</span>
                        <h2 class="site-title">آخرین اخبار ما<span>وبلاگ</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="blog-item wow fadeInUp" data-wow-delay=".25s">
                        <div class="blog-img">
                            <img src="{{ asset('assets/theme/images/01_2.jpg') }}" alt="Thumb">
                            <div class="blog-date" ><i class="fal fa-calendar-alt"></i> ۰۲ خرداد , ۱۴۰۲ </div>
                        </div>
                        <div class="blog-info">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#"><i class="far fa-user-circle"></i> نویسنده محسن دادار</a></li>
                                    <li><a href="#"><i class="far fa-comments"></i> ۰۳ دیدگاه</a></li>
                                </ul>
                            </div>
                            <h4 class="blog-title">
                                <a href="#">بسیاری از تغییرات حقیقت عبور که رنج می برد در دسترس وجود دارد.</a>
                            </h4>
                            <a class="theme-btn" href="#">بیشتر بخوانید<i class="fas fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="blog-item wow fadeInUp" data-wow-delay=".50s">
                        <div class="blog-img">
                            <img src="{{ asset('assets/theme/images/02_1.jpg') }}" alt="Thumb">
                            <div class="blog-date"><i class="fal fa-calendar-alt"></i> ۰۲ تیر , ۱۴۰۲ </div>
                        </div>
                        <div class="blog-info">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#"><i class="far fa-user-circle"></i> نویسنده محسن دادار</a></li>
                                    <li><a href="#"><i class="far fa-comments"></i>۰۳ دیدگاه</a></li>
                                </ul>
                            </div>
                            <h4 class="blog-title">
                                <a href="#">بسیاری از تغییرات حقیقت عبور که رنج می برد در دسترس وجود دارد.</a>
                            </h4>
                            <a class="theme-btn" href="#">بیشتر بخوانید<i class="fas fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="blog-item wow fadeInUp" data-wow-delay=".75s">
                        <div class="blog-img">
                            <img src="{{ asset('assets/theme/images/03_1.jpg') }}" alt="Thumb">
                            <div class="blog-date"><i class="fal fa-calendar-alt"></i> ۰۲ مرداد , ۱۴۰۲ </div>
                        </div>
                        <div class="blog-info">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#"><i class="far fa-user-circle"></i> نویسنده محسن دادار</a></li>
                                    <li><a href="#"><i class="far fa-comments"></i> ۰۳ دیدگاه</a></li>
                                </ul>
                            </div>
                            <h4 class="blog-title">
                                <a href="#">بسیاری از تغییرات حقیقت عبور که رنج می برد در دسترس وجود دارد.</a>
                            </h4>
                            <a class="theme-btn" href="#">بیشتر بخوانید<i class="fas fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
