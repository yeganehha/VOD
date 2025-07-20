@extends('app')

@section('title', 'ورود | نوین باکس')
@section('meta_description', 'تماشای جدیدترین فیلم‌ها و سریال‌ها در نوین باکس با کیفیت بالا و تنوع بی‌نظیر.')

@section('content')

    <div class="auth-area pb-100 pt-50" dir="rtl">
        <div class="container">
            <div class="col-md-5 col-lg-4 mx-auto">
                <div class="auth-wrap">
                    <div class="auth-form">
                        <form method="POST" action="#">
                            <div class="form-group">
                                <label>شماره تماس</label>
                                <input type="number" dir="ltr" value="{{ old('phone') }}" name="phone" required class="form-control" placeholder="شماره تماس شما">

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>رمز عبور</label>
                                <input type="password" dir="ltr" name="password" required class="form-control"  placeholder="رمز عبور">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="auth-check">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        مرا بخاطر بسپار
                                    </label>
                                </div>
{{--                                <a href="forgot-password.html">فراموشی رمز </a>--}}
                            </div>
                            <div class="auth-btn">
                                <button type="submit" class="theme-btn"><span class="far fa-sign-in"></span> ورود</button>
                            </div>
                        </form>
                        <div class="auth-footer">
                            <p>اکانت کاربری ندارید؟ می توانید از همین صفحه ثبت‌نام کنید</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
