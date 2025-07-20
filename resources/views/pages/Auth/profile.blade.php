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
                                <img src="{{ auth()->user()->currentProfile()->avatarLink() }}" alt="">
                            </div>
                            <div class="intro-content">
                                <h4>{{ auth()->user()->currentProfile()->name }}</h4>
                                <p>موبایل: {{ auth()->user()->phone }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-8">
                        <div class="intro-right">
                            <div class="intro-item">
                                <div class="intro-content">
                                    <h4 class="intro-amount">۷۹۰,۰۰۰<span>/ماهانه</span></h4>
                                    <p>اکانت پرمیوم</p>
                                </div>
                                <div class="intro-icon">
                                    <i class="icon-subscription"></i>
                                </div>
                            </div>
                            <div class="intro-item">
                                <div class="intro-content">
                                    <h4>۲۰</h4>
                                    <p>علاقه مندی ها</p>
                                </div>
                                <div class="intro-icon">
                                    <i class="icon-computer-play-1"></i>
                                </div>
                            </div>
                            <div class="intro-item">
                                <div class="intro-content">
                                    <h4>۴۳۰,۰۰۰</h4>
                                    <p>موجودی حساب</p>
                                </div>
                                <div class="intro-icon">
                                    <i class="icon-money-bag"></i>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                    aria-controls="pills-profile3" aria-selected="false">اعلانات <span
                                    class="badge">۰۲</span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab4" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile4" type="button" role="tab"
                                    aria-controls="pills-profile4" aria-selected="false">تنظیمات</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab5" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile5" type="button" role="tab"
                                    aria-controls="pills-profile5" aria-selected="false">افزایش موجودی</button>
                        </li>
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
                                                <td>یلدا نوبخت</td>
                                            </tr>
                                            <tr>
                                                <th>ایمیل</th>
                                                <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                       data-cfemail="066b69746f6846637e676b766a632865696b">[email�&nbsp;protected]</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>شماره همراه</th>
                                                <td>+۹۸ ۹۳۵ ۷۶۰ ۵۴۴۵</td>
                                            </tr>
                                            <tr>
                                                <th>آیدی موپلی</th>
                                                <td>۱۲۳۴۵۶</td>
                                            </tr>
                                            <tr>
                                                <th>تاریخ ثبت نام</th>
                                                <td>۲۷ مهر, ۱۴۰۳</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="profile-menu-info">
                                    <div class="profile-about">
                                        <h4 class="title">درباره من</h4>
                                        <p class="mt-3">
                                            این یک واقعیت ثابت شده است که حواس خواننده از این موضوع پرت می شود
                                            محتوای قابل خواندن یک صفحه هنگام مشاهده طرح بندی آن. نکته از
                                            استفاده كردن
                                            این است که توزیع نرمال کم و بیش دارد
                                            حروف، به عنوان
                                            مخالف استفاده از محتوا در اینجا محتوایی است که به نظر خواندنی می رسد
                                            انگلیسی.
                                        </p>
                                        <p class="mt-2">
                                            انواع مختلفی از معابر موجود است، اما
                                            اکثریت دچار تغییراتی به شکلی شده اند، با شوخ طبعی تزریقی، یا
                                            کلمات تصادفی که حتی کمی باورپذیر به نظر نمی رسند.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-profile2" role="tabpanel"
                         aria-labelledby="pills-profile-tab2" tabindex="0">

                        @include('pages.listMovies' , ['movies' => auth()->user()->currentProfile()->favorites()->paginate()])
                    </div>

                    <div class="tab-pane fade" id="pills-profile3" role="tabpanel"
                         aria-labelledby="pills-profile-tab3" tabindex="0">
                        <div class="profile-menu-info">
                            <div class="profile-notification">
                                <h4 class="title">اعلانات</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th>#شماره</th>
                                            <th>آیکون</th>
                                            <th>اعلانات</th>
                                            <th>وضعیت</th>
                                            <th>عملکرد</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>۰۱</td>
                                            <td>
                                                <span class="icon"><i class="far fa-bell"></i></span>
                                            </td>
                                            <td>
                                                <p>این یک واقعیت ثابت است که یک خواننده خواهد بود
                                                    پریشان.</p>
                                            </td>
                                            <td><span class="badge badge-success">خواندن</span></td>
                                            <td>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-secondary rounded-2"><i
                                                        class="far fa-eye"></i></a>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-danger rounded-2 ms-1"><i
                                                        class="far fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>۰۲</td>
                                            <td>
                                                <span class="icon"><i class="far fa-bell"></i></span>
                                            </td>
                                            <td>
                                                <p>این یک واقعیت ثابت است که یک خواننده خواهد بود
                                                    پریشان</p>
                                            </td>
                                            <td><span class="badge badge-danger">جدید</span></td>
                                            <td>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-secondary rounded-2"><i
                                                        class="far fa-eye-slash"></i></a>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-danger rounded-2 ms-1"><i
                                                        class="far fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>۰۳</td>
                                            <td>
                                                <span class="icon"><i class="far fa-bell"></i></span>
                                            </td>
                                            <td>
                                                <p>این یک واقعیت ثابت است که یک خواننده خواهد بود
                                                    پریشان.</p>
                                            </td>
                                            <td><span class="badge badge-danger">جدید</span></td>
                                            <td>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-secondary rounded-2"><i
                                                        class="far fa-eye-slash"></i></a>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-danger rounded-2 ms-1"><i
                                                        class="far fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>۰۴</td>
                                            <td>
                                                <span class="icon"><i class="far fa-bell"></i></span>
                                            </td>
                                            <td>
                                                <p>این یک واقعیت ثابت است که یک خواننده خواهد بود
                                                    پریشان</p>
                                            </td>
                                            <td><span class="badge badge-danger">جدید</span></td>
                                            <td>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-secondary rounded-2"><i
                                                        class="far fa-eye-slash"></i></a>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-danger rounded-2 ms-1"><i
                                                        class="far fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>۰۵</td>
                                            <td>
                                                <span class="icon"><i class="far fa-bell"></i></span>
                                            </td>
                                            <td>
                                                <p>این یک واقعیت ثابت است که یک خواننده خواهد بود
                                                    پریشان</p>
                                            </td>
                                            <td><span class="badge badge-success">خواندن</span></td>
                                            <td>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-secondary rounded-2"><i
                                                        class="far fa-eye"></i></a>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-danger rounded-2 ms-1"><i
                                                        class="far fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>۰۶</td>
                                            <td>
                                                <span class="icon"><i class="far fa-bell"></i></span>
                                            </td>
                                            <td>
                                                <p>این یک واقعیت ثابت است که یک خواننده خواهد بود
                                                    پریشان</p>
                                            </td>
                                            <td><span class="badge badge-danger">جدید</span></td>
                                            <td>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-secondary rounded-2"><i
                                                        class="far fa-eye-slash"></i></a>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-danger rounded-2 ms-1"><i
                                                        class="far fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>۰۷</td>
                                            <td>
                                                <span class="icon"><i class="far fa-bell"></i></span>
                                            </td>
                                            <td>
                                                <p>این یک واقعیت ثابت است که یک خواننده خواهد بود
                                                    پریشان</p>
                                            </td>
                                            <td><span class="badge badge-danger">جدید</span></td>
                                            <td>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-secondary rounded-2"><i
                                                        class="far fa-eye-slash"></i></a>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-danger rounded-2 ms-1"><i
                                                        class="far fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>۰۸</td>
                                            <td>
                                                <span class="icon"><i class="far fa-bell"></i></span>
                                            </td>
                                            <td>
                                                <p>این یک واقعیت ثابت است که یک خواننده خواهد بود
                                                    پریشان</p>
                                            </td>
                                            <td><span class="badge badge-danger">جدید</span></td>
                                            <td>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-secondary rounded-2"><i
                                                        class="far fa-eye-slash"></i></a>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-danger rounded-2 ms-1"><i
                                                        class="far fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>۰۹</td>
                                            <td>
                                                <span class="icon"><i class="far fa-bell"></i></span>
                                            </td>
                                            <td>
                                                <p>این یک واقعیت ثابت است که یک خواننده خواهد بود
                                                    پریشان</p>
                                            </td>
                                            <td><span class="badge badge-success">خواندن</span></td>
                                            <td>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-secondary rounded-2"><i
                                                        class="far fa-eye"></i></a>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-danger rounded-2 ms-1"><i
                                                        class="far fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>۱۰</td>
                                            <td>
                                                <span class="icon"><i class="far fa-bell"></i></span>
                                            </td>
                                            <td>
                                                <p>این یک واقعیت ثابت است که یک خواننده خواهد بود
                                                    پریشان</p>
                                            </td>
                                            <td><span class="badge badge-danger">جدید</span></td>
                                            <td>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-secondary rounded-2"><i
                                                        class="far fa-eye-slash"></i></a>
                                                <a href="#"
                                                   class="btn btn-sm btn-outline-danger rounded-2 ms-1"><i
                                                        class="far fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="pagination-area mt-40">
                            <div aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                                        </a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">۱</a></li>
                                    <li class="page-item"><a class="page-link" href="#">۲</a></li>
                                    <li class="page-item"><span class="page-link">...</span></li>
                                    <li class="page-item"><a class="page-link" href="#">۳</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true"><i class="fas fa-arrow-left"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="pills-profile4" role="tabpanel"
                         aria-labelledby="pills-profile-tab4" tabindex="0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="profile-menu-info">
                                    <h4 class="title">اطلاعات اکانت</h4>
                                    <div class="profile-form">
                                        <form action="#">
                                            <div class="profile-img">
                                                <img src="images/profile.jpeg" alt="">
                                                <button class="profile-file-btn" type="button"><i
                                                        class="far fa-camera"></i></button>
                                                <input type="file" class="profile-file-input">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>نام</label>
                                                        <input type="text" class="form-control" value="یلدا"
                                                               placeholder="اسم">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>نام خانوادگی</label>
                                                        <input type="text" class="form-control" value="نوبخت"
                                                               placeholder="فامیل">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>ایمیل</label>
                                                        <input type="email" class="form-control"
                                                               value="morin@example.com" placeholder="ایمیل شما">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>شماره تماس</label>
                                                        <input type="text" class="form-control" style="text-align: right;"
                                                               value="+۹۸ ۹۳۵ ۷۶۰ ****" placeholder="شماره همراه">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>درباره من</label>
                                                        <textarea cols="30" rows="4" class="form-control"
                                                                  placeholder="در مورد شما">این یک واقعیت ثابت شده است که خواننده هنگام تماشای طرح بندی آن، با محتوای قابل خواندن یک صفحه، حواسش پرت می شود.</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="theme-btn" type="submit"><span
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
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>پسورد فعلی</label>
                                                        <input type="password" class="form-control"
                                                               placeholder="پسورد فعلی">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>پسورد جدید</label>
                                                        <input type="password" class="form-control"
                                                               placeholder="پسورد جدید">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>تایید پسورد</label>
                                                        <input type="password" class="form-control"
                                                               placeholder="تایید پسورد">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="theme-btn" type="submit"><span
                                                            class="far fa-key"></span> دخیره تغییرات</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-profile5" role="tabpanel"
                         aria-labelledby="pills-profile-tab5" tabindex="0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="profile-menu-info">
                                    <h4 class="title">خلاصه موجودی</h4>
                                    <div class="row g-4">
                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                            <div class="profile-balance-item">
                                                <div class="profile-balance-info">
                                                    <h3>۲۵۰,۰۰۰</h3>
                                                    <p>موجودی فعلی</p>
                                                </div>
                                                <span class="icon"><i class="fal fa-wallet"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                            <div class="profile-balance-item">
                                                <div class="profile-balance-info">
                                                    <h3>۷۸۰,۰۰۰</h3>
                                                    <p>کل مبلغ خرج</p>
                                                </div>
                                                <span class="icon"><i class="fal fa-sack-dollar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="profile-menu-info">
                                    <h4 class="title">افزایش موجودی</h4>
                                    <div class="profile-form">
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>میزان</label>
                                                        <input type="number" class="form-control"
                                                               placeholder="مبلغ را وارد کنید">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="method"
                                                               id="method1" checked="">
                                                        <label class="form-check-label" for="method1">
                                                            درگاه آنلاین
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="method"
                                                               id="method2">
                                                        <label class="form-check-label" for="method2">
                                                            حواله
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="theme-btn" type="submit"><span
                                                            class="far fa-wallet"></span> افزایش موجودی</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
