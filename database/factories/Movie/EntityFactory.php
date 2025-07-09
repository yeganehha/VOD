<?php

namespace Database\Factories\Movie;

use App\Enums\Audio;
use App\Enums\EntityType;
use App\Enums\Gender;
use App\Enums\PublishStatus;
use App\Enums\WeekDay;
use Database\Fakers\MovieFakerProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\Admin>
 */
class EntityFactory extends Factory
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
        $this->faker->addProvider(new MovieFakerProvider($this->faker));
        return [
            'title' => $this->faker->movieTitle(),
            'title_en' => fake('en_US')->sentence(2),
            'slug' => fake('en_US')->unique()->slug,
            'second_title' => $this->faker->secondTitle(),
            'second_title_en' => fake('en_US')->optional()->sentence(2),
            'pre_title' => $this->faker->moviePreTitle(),
            'pre_title_en' => fake('en_US')->optional()->sentence(2),
            'type' => fake()->randomElement(EntityType::cases()),
            'publish_status' => fake()->randomElement(PublishStatus::cases()),
            'weekly_release_schedule_day' => fake()->randomElement(WeekDay::cases()),
            'weekly_release_schedule_hour' => fake()->time('H:i:s'),
            'about_movie' => $this->faker->movieSummary(),
            'about_movie_en' => fake('en_US')->optional()->paragraph(3),
            'age_range_id' => null, // تنظیم در Seeder یا با relation
            'main_audio' => fake()->randomElement(Audio::cases()),
            'exclusive' => fake()->boolean(),
            'is_free_movie' => fake()->boolean(),
            'logo' => fake()->optional()->imageUrl(),
            'movie_logo' => fake()->optional()->imageUrl(),
            'pro_year' => fake()->numberBetween(1990, now()->year),
        ];
    }

}
