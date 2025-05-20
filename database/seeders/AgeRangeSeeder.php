<?php
namespace Database\Seeders;


use App\Models\Asset\AgeRange;
use Illuminate\Database\Seeder;

class AgeRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( AgeRange::query()->count() < 6) {
            AgeRange::query()->insert([
                [
                    'title' => 'زیر 3 سال',
                    'from_age' => 0,
                    'to_age' => 2,
                    'is_kid' => true,
                    'sort' => 0,
                ],
                [
                    'title' => 'بین 3 تا 6 سال',
                    'from_age' => 3,
                    'to_age' => 5,
                    'is_kid' => true,
                    'sort' => 1,
                ],
                [
                    'title' => 'بین 6 تا 12 سال',
                    'from_age' => 6,
                    'to_age' => 11,
                    'is_kid' => true,
                    'sort' => 2,
                ],
                [
                    'title' => 'بین 12 تا 15 سال',
                    'from_age' => 11,
                    'to_age' => 14,
                    'is_kid' => true,
                    'sort' => 3,
                ],
                [
                    'title' => 'بین 15 تا 18 سال',
                    'from_age' => 14,
                    'to_age' => 17,
                    'is_kid' => true,
                    'sort' => 4,
                ],
                [
                    'title' => 'بالای 18 سال',
                    'from_age' => 18,
                    'to_age' => 999,
                    'is_kid' => false,
                    'sort' => 5,
                ],
            ]);
        }
    }
}
