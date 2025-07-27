@extends('app')

@section('title', 'ورود | نوین باکس')
@section('meta_description', 'تماشای جدیدترین فیلم‌ها و سریال‌ها در نوین باکس با کیفیت بالا و تنوع بی‌نظیر.')

@section('content')

    <div class="profile-area pb-100 pt-50" dir="rtl">
        <div class="container">
            <div class="profile-intro">
                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="intro-left">
                            <div class="intro-img">
                                <img src="{{ auth()->user()->currentProfile()->avatarLink() }}" style="aspect-ratio: 1/1" alt="">
                            </div>
                            <div class="intro-content">
                                <h4>{{ auth()->user()->currentProfile()->name }}</h4>
                                <p>موبایل: {{ auth()->user()->phone }}</p>
                            </div>
                        </div>
                    </div>
{{--                    <div class="col-lg-8 col-xl-8">--}}
{{--                        <div class="intro-right">--}}
{{--                            <div class="intro-item">--}}
{{--                                <div class="intro-content">--}}
{{--                                    <h4 class="intro-amount">۷۹۰,۰۰۰<span>/ماهانه</span></h4>--}}
{{--                                    <p>اکانت پرمیوم</p>--}}
{{--                                </div>--}}
{{--                                <div class="intro-icon">--}}
{{--                                    <i class="icon-subscription"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="intro-item">--}}
{{--                                <div class="intro-content">--}}
{{--                                    <h4>۲۰</h4>--}}
{{--                                    <p>علاقه مندی ها</p>--}}
{{--                                </div>--}}
{{--                                <div class="intro-icon">--}}
{{--                                    <i class="icon-computer-play-1"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="intro-item">--}}
{{--                                <div class="intro-content">--}}
{{--                                    <h4>۴۳۰,۰۰۰</h4>--}}
{{--                                    <p>موجودی حساب</p>--}}
{{--                                </div>--}}
{{--                                <div class="intro-icon">--}}
{{--                                    <i class="icon-money-bag"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="profile-menu">
                    <ul class="nav nav-underline" id="pills-profile-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-profile-tab1" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile1" type="button" role="tab"
                                    aria-controls="pills-profile1" aria-selected="true">اکانت من</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab2" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile2" type="button" role="tab"
                                    aria-controls="pills-profile2" aria-selected="false">علاقه مندی</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab3" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile3" type="button" role="tab"
                                    aria-controls="pills-profile3" aria-selected="false">ویدیوهای دیده شده</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab4" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile4" type="button" role="tab"
                                    aria-controls="pills-profile4" aria-selected="false">تنظیمات</button>
                        </li>
{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <button class="nav-link" id="pills-profile-tab5" data-bs-toggle="pill"--}}
{{--                                    data-bs-target="#pills-profile5" type="button" role="tab"--}}
{{--                                    aria-controls="pills-profile5" aria-selected="false">افزایش موجودی</button>--}}
{{--                        </li>--}}
                        <li class="nav-item ms-auto" role="presentation"  style="margin-right: auto;">
                            <a href="{{ route('logout') }}" class="nav-link" type="button"><i class="far fa-sign-out"></i>خروج</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="profile-menu-content">
                <div class="tab-content" id="profile-pills-tabContent">

                    <div class="tab-pane fade show active" id="pills-profile1" role="tabpanel"
                         aria-labelledby="pills-profile-tab1" tabindex="0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="profile-menu-info">
                                    <div class="profile-details">
                                        <h4 class="title">اطلاعات اکانت</h4>
                                        <table class="table table-borderless">
                                            <tbody>
                                            <tr>
                                                <th>نام</th>
                                                <td>{{ auth()->user()->currentProfile()->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>محدوده سنی</th>
                                                <td>{{ auth()->user()->currentProfile()->ageRange->title }}</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد پروفایل</th>
                                                <td>{{ count(auth()->user()->profiles) }} از {{ auth()->user()->max_profiles }}</td>
                                            </tr>
                                            <tr>
                                                <th>تاریخ ثبت نام</th>
                                                <td>{{ auth()->user()->created_at->diffForHumans() }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="col-lg-6">--}}
{{--                                <div class="profile-menu-info">--}}
{{--                                    <div class="profile-about">--}}
{{--                                        <h4 class="title">درباره من</h4>--}}
{{--                                        <p class="mt-3">--}}
{{--                                            تست--}}
{{--                                        </p>--}}
{{--                                        <p class="mt-2">--}}
{{--                                            تست--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-profile2" role="tabpanel"
                         aria-labelledby="pills-profile-tab2" tabindex="0">

                        @include('pages.listMovies' , ['movies' => auth()->user()->currentProfile()->favorites()->paginate()])
                    </div>

                    <div class="tab-pane fade" id="pills-profile3" role="tabpanel"
                         aria-labelledby="pills-profile-tab3" tabindex="0">


                        @include('pages.listMovies' , ['movies' => \App\Models\Movie\Movie::query()
    ->join('view_histories', 'movies.id', '=', 'view_histories.movie_id')
    ->where('view_histories.profile_id', auth()->user()->currentProfile()->id)
    ->select('movies.*', 'view_histories.last_seconds', 'view_histories.updated_at as last_viewed_at')
    ->orderByDesc('view_histories.updated_at')->paginate()])
                    </div>

                    <div class="tab-pane fade" id="pills-profile4" role="tabpanel"
                         aria-labelledby="pills-profile-tab4" tabindex="0">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="profile-menu-info">
                                    <h4 class="title">اطلاعات اکانت</h4>
                                    <div class="profile-form">
                                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>نام پروفایل</label>
                                                        <input type="text" class="form-control" name="name" value="{{ old('name' , auth()->user()->currentProfile()->name == 'خودم' ? '' : auth()->user()->currentProfile()->name ) }}"
                                                               placeholder="نام پروفایل">
                                                        @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>محدوده سنی</label>
                                                        <select class="form-control" name="age_range_id">
                                                            @foreach(\App\Models\Asset\AgeRange::query()->orderBy('sort')->get() as $ageRange)
                                                                <option value="{{ $ageRange->id }}" @selected( old('age_range_id' , auth()->user()->currentProfile()->age_range_id  ) == $ageRange->id ) >{{ $ageRange->title }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('age_range_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="profile-img">
                                                        <img src="{{ auth()->user()->currentProfile()->avatarLink() }}" id="previewImg" style="aspect-ratio: 1/1" alt="">
                                                        <button class="profile-file-btn" type="button"><i
                                                                class="far fa-camera"></i></button>
                                                        <input type="file" class="profile-file-input" name="avatar" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="position: relative;">
                                                    <button class="theme-btn" type="submit" style="left: 0;bottom: 0;position: absolute;"><span
                                                            class="far fa-save"></span> ذخیره تغییرات</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="profile-menu-info">
                                    <h4 class="title">تغییر پسورد</h4>
                                    <div class="profile-form">
                                        <form action="{{ route('profile.updatePassword') }}" method="POST">
                                            @csrf
                                            @method('put')

                                            <div class="row">

                                                <!-- پسورد فعلی -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>پسورد فعلی</label>
                                                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror"
                                                               placeholder="پسورد فعلی">
                                                        @error('current_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- پسورد جدید -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>پسورد جدید</label>
                                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                               placeholder="پسورد جدید">
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- تایید پسورد -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>تایید پسورد</label>
                                                        <input type="password" name="password_confirmation" class="form-control"
                                                               placeholder="تایید پسورد">
                                                    </div>
                                                </div>

                                                <!-- دکمه ذخیره -->
                                                <div class="col-md-12">
                                                    <button class="theme-btn" type="submit">
                                                        <span class="far fa-key"></span> ذخیره تغییرات
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

{{--                    <div class="tab-pane fade" id="pills-profile5" role="tabpanel"--}}
{{--                         aria-labelledby="pills-profile-tab5" tabindex="0">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-lg-6">--}}
{{--                                <div class="profile-menu-info">--}}
{{--                                    <h4 class="title">خلاصه موجودی</h4>--}}
{{--                                    <div class="row g-4">--}}
{{--                                        <div class="col-md-6 col-lg-12 col-xl-6">--}}
{{--                                            <div class="profile-balance-item">--}}
{{--                                                <div class="profile-balance-info">--}}
{{--                                                    <h3>۲۵۰,۰۰۰</h3>--}}
{{--                                                    <p>موجودی فعلی</p>--}}
{{--                                                </div>--}}
{{--                                                <span class="icon"><i class="fal fa-wallet"></i></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6 col-lg-12 col-xl-6">--}}
{{--                                            <div class="profile-balance-item">--}}
{{--                                                <div class="profile-balance-info">--}}
{{--                                                    <h3>۷۸۰,۰۰۰</h3>--}}
{{--                                                    <p>کل مبلغ خرج</p>--}}
{{--                                                </div>--}}
{{--                                                <span class="icon"><i class="fal fa-sack-dollar"></i></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-6">--}}
{{--                                <div class="profile-menu-info">--}}
{{--                                    <h4 class="title">افزایش موجودی</h4>--}}
{{--                                    <div class="profile-form">--}}
{{--                                        <form action="#">--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-md-12">--}}
{{--                                                    <div class="form-group">--}}
{{--                                                        <label>میزان</label>--}}
{{--                                                        <input type="number" class="form-control"--}}
{{--                                                               placeholder="مبلغ را وارد کنید">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-12">--}}
{{--                                                    <div class="form-check">--}}
{{--                                                        <input class="form-check-input" type="radio" name="method"--}}
{{--                                                               id="method1" checked="">--}}
{{--                                                        <label class="form-check-label" for="method1">--}}
{{--                                                            درگاه آنلاین--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="form-check">--}}
{{--                                                        <input class="form-check-input" type="radio" name="method"--}}
{{--                                                               id="method2">--}}
{{--                                                        <label class="form-check-label" for="method2">--}}
{{--                                                            حواله--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-12">--}}
{{--                                                    <button class="theme-btn" type="submit"><span--}}
{{--                                                            class="far fa-wallet"></span> افزایش موجودی</button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>

@endsection
