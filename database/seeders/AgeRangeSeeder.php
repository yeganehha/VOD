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
                    'is_kid' => true,
                    'sort' => 0,
                ],
                [
                    'title' => 'بین 3 تا 6 سال',
                    'is_kid' => true,
                    'sort' => 1,
                ],
                [
                    'title' => 'بین 6 تا 12 سال',
                    'is_kid' => true,
                    'sort' => 2,
                ],
                [
                    'title' => 'بین 12 تا 15 سال',
                    'is_kid' => true,
                    'sort' => 3,
                ],
                [
                    'title' => 'بین 15 تا 18 سال',
                    'is_kid' => true,
                    'sort' => 4,
                ],
                [
                    'title' => 'بالای 18 سال',
                    'is_kid' => false,
                    'sort' => 5,
                ],
            ]);
        }
    }
}
