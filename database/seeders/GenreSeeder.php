<?php
namespace Database\Seeders;


use App\Models\Movie\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( Genre::query()->count() < 26) {
            Genre::query()->insert([
                [
                    'title' => 'اکشن',
                    'slug' => 'action',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'کمدی',
                    'slug' => 'comedy',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'وحشت',
                    'slug' => 'horror',
                    'for_kids' => false,
                    'hide_from_kids' => true,
                ],
                [
                    'title' => 'انیمیشن',
                    'slug' => 'animation',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'علمی تخیلی',
                    'slug' => 'sci-fi',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'تاک شو',
                    'slug' => 'talk-show',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'عاشقانه',
                    'slug' => 'romance',
                    'for_kids' => false,
                    'hide_from_kids' => true,
                ],
                [
                    'title' => 'جنایی',
                    'slug' => 'crime',
                    'for_kids' => false,
                    'hide_from_kids' => true,
                ],
                [
                    'title' => 'درام',
                    'slug' => 'drama',
                    'for_kids' => false,
                    'hide_from_kids' => true,
                ],
                [
                    'title' => 'ماجراجویی',
                    'slug' => 'adventure',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'رازآلود',
                    'slug' => 'mystery',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'ریلیتی شو',
                    'slug' => 'reality-tv',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'فانتزی',
                    'slug' => 'fantasy',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'وسترن',
                    'slug' => 'western',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'هیجان انگیز',
                    'slug' => 'thriller',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'خانوادگی',
                    'slug' => 'family',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'جنگی',
                    'slug' => 'war',
                    'for_kids' => false,
                    'hide_from_kids' => true,
                ],
                [
                    'title' => 'ورزشی',
                    'slug' => 'sport',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'تاریخی',
                    'slug' => 'history',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'بیوگرافی',
                    'slug' => 'biography',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'مذهبی',
                    'slug' => 'religious',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'مستند',
                    'slug' => 'documentary',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'موزیکال',
                    'slug' => 'musical',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'موسیقی',
                    'slug' => 'music',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'کوتاه',
                    'slug' => 'short',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'تئاتر',
                    'slug' => 'theatre',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
                [
                    'title' => 'گیم شو',
                    'slug' => 'game-show',
                    'for_kids' => false,
                    'hide_from_kids' => false,
                ],
            ]);
        }
    }
}
