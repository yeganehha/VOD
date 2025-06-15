<div class="footer-widget">
    <div class="container">
        <div class="footer-widget-wrapper pt-100 pb-50">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="footer-widget-box about-us">
                        <a href="#" class="footer-logo">
                            <img src="{{ asset('assets/images/logo.png') }}" class="logo-dark-mode" alt="">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" class="logo-light-mode" alt="">
                        </a>
                        <p class="mb-3">
                            ما انواع مختلفی از معابر موجود داریم که اکثریت آنها دچار تغییر شده اند
                            به نوعی با تزریق کلمات طنز باورپذیر.
                        </p>
                        <div class="footer-language">
                            <div class="dropdown">
                                <a href="#" class="language dropdown-toggle" data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    <img src="images/united-states.png" alt="">
                                    <span>انگلیسی</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><img src="images/united-states.png"
                                                                               alt="">انگلیسی</a></li>
                                    <li><a class="dropdown-item" href="#"><img src="images/germany.png"
                                                                               alt="">ترکی</a></li>
                                    <li><a class="dropdown-item" href="#"><img src="images/france.png"
                                                                               alt="">عربی</a></li>
                                    <li><a class="dropdown-item" href="#"><img src="images/china.png"
                                                                               alt="">ژاپنی</a></li>
                                    <li><a class="dropdown-item" href="#"><img src="images/spain.png"
                                                                               alt="">چینی</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">موپلی</h4>
                        <ul class="footer-list">
                            <li><a href="#">درباره ما</a></li>
                            <li><a href="#">شاهدات</a></li>
                            <li><a href="#">با ما تماس بگیرید</a></li>
                            <li><a href="#">شرایط خدمات</a></li>
                            <li><a href="#">خط مشی رازداری</a></li>
                            <li><a href="#">اخبار به‌روزرسانی</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">ژانر</h4>
                        <ul class="footer-list">
                            <li><a href="#">اکشن</a></li>
                            <li><a href="#">بیوگرافی</a></li>
                            <li><a href="#">مستند</a></li>
                            <li><a href="#">ماجراجویی</a></li>
                            <li><a href="#">ریلی تایم</a></li>
                            <li><a href="#">روانی</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">پشتیبانی</h4>
                        <ul class="footer-list">
                            <li><a href="#">مرکز راهنمایی</a></li>
                            <li><a href="#">سؤالات متداول</a></li>
                            <li><a href="#">حساب من</a></li>
                            <li><a href="#">درخواست فیلم</a></li>
                            <li><a href="#">پشتیبانی</a></li>
                            <li><a href="#">مرکز رسانه</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">خبرنامه</h4>
                        <div class="footer-newsletter">
                            <p>برای دریافت آخرین به روز رسانی و اخبار، در خبرنامه ما مشترک شوید</p>
                            <div class="subscribe-form">
                                <form action="#">
                                    <input type="email" class="form-control" placeholder="ایمیل آدرس">
                                    <button class="theme-btn" type="submit">
                                        <span class="icon-paper-plane"></span>عضویت
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-none">
                    <div class="footer-top-link">
                        <a href="#">IMDB برتر</a>
                        <a href="#">نسخه جدید</a>
                        <a href="#">فیلم‌ها</a>
                        <a href="#">نمایش‌های تلویزیونی</a>
                        <a href="#">ویدیوها</a>
                        <a href="#">اقدام</a>
                        <a href="#">فانتزی</a>
                        <a href="#">انیمیشن</a>
                        <a href="#">موسیقی</a>
                        <a href="#">جرم</a>
                        <a href="#">وحشتناک</a>
                        <a href="#">ورزش</a>
                        <a href="#">درام</a>
                        <a href="#">تماشا کنید</a>
                        <a href="#">نقشه سایت</a>
                        <a href="#">شو کمدی</a>
                        <a href="#">کمدی</a>
                        <a href="#">تماشا کنید</a>
                        <a href="#">آخرین فیلم</a>
                        <a href="#">فیلم آینده</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="copyright" >
    <div class="container">
        <div class="row" >
            <div class="col-md-6 align-self-center">
                <p class="copyright-text">
                    © <span>{{ verta()->format('Y') }}</span> <a href="{{ route('home') }}"> نوین باکس </a>  . تمامی حقوق محفوظ است.
                </p>
            </div>
            <div class="col-md-6 align-self-center">
                <ul class="footer-social">
                    <li><a href="#"><i class="fab fa-square-facebook"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
                    <li><a href="#"><i class="fab fa-tiktok"></i></a></li>
                    <li><a href="#"><i class="fab fa-vk"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
