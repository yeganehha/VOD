@extends('app')

@section('title', 'خانه | نوین باکس')
@section('meta_description', 'تماشای جدیدترین فیلم‌ها و سریال‌ها در نوین باکس با کیفیت بالا و تنوع بی‌نظیر.')

@section('content')

    <div class="site-breadcrumb" data-entityId="{{ $movie->entity_id }}" >
        <div class="container">
            <h2 class="breadcrumb-title">پخش تلوزیون تک</h2>
            <ul class="breadcrumb-menu">
                <li><a href="index.html">خانه</a></li>
                <li class="active">پخش تلوزیون تک</li>
            </ul>
        </div>
    </div>


    <div class="movie-single py-80" dir="rtl">
        <div class="container">

            <div class="movie-single-content mt-20">
                <div class="row">
                    <div class="col-md-4 col-lg-3">
                        <div class="movie-img">
                            <img src="images/s8.jpg" alt="">
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-6 border-end">
                        <div class="movie-info">
                            <h4 class="movie-name">
                                چیزهای عجیب
                                <a href="https://www.youtube.com/watch?v=ckHzmP1evNU"
                                   class="theme-btn popup-youtube"><span
                                        class="fas fa-video"></span>تریلر</a>
                            </h4>
                            <p>
                                این یک واقعیت ثابت شده است که خواننده از خواندنی ها حواسش پرت می شود
                                صفحه محتوا وقتی به طرح بندی آن نگاه می کنید. نکته استفاده از این است
                                بر خلاف استفاده از حروف، توزیع کم و بیش عادی حروف دارد
                                محتوایی که در اینجا وجود دارد که آن را شبیه به انگلیسی خواندنی می کند.
                            </p>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="movie-info-item">
                                        <strong>ژانر:</strong>
                                        <a href="#">اکشن,</a>
                                        <a href="#">جنایی,</a>
                                        <a href="#">فانتزی,</a>
                                        <a href="#">درام</a>
                                    </div>
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
                                    <div class="movie-info-item">
                                        <strong>کشور:</strong>
                                        <a href="#">آمریکا</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="movie-info-item">
                                        <strong>مدت زمان:</strong>
                                        <span>۲ ساعت ۳۰ دقیقه</span>
                                    </div>
                                    <div class="movie-info-item">
                                        <strong>کیفیت:</strong>
                                        <span class="quality">اچ دی</span>
                                    </div>
                                    <div class="movie-info-item">
                                        <strong>سال تولید:</strong>
                                        <a href="#">۲۰۲۳</a>
                                    </div>
                                    <div class="movie-info-item">
                                        <strong>ای ام دی بی:</strong>
                                        <span class="rating">۹.۷</span>
                                    </div>
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
