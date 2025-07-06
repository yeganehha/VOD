<div class="filter-area3 pt-80 pb-40" dir="rtl">
    <div class="container">
        <div class="filter-wrap">
            <div class="row g-4 align-items-center">
                <div class="col-lg-10">
                    <div class="filter-content">
                        <form action="#">
                            <div class="filter-sort">
                                <div class="filter-select">
                                    <select class="searchBoxSelect select" data-js-placeholder="فیلم و سریال:">
                                        <option value="">همه</option>
                                        <option @selected(in_array(\App\Enums\EntityType::Movie->value , $values)) value="{{ \App\Enums\EntityType::Movie->value }}">فیلم</option>
                                        <option @selected(in_array(\App\Enums\EntityType::Series->value , $values)) value="{{ \App\Enums\EntityType::Series->value }}">سریال</option>
                                    </select>
                                </div>
                                <div class="filter-select">
                                    <select class="searchBoxSelect select"  data-js-placeholder="زبان فیلم:">
                                        <option value="">همه</option>
                                        <option @selected(in_array('is_dubbed' , $values)) value="is_dubbed">فارسی (دوبله)</option>
                                        <option @selected(in_array('fa_sub' , $values)) value="fa_sub">زیرنویس فارسی</option>
                                        <option @selected(in_array('is_multilingual' , $values)) value="is_multilingual">چند زبانه</option>
                                    </select>
                                </div>
                                <div class="filter-select">
                                    <select class="searchBoxSelect select" data-js-placeholder="رده سنی:">
                                        <option value="">همه</option>
                                        @foreach(\App\Models\Asset\AgeRange::query()->orderBy('sort')->get() as $ageRange)
                                            <option @selected(in_array('age_between_'.$ageRange->from_age.'_and_'.$ageRange->to_age , $values)) value="age_between_{{ $ageRange->from_age }}_and_{{ $ageRange->to_age }}">{{ $ageRange->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-select">
                                    <select class="searchBoxSelect select" data-js-placeholder="کشور سازنده:" multiple>
                                        @foreach(\App\Repositories\Movie\CountryRepository::getAll(14) as $country)
                                            <option @selected(in_array($country->code.'_'.\Illuminate\Support\Str::slug($country->title_en) , $values)) value="{{ $country->code .'_'.\Illuminate\Support\Str::slug($country->title_en) }}">{{ $country->title }}</option>
                                        @endforeach
                                        <option @selected(in_array('other_country' , $values)) value="other_country">دیگر کشورها</option>
                                    </select>
                                </div>
                                <div class="filter-select">
                                    <select class="searchBoxSelect select" data-js-placeholder="ژانر:" multiple>
                                        @foreach(\App\Repositories\Movie\GenreRepository::init()->getAll() as $genre)
                                            <option @selected(in_array($genre->slug , $values)) value="{{ $genre->slug }}">{{ $genre->title }}</option>
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
        </div>
    </div>
</div>
