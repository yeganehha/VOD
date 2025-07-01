<div class="filter-area3 pt-80 pb-40" dir="rtl">
    <div class="container">
        <div class="filter-wrap">
            <div class="row g-4 align-items-center">
                <div class="col-lg-10">
                    <div class="filter-content">
                        <form action="#">
                            <div class="filter-sort">
                                <div class="filter-select">
                                    <select class="searchBoxSelect select" data-js-placeholder="فیلم و سریال:" multiple>
                                        <option value="">همه</option>
                                        <option value="{{ \App\Enums\EntityType::Movie->value }}">فیلم</option>
                                        <option value="{{ \App\Enums\EntityType::Series->value }}">سریال</option>
                                    </select>
                                </div>
                                <div class="filter-select">
                                    <select class="searchBoxSelect select"  data-js-placeholder="زبان فیلم:">
                                        <option value="">همه</option>
                                        <option value="is_dubbed">فارسی (دوبله)</option>
                                        <option value="fa_sub">زیرنویس فارسی</option>
                                        <option value="en_sub">زیرنویس انگلیسی</option>
                                        <option value="org_lang">زبان اصلی</option>
                                        <option value="is_multilingual">چند زبانه</option>
                                    </select>
                                </div>
                                <div class="filter-select">
                                    <select class="searchBoxSelect select" data-js-placeholder="رده سنی:">
                                        <option value="">همه</option>
                                        @foreach(\App\Models\Asset\AgeRange::query()->orderBy('sort')->get() as $ageRange)
                                            <option value="age_between_{{ $ageRange->from_age }}_and_{{ $ageRange->to_age }}">{{ $ageRange->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-select">
                                    <select class="searchBoxSelect select" data-js-placeholder="کشور سازنده:" multiple>
                                        @foreach(\App\Repositories\Movie\CountryRepository::getAll(14) as $country)
                                            <option value="{{ \Illuminate\Support\Str::slug($country->title_en) }}">{{ $country->title }}</option>
                                        @endforeach
                                        <option value="other_country">دیگر کشورها</option>
                                    </select>
                                </div>
                                <div class="filter-select">
                                    <select class="searchBoxSelect select" data-js-placeholder="ژانر:" multiple>
                                        @foreach(\App\Repositories\Movie\GenreRepository::init()->getAll() as $genre)
                                            <option value="{{ $genre->slug }}">{{ $genre->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="filter-btn text-end" style="pointer-events: none;filter: contrast(0.5);">
                        <a href="" id="search_link"  class="theme-btn" ><span class="fas fa-search mx-1"></span>فیلتر</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="filter-full-wrap">
                    <div class="collapse" id="collapseFilter">
                        <div class="filter-full-content">
                            <form action="#">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="filter-item">
                                            <h4>دسته بندی براساس</h4>
                                            <div class="filter-item-content">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="sort"
                                                           id="sort1" value="1">
                                                    <label class="form-check-label" for="sort1">همه</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="sort"
                                                           id="sort2" value="2">
                                                    <label class="form-check-label" for="sort2">جدیدترین</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="sort"
                                                           id="sort3" value="3">
                                                    <label class="form-check-label" for="sort3">ترند</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="sort"
                                                           id="sort4" value="4">
                                                    <label class="form-check-label" for="sort4">بیشترین بازدید</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="sort"
                                                           id="sort5" value="5">
                                                    <label class="form-check-label" for="sort5">IMDB امتیاز</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="sort"
                                                           id="sort6" value="6">
                                                    <label class="form-check-label" for="sort6">نام فیلم</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="sort"
                                                           id="sort7" value="7">
                                                    <label class="form-check-label" for="sort7">تاریخ فیلم</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="filter-item">
                                            <h4>نوع</h4>
                                            <div class="filter-item-content">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="type"
                                                           id="type1" value="1">
                                                    <label class="form-check-label" for="type1">همه</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="type"
                                                           id="type2" value="2">
                                                    <label class="form-check-label" for="type2">فیلم</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="type"
                                                           id="type3" value="3">
                                                    <label class="form-check-label" for="type3">سریال</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="filter-item">
                                            <h4>کیفیت</h4>
                                            <div class="filter-item-content">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="quality"
                                                           id="quality1" value="1">
                                                    <label class="form-check-label" for="quality1">همه</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="quality"
                                                           id="quality2" value="2">
                                                    <label class="form-check-label" for="quality2">اچ دی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="quality"
                                                           id="quality3" value="3">
                                                    <label class="form-check-label" for="quality3">اس دی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="quality"
                                                           id="quality4" value="4">
                                                    <label class="form-check-label" for="quality4">تی اس</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="quality"
                                                           id="quality5" value="5">
                                                    <label class="form-check-label" for="quality5">کیفیت پرده</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="quality"
                                                           id="quality6" value="6">
                                                    <label class="form-check-label" for="quality6">دی وی دی</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="filter-item">
                                            <h4>امتیاز</h4>
                                            <div class="filter-item-content">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="type"
                                                           id="rating1" value="1">
                                                    <label class="form-check-label" for="rating1">همه</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="rating"
                                                           id="rating2" value="2">
                                                    <label class="form-check-label" for="rating2">بین ۹-۱۰</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="rating"
                                                           id="rating3" value="3">
                                                    <label class="form-check-label" for="rating3">بین ۸-۹</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="rating"
                                                           id="rating4" value="4">
                                                    <label class="form-check-label" for="rating4">بین ۷-۸</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="rating"
                                                           id="rating5" value="5">
                                                    <label class="form-check-label" for="rating5">بین ۶-۷</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="rating"
                                                           id="rating6" value="6">
                                                    <label class="form-check-label" for="rating6">بین ۵-۶</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="rating"
                                                           id="rating7" value="7">
                                                    <label class="form-check-label" for="rating7">بین ۴-۵</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="rating"
                                                           id="rating8" value="8">
                                                    <label class="form-check-label" for="rating8">بین ۳-۴</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="rating"
                                                           id="rating9" value="9">
                                                    <label class="form-check-label" for="rating9">بین ۲-۳</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="rating"
                                                           id="rating10" value="10">
                                                    <label class="form-check-label" for="rating10">بین ۱-۲</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="filter-item">
                                            <h4>سال تولید</h4>
                                            <div class="filter-item-content">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year1" value="1">
                                                    <label class="form-check-label" for="year1">همه</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year2" value="2">
                                                    <label class="form-check-label" for="year2">۲۰۲۳</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year3" value="3">
                                                    <label class="form-check-label" for="year3">۲۰۲۲</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year4" value="4">
                                                    <label class="form-check-label" for="year4">۲۰۲۱</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year5" value="5">
                                                    <label class="form-check-label" for="year5">۲۰۲۰</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year6" value="6">
                                                    <label class="form-check-label" for="year6">۲۰۱۹</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year7" value="7">
                                                    <label class="form-check-label" for="year7">۲۰۱۸</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year8" value="8">
                                                    <label class="form-check-label" for="year8">۲۰۱۷</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year9" value="9">
                                                    <label class="form-check-label" for="year9">۲۰۱۶</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year10" value="10">
                                                    <label class="form-check-label" for="year10">۲۰۱۵</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year11" value="11">
                                                    <label class="form-check-label" for="year11">۲۰۱۴</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year12" value="12">
                                                    <label class="form-check-label" for="year12">۲۰۱۳</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year13" value="13">
                                                    <label class="form-check-label" for="year13">۲۰۱۲</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year14" value="14">
                                                    <label class="form-check-label" for="year14">۲۰۱۱</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year15" value="15">
                                                    <label class="form-check-label" for="year15">۲۰۱۰</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year16" value="16">
                                                    <label class="form-check-label" for="year16">۲۰۰۹</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year17" value="17">
                                                    <label class="form-check-label" for="year17">۲۰۰۸</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year18" value="18">
                                                    <label class="form-check-label" for="year18">۲۰۰۷</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year19" value="19">
                                                    <label class="form-check-label" for="year19">۲۰۰۶</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year20" value="20">
                                                    <label class="form-check-label" for="year20">۲۰۰۵</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="year"
                                                           id="year21" value="21">
                                                    <label class="form-check-label" for="year21">قدیمی تر</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="filter-item">
                                            <h4>ژانر</h4>
                                            <div class="filter-item-content">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre1" value="1">
                                                    <label class="form-check-label" for="genre1">همه</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre2" value="2">
                                                    <label class="form-check-label" for="genre2">اکشن</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre3" value="3">
                                                    <label class="form-check-label" for="genre3">انیمیشن</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre4" value="4">
                                                    <label class="form-check-label" for="genre4">ماجراجویی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre5" value="5">
                                                    <label class="form-check-label" for="genre5">بیوگرافی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre6" value="6">
                                                    <label class="form-check-label" for="genre6">کمدی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre7" value="7">
                                                    <label class="form-check-label" for="genre7">جنایی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre8" value="8">
                                                    <label class="form-check-label" for="genre8">مستند</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre9" value="9">
                                                    <label class="form-check-label" for="genre9">درام</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre10" value="10">
                                                    <label class="form-check-label" for="genre10">خانواده</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre11" value="11">
                                                    <label class="form-check-label" for="genre11">فانتزی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre12" value="12">
                                                    <label class="form-check-label" for="genre12">قدیمی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre13" value="13">
                                                    <label class="form-check-label" for="genre13">تاریخی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre14" value="14">
                                                    <label class="form-check-label" for="genre14">ترسناک</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre15" value="15">
                                                    <label class="form-check-label" for="genre15">رزمی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre16" value="16">
                                                    <label class="form-check-label" for="genre16">موزیک</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre17" value="17">
                                                    <label class="form-check-label" for="genre17">موزیکال</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre18" value="18">
                                                    <label class="form-check-label" for="genre18">زارآلود</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre19" value="19">
                                                    <label class="form-check-label"
                                                           for="genre19">جادو و شعبده</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre20" value="20">
                                                    <label class="form-check-label" for="genre20">خبری</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre21" value="21">
                                                    <label class="form-check-label"
                                                           for="genre21">طبیعت</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre22" value="22">
                                                    <label class="form-check-label" for="genre22">رمانتیک</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre23" value="23">
                                                    <label class="form-check-label" for="genre23">فضایی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre24" value="24">
                                                    <label class="form-check-label" for="genre24">ورزشی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre25" value="25">
                                                    <label class="form-check-label" for="genre25">استند آپ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre26" value="26">
                                                    <label class="form-check-label" for="genre26">تفنگی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre27" value="27">
                                                    <label class="form-check-label" for="genre27">برنامه تلوزیون</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="genre"
                                                           id="genre28" value="28">
                                                    <label class="form-check-label" for="genre28">داخلی</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="filter-item">
                                            <h4>کشور</h4>
                                            <div class="filter-item-content">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country1" value="1">
                                                    <label class="form-check-label" for="country1">همه</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country2" value="2">
                                                    <label class="form-check-label" for="country2">آرژانتین</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country3" value="3">
                                                    <label class="form-check-label" for="country3">استرالیا</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country4" value="4">
                                                    <label class="form-check-label" for="country4">تهران</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country5" value="5">
                                                    <label class="form-check-label" for="country5">بلژیک</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country6" value="6">
                                                    <label class="form-check-label" for="country6">برزیل</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country7" value="7">
                                                    <label class="form-check-label" for="country7">کانادا</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country8" value="8">
                                                    <label class="form-check-label" for="country8">چین</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country9" value="9">
                                                    <label class="form-check-label" for="country9">روسیه</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country10" value="10">
                                                    <label class="form-check-label" for="country10">ایران</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country11" value="11">
                                                    <label class="form-check-label" for="country11">کره</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country12" value="12">
                                                    <label class="form-check-label" for="country12">فرانسه</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country13" value="13">
                                                    <label class="form-check-label" for="country13">آلمان</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country14" value="14">
                                                    <label class="form-check-label" for="country14">هنگ کنگ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country15" value="15">
                                                    <label class="form-check-label" for="country15">رومانی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country16" value="16">
                                                    <label class="form-check-label" for="country16">ایرلند</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country17" value="17">
                                                    <label class="form-check-label" for="country17">ایتالیا</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country18" value="18">
                                                    <label class="form-check-label" for="country18">ژاپن</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country19" value="19">
                                                    <label class="form-check-label" for="country19">مکزیک</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country20" value="20">
                                                    <label class="form-check-label"
                                                           for="country20">هلند</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country21" value="21">
                                                    <label class="form-check-label" for="country21">نروژ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country22" value="22">
                                                    <label class="form-check-label" for="country22">لهستان</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country23" value="23">
                                                    <label class="form-check-label" for="country23">رومانی</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country24" value="24">
                                                    <label class="form-check-label" for="country24">ترکیه</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country25" value="25">
                                                    <label class="form-check-label" for="country25">اسپانیا</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country26" value="26">
                                                    <label class="form-check-label" for="country26">تایلند</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country27" value="27">
                                                    <label class="form-check-label" for="country27">لندن</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="country"
                                                           id="country28" value="28">
                                                    <label class="form-check-label" for="country28">آمریکا</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-center">
                                            <button type="button" class="theme-btn"><span
                                                    class="fas fa-sort"></span>فیلتر کن</button>
                                        </div>
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
