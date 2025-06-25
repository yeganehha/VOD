<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Asset\AgeRange;
use App\Models\Asset\Country;
use App\Models\Movie\Comment;
use App\Models\Movie\Crew;
use App\Models\Movie\Entity;
use App\Models\Movie\Genre;
use App\Models\Movie\MovieCrew;
use App\Models\User\Admin;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountriesSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(CrewPositionSeeder::class);

        if ( ! Admin::query()->where('username' , 'admin' )->exists())
            Admin::factory()->create([
                'first_name' => 'کاربر',
                'last_name' => 'ادمین',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        if ( Admin::query()->count() < 50)
            Admin::factory(50)->create();


        $this->call(AgeRangeSeeder::class);

        if ( User::query()->count() < 100) {
            User::factory(30)->create();
            User::factory(30)->withProfiles(1)->create();
            User::factory(30)->withProfiles(2)->create();
            User::factory(10)->withProfiles(3)->create();
        }



        if ( Crew::query()->count() < 100) {
            Crew::factory(70)->create();
            Crew::factory(30)->dead()->create();
        }


        if ( Entity::query()->count() < 100) {
            $ageRanges = AgeRange::query()->pluck('id');
            $countries = Country::query()->pluck('id');
            $genres = Genre::query()->pluck('id');
            Entity::factory()
                ->count(100)
                ->create()
                ->each(function ($entity) use ($ageRanges, $countries, $genres) {
                    if ($ageRanges->isNotEmpty()) {
                        $entity->update([
                            'age_range_id' => $ageRanges->random(),
                        ]);
                    }
                    $entity->countries()->attach($countries->random(rand(1, 3)));
                    $entity->genres()->attach($genres->random(rand(1, 3)));
                });
            $this->call(MovieSeeder::class);
        }


        if ( MovieCrew::query()->count() < 2000) {
            MovieCrew::factory(2000)->create();
        }
        if ( Comment::query()->count() < 2000) {
            Comment::factory(2000)->create();
            Comment::factory(500)->chiled()->create();
            Comment::factory(500)->admin()->create();
        }

    }
}
