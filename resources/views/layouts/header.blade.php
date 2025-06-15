<header class="header" dir="rtl">
    <div class="main-navigation">
        <nav class="navbar navbar-expand-lg">
            <div class="container position-relative">
                <a class="navbar-brand" href="index.html">
                    <img src="{{ asset('assets/images/logo.png') }}" class="logo-dark-mode" alt="">
                    <img src="{{ asset('assets/images/logo-dark.png') }}" class="logo-light-mode" alt="">
                </a>
                <div class="mobile-menu-right">
                    <div class="nav-search-wrap">
                        <div class="search-btn">
                            <button type="button" class="nav-right-link search-box-outer"><i
                                    class="icon-search"></i></button>
                        </div>

                        <div class="search-area">
                            <form action="#">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="کلمه را وارد کنید...">
                                    <button type="submit" class="search-icon-btn"><i
                                            class="icon-search"></i></button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="color-mode theme-mode-control">
                        <button type="button" class="nav-right-link light-btn"><i class="icon-sun"></i></button>
                        <button type="button" class="nav-right-link dark-btn"><i class="icon-moon-2"></i></button>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-mobile-icon"><i class="icon-menu-2"></i></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="main_nav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('home')) active @endif" href="{{ route('home') }}" data-bs-toggle="dropdown">خانه</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">ژانر</a>
                            <div class="dropdown-menu mega-menu fade-down">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a class="dropdown-item" href="movie-category.html">اکشن</a>
                                        <a class="dropdown-item" href="movie-category.html">انیمیشن</a>
                                        <a class="dropdown-item" href="movie-category.html">ماجراجویی</a>
                                        <a class="dropdown-item" href="movie-category.html">بیوگرافی</a>
                                        <a class="dropdown-item" href="movie-category.html">کمدی</a>
                                        <a class="dropdown-item" href="movie-category.html">جنایی</a>
                                        <a class="dropdown-item" href="movie-category.html">مستند</a>
                                        <a class="dropdown-item" href="movie-category.html">درام</a>
                                        <a class="dropdown-item" href="movie-category.html">خانوادگی</a>
                                    </div>
                                    <div class="col-lg-4">
                                        <a class="dropdown-item" href="movie-category.html">فانتزی</a>
                                        <a class="dropdown-item" href="movie-category.html">نمایش بازی</a>
                                        <a class="dropdown-item" href="movie-category.html">تاریخچه</a>
                                        <a class="dropdown-item" href="movie-category.html">وحشتناک</a>
                                        <a class="dropdown-item" href="movie-category.html">کونگ فو</a>
                                        <a class="dropdown-item" href="movie-category.html">موسیقی</a>
                                        <a class="dropdown-item" href="movie-category.html">موسیقی</a>
                                        <a class="dropdown-item" href="movie-category.html">معمایی</a>
                                        <a class="dropdown-item" href="movie-category.html">اساطیری</a>
                                    </div>
                                    <div class="col-lg-4">
                                        <a class="dropdown-item" href="movie-category.html">اخبار</a>
                                        <a class="dropdown-item" href="movie-category.html">روانی</a>
                                        <a class="dropdown-item" href="movie-category.html">عاشقانه</a>
                                        <a class="dropdown-item" href="movie-category.html">علمی تخیلی</a>
                                        <a class="dropdown-item" href="movie-category.html">ورزش</a>
                                        <a class="dropdown-item" href="movie-category.html">ریلی شو</a>
                                        <a class="dropdown-item" href="movie-category.html">هیجان انگیز</a>
                                        <a class="dropdown-item" href="movie-category.html">نمایش تلویزیونی</a>
                                        <a class="dropdown-item" href="movie-category.html">جنگ</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">کشور</a>
                            <div class="dropdown-menu mega-menu fade-down">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a class="dropdown-item" href="movie-country.html">ایران</a>
                                        <a class="dropdown-item" href="movie-country.html">استرالیا</a>
                                        <a class="dropdown-item" href="movie-country.html">اتریش</a>
                                        <a class="dropdown-item" href="movie-country.html">بلژیک</a>
                                        <a class="dropdown-item" href="movie-country.html">برزیل</a>
                                        <a class="dropdown-item" href="movie-country.html">کانادا</a>
                                        <a class="dropdown-item" href="movie-country.html">چین</a>
                                        <a class="dropdown-item" href="movie-country.html">جمهوری چک</a>
                                        <a class="dropdown-item" href="movie-country.html">دانمارک</a>
                                    </div>
                                    <div class="col-lg-4">
                                        <a class="dropdown-item" href="movie-country.html">فنلاند</a>
                                        <a class="dropdown-item" href="movie-country.html">فرانسه</a>
                                        <a class="dropdown-item" href="movie-country.html">آلمان</a>
                                        <a class="dropdown-item" href="movie-country.html">هنگ کنگ</a>
                                        <a class="dropdown-item" href="movie-country.html">مجارستان</a>
                                        <a class="dropdown-item" href="movie-country.html">ایرلند</a>
                                        <a class="dropdown-item" href="movie-country.html">ایتالیا</a>
                                        <a class="dropdown-item" href="movie-country.html">ژاپن</a>
                                        <a class="dropdown-item" href="movie-country.html">مکزیک</a>
                                    </div>
                                    <div class="col-lg-4">
                                        <a class="dropdown-item" href="movie-country.html">هلند</a>
                                        <a class="dropdown-item" href="movie-country.html">نروژ</a>
                                        <a class="dropdown-item" href="movie-country.html">لهستان</a>
                                        <a class="dropdown-item" href="movie-country.html">رومانی</a>
                                        <a class="dropdown-item" href="movie-country.html">روسیه</a>
                                        <a class="dropdown-item" href="movie-country.html">اسپانیا</a>
                                        <a class="dropdown-item" href="movie-country.html">تایلند</a>
                                        <a class="dropdown-item" href="movie-country.html">بریتانیا</a>
                                        <a class="dropdown-item" href="movie-country.html">ایالات متحده آمریکا</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">صفحات</a>
                            <ul class="dropdown-menu fade-down">
                                <li><a class="dropdown-item" href="about.html">درباره ما</a></li>
                                <li><a class="dropdown-item" href="team.html">تیم ما</a></li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">وبلاگ</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="blog.html">وبلاگ</a></li>
                                        <li><a class="dropdown-item" href="blog-single.html">وبلاگ تک</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">حساب کاربری</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="profile.html">پروفایل</a></li>
                                        <li><a class="dropdown-item" href="login.html">ورود</a></li>
                                        <li><a class="dropdown-item" href="register.html">ثبت نام</a></li>
                                        <li><a class="dropdown-item" href="forgot-password.html">فراموشی رمز</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">قیمت ها</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="pricing.html">قیمت یک</a></li>
                                        <li><a class="dropdown-item" href="pricing-2.html">قیمت دو</a></li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item" href="contact.html">تماس با ما</a></li>
                                <li><a class="dropdown-item" href="faq.html">سوالات متداول</a></li>
                                <li><a class="dropdown-item" href="testimonial.html">نظرات</a></li>
                                <li><a class="dropdown-item" href="404.html">خطای ۴۰۴</a></li>
                                <li><a class="dropdown-item" href="coming-soon.html">به زودی</a></li>
                                <li><a class="dropdown-item" href="terms.html">شرایط استفاده از خدمات</a></li>
                                <li><a class="dropdown-item" href="privacy.html"> حفظ حریم خصوصی</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">فیلم ها</a>
                            <ul class="dropdown-menu fade-down">
                                <li><a class="dropdown-item" href="movie.html">فیلم یک</a></li>
                                <li><a class="dropdown-item" href="movie-2.html">فیلم دو</a></li>
                                <li><a class="dropdown-item" href="movie-3.html">فیلم سه</a></li>
                                <li><a class="dropdown-item" href="movie-single.html">فیلم تک یک</a></li>
                                <li><a class="dropdown-item" href="movie-single-2.html">فیلم تک دو</a></li>
                                <li><a class="dropdown-item" href="az-movie.html">دسته بندی فیلم</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">تلوزیون</a>
                            <ul class="dropdown-menu fade-down">
                                <li><a class="dropdown-item" href="tv-show.html">تلوزیون یک</a></li>
                                <li><a class="dropdown-item" href="tv-show-2.html">تلوزیون دو</a></li>
                                <li><a class="dropdown-item" href="tv-show-3.html">تلوزیون سه</a></li>
                                <li><a class="dropdown-item" href="tv-show-single.html">تلوزیون تک یک</a></li>
                                <li><a class="dropdown-item" href="tv-show-single-2.html">تلوزیون تک دو</a></li>
                                <li><a class="dropdown-item" href="az-tv-show.html">لیست تلوزیون</a></li>
                            </ul>
                        </li>
                        <li class="nav-item live"><a class="nav-link" href="live.html"><i
                                    class="fad fa-circle-dot animated infinite fadeIn"></i> زنده</a></li>
                    </ul>
                    <div class="nav-right">
                        <div class="nav-search-wrap">
                            <div class="search-btn">
                                <button type="button" class="nav-right-link search-box-outer"><i
                                        class="icon-search"></i></button>
                            </div>

                            <div class="search-area">
                                <form action="#">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="کلمه را وارد نمایید...">
                                        <button type="submit" class="search-icon-btn"><i
                                                class="icon-search"></i></button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="color-mode theme-mode-control">
                            <button type="button" class="nav-right-link light-btn"><i class="icon-sun"></i></button>
                            <button type="button" class="nav-right-link dark-btn"><i
                                    class="icon-moon-2"></i></button>
                        </div>
                        <div class="nav-right-btn">
                            <a href="#" class="theme-btn"><i class="far fa-sign-in"></i> ثبت نام</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
