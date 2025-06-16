<header class="header" dir="rtl">
    <div class="main-navigation">
        <nav class="navbar navbar-expand-lg">
            <div class="container position-relative">
                <a class="navbar-brand" href="{{ route('home') }}">
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
                            <a class="nav-link @if(request()->routeIs('home')) active @endif" href="{{ route('home') }}">خانه</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">ژانر</a>
                            <div class="dropdown-menu mega-menu fade-down">
                                @php
                                    $columns = 3;
                                    $total = \App\Repositories\Movie\GenreRepository::init()->getAll()->count();
                                    $perColumn = (int) ceil($total / $columns);
                                    $chunks = \App\Repositories\Movie\GenreRepository::init()->getAll()->chunk($perColumn);
                                @endphp
                                <div class="row">
                                    @foreach ($chunks as $chunk)
                                        <div class="col-lg-4">
                                            @foreach ($chunk as $genre)
                                                <a class="dropdown-item" href="{{ route('genre' , ['genre' => $genre->slug]) }}">{{ $genre->title }}</a>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">کشور</a>
                            <div class="dropdown-menu mega-menu fade-down">
                                <div class="row">
                                    @foreach (\App\Repositories\Movie\CountryRepository::getAll(27)->chunk(3) as $chunk)
                                        <div class="col-lg-4">
                                            @foreach ($chunk as $country)
                                                <a class="dropdown-item" href="{{ route('country' , ['code' => $country->code , 'title' => str()->slug($country->title_en)]) }}">{{ $country->title }}</a>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('type.movies')) active @endif" href="{{ route('type.movies') }}">فیلم</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('type.series')) active @endif" href="{{ route('type.series') }}">سریال</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('type.iranian')) active @endif" href="{{ route('type.iranian') }}">ایرانی</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('type.foreign')) active @endif" href="{{ route('type.foreign') }}">خارجی</a>
                        </li>
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
