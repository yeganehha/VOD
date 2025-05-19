<?php
namespace Database\Seeders;



use App\Models\Movie\CrewPosition;
use Illuminate\Database\Seeder;

class CrewPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( CrewPosition::query()->count() < 16) {
            CrewPosition::query()->insert([
                [
                    'title' => 'کارگردان',
                    'slug' => 'director',
                ],
                [
                    'title' => 'تهیه‌کننده',
                    'slug' => 'producer',
                ],
                [
                    'title' => 'فیلمنامه‌نویس',
                    'slug' => 'screenwriter',
                ],
                [
                    'title' => 'بازیگر',
                    'slug' => 'actor',
                ],
                [
                    'title' => 'دستیار کارگردان',
                    'slug' => 'assistant-director',
                ],
                [
                    'title' => 'مدیر فیلمبرداری',
                    'slug' => 'cinematographer',
                ],
                [
                    'title' => 'طراح تولید',
                    'slug' => 'production-designer',
                ],
                [
                    'title' => 'تدوینگر',
                    'slug' => 'editor',
                ],
                [
                    'title' => 'آهنگساز',
                    'slug' => 'composer',
                ],
                [
                    'title' => 'صدابردار',
                    'slug' => 'sound-designer',
                ],
                [
                    'title' => 'طراح لباس',
                    'slug' => 'costume-designer',
                ],
                [
                    'title' => 'چهره‌پرداز',
                    'slug' => 'makeup-artist',
                ],
                [
                    'title' => 'نورپرداز',
                    'slug' => 'gaffer',
                ],
                [
                    'title' => 'بدلکار',
                    'slug' => 'stunt-coordinator',
                ],
                [
                    'title' => 'مدیر تولید',
                    'slug' => 'production-manager',
                ],
                [
                    'title' => 'تیم فنی',
                    'slug' => 'crew',
                ],
            ]);
        }
    }
}
