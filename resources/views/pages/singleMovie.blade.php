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
{{--                                    <div class="movie-info-item">--}}
{{--                                        <strong>کارگردان:</strong>--}}
{{--                                        <a href="#">نیما نوبخت</a>--}}
{{--                                    </div>--}}
{{--                                    <div class="movie-info-item">--}}
{{--                                        <strong>بازیگران:</strong>--}}
{{--                                        <a href="#">دیکاپریو,</a>--}}
{{--                                        <a href="#">تام کروز,</a>--}}
{{--                                        <a href="#">آنجلینا جولی,</a>--}}
{{--                                        <a href="#">آنتونی روبرت</a>--}}
{{--                                    </div>--}}
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
                                <div class="col-md-12">
                                    @if(($movie->main_audio ?? $movie->entity->main_audio) or (! in_array($movie->main_audio ?? $movie->entity->main_audio , [\App\Enums\Audio::Persian]) and $movie->dubbed ) or $movie->is_multi_audio or $movie->has_subtitle )
                                        <div class="movie-info-item">
                                            <strong>زبان:</strong>
                                            @if($movie->main_audio ?? $movie->entity->main_audio)
                                            <span class="quality1">{{ $movie->main_audio?->getLabel() ?? $movie->entity->main_audio?->getLabel() }}</span>
                                            @endif
                                            @if( ! in_array($movie->main_audio ?? $movie->entity->main_audio , [\App\Enums\Audio::Persian]) and $movie->dubbed )
                                                <span class="quality">دوبله شده</span>
                                            @endif
                                            @if( $movie->is_multi_audio )
                                                <span class="quality1">چند زبانه</span>
                                            @endif
                                            @if( $movie->has_subtitle )
                                                <span class="quality1">همراه با زیر نویس</span>
                                            @endif
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

            @if(in_array($movie->entity->type , collect(\App\Enums\EntityType::cases())->filter(fn($item) => $item->isMultiEpisode())->toArray() ) )
            <div class="season-wrap">
                @if($movie->entity->type == \App\Enums\EntityType::MultiSeasonSeries)
                <ul class="nav nav-pills" id="season-pills-tab" role="tablist">
                    @for($season = 1 ; $season <= $movie->entity->movies()->max('season') ; $season++)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $movie->season == $season ? 'active' : '' }}" id="pills-season-tab{{$season}}" data-bs-toggle="pill"
                                data-bs-target="#pills-season{{$season}}" type="button" role="tab"
                                aria-controls="pills-season{{$season}}" aria-selected="{{ $movie->season == $season ? 'true' : 'false' }}">فصل {{ $season }}</button>
                    </li>
                    @endfor
                </ul>
                @endif
                <div class="tab-content" id="season-pills-tabContent">
                    @for($season = 1 ; $season <= $movie->entity->movies()->max('season') ; $season++)
                    <div class="tab-pane fade {{ $movie->season == $season ? 'show active' : '' }}" id="pills-season1" role="tabpanel"
                         aria-labelledby="pills-season-tab{{$season}}" tabindex="{{$season - 1}}">
                        <div class="season-content">
                            <div class="row">

                                @foreach($movie->entity->movies()->where('publish_date' , '<=', now()->addDays(7))->whereHas('entity' , fn($builder) => $builder->where('publish_status' , \App\Enums\PublishStatus::Publish->value))->where('season' , $season)->orderBy('episode')->get() as $episode)
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="movie-item">
                                        <div class="movie-img">
                                            <img style="width: 100%;min-height: 170px" data-movieId="{{ $episode->id }}" src="https://storage.googleapis.com/proudcity/mebanenc/uploads/2021/03/placeholder-image-300x225.png" alt="قسمت
                                                {{ $episode->episode }} {{ $episode->title }}">
                                            <a href="{{ route('movie.short' , $episode->id ) }}" class="movie-play"><i class="icon-play-4"></i></a>
                                        </div>
                                        <div class="movie-content">
                                            <h6 class="movie-title"><a href="{{ route('movie.short' , $episode->id ) }}">قسمت
                                                    {{ $episode->episode }} {{ $episode->season }} {{ $episode->title }}</a></h6>
                                            <div class="movie-info">
                                                <span class="movie-season">۱{{ $episode->durationTitle() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endfor
            </div>
            @endif

        </div>
    </div>
@endsection
