<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Movie\Crew;
use App\Models\User\Admin;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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

        $this->call(GenreSeeder::class);
        $this->call(CrewPositionSeeder::class);


        if ( Crew::query()->count() < 100) {
            Crew::factory(70)->create();
            Crew::factory(30)->dead()->create();
        }

        $this->call(CountriesSeeder::class);
    }
}
