@extends('app')

@section('title', 'خانه | نوین باکس')
@section('meta_description', 'تماشای جدیدترین فیلم‌ها و سریال‌ها در نوین باکس با کیفیت بالا و تنوع بی‌نظیر.')

@section('content')

    <div class="site-breadcrumb" data-entityId="{{ $movie->entity_id }}" >
        <div class="container">
{{--            <h2 class="breadcrumb-title">{{ $movie->entity->pre_title }} {{ $movie->title ?? $movie->entity->title }}</h2>--}}
        </div>
    </div>


    <div class="movie-single" dir="rtl">
        <div class="container">

            <div class="movie-single-content">
                <div class="row">
                    <div class="col-md-4 col-lg-3">
                        <div class="movie-img">
                            <img style="width: 100%;aspect-ratio: 3/4" data-ratio="3/4" data-movieId="{{ $movie->id }}" alt="{{ $movie->entity->pre_title }} {{ $movie->title ?? $movie->entity->title }}">
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-6 border-end">
                        <div class="movie-info">
                            <h4 class="movie-name d-flex justify-items-center">
                                {{ $movie->entity->pre_title }} {{ $movie->title ?? $movie->entity->title }}
                                @if( in_array($movie->entity->type , [\App\Enums\EntityType::MultiSeasonSeries , \App\Enums\EntityType::Series]) )
                                <div style="width: fit-content;" class="theme-btn popup-youtube"><span
                                        class="fas fa-video"></span>
                                    قسمت {{ $movie->episode }} @if($movie->entity->type == \App\Enums\EntityType::MultiSeasonSeries) فصل {{ $movie->season }}@endif
                                </div>
                                @endif
                            </h4>
                            <p>
                                {{ $movie->description ?? $movie->entity->about_movie }}
                            </p>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    @if(count($movie->entity->genres) > 0 )
                                    <div class="movie-info-item">
                                        <strong>ژانر:</strong>
                                        @foreach($movie->entity->genres as $genre)
                                            <a href="{{ route('genre' , ['genre' => $genre->slug]) }}">{{ $genre->title }}</a>
                                            @if (!$loop->last),
                                            @endif
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="movie-info-item">
                                        <strong>کارگردان:</strong>
                                        <a href="#">نیما نوبخت</a>
                                    </div>
                                    <div class="movie-info-item">
                                        <strong>بازیگران:</strong>
                                        <a href="#">دیکاپریو,</a>
                                        <a href="#">تام کروز,</a>
                                        <a href="#">آنجلینا جولی,</a>
                                        <a href="#">آنتونی روبرت</a>
                                    </div>
                                    @if(count($movie->entity->countries) > 0 )
                                        <div class="movie-info-item">
                                            <strong>کشور:</strong>
                                            @foreach($movie->entity->countries as $country)
                                                <a href="{{ route('country' , ['code' => $country->code , 'title' => str()->slug($country->title_en)]) }}">{{ $country->title }}</a>
                                                @if (!$loop->last),
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="movie-info-item">
                                        <strong>مدت زمان:</strong>
                                        <span>{{ $movie->durationTitle() }}</span>
                                    </div>
                                    <div class="movie-info-item">
                                        <strong>کیفیت:</strong>
                                        <span class="quality">اچ دی</span>
                                    </div>
                                    @if($movie->pro_year ?? $movie->entity->pro_year)
                                    <div class="movie-info-item">
                                        <strong>سال تولید:</strong>
                                        <a href="{{ route('year' , ['year' => $movie->pro_year ?? $movie->entity->pro_year]) }}">{{ $movie->pro_year ?? $movie->entity->pro_year }}</a>
                                    </div>
                                    @endif
                                    @if($movie->imdb_rate)
                                    <div class="movie-info-item">
                                        <strong>ای ام دی بی:</strong>
                                        <span class="rating">{{ $movie->imdb_rate }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-3">
                        <div class="movie-download">
                            <h5>دانلود:</h5>
                            <a href="#" class="theme-btn"><span
                                    class="fas fa-arrow-down-to-arc"></span>دانلود: 576p</a>
                            <a href="#" class="theme-btn"><span
                                    class="fas fa-arrow-down-to-arc"></span>دانلود: 720p</a>
                            <a href="#" class="theme-btn"><span
                                    class="fas fa-arrow-down-to-arc"></span>دانلود: 1080p</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="movie-keyword">
                            <span>کلمه کلیدی :</span>
                            <a href="#">مشاهده</a>
                            <a href="#">استریم</a>
                            <a href="#">اکشن</a>
                            <a href="#">۲۰۲۳</a>
                            <a href="#">دانود اچ دی</a>
                            <a href="#">جنایی</a>
                            <a href="#">دران</a>
                            <a href="#">فیلم اچ دی</a>
                            <a href="#">استریم اچ دی</a>
                            <a href="#">فیلم جدید</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
