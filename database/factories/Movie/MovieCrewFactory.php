<?php

namespace Database\Factories\Movie;

use App\Enums\Gender;
use App\Models\Movie\Crew;
use App\Models\Movie\CrewPosition;
use App\Models\Movie\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\Admin>
 */
class MovieCrewFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'movie_id' => fake()->randomElement(Movie::all()->pluck('id')->toArray()),
            'crew_id' => fake()->randomElement(Crew::all()->pluck('id')->toArray()),
            'position_id' => fake()->randomElement(CrewPosition::all()->pluck('id')->toArray()),
        ];
    }
}
