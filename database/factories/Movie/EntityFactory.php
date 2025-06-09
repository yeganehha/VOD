<?php

namespace Database\Factories\Movie;

use App\Enums\Audio;
use App\Enums\EntityType;
use App\Enums\Gender;
use App\Enums\PublishStatus;
use App\Enums\WeekDay;
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
        return [
            'title' => $this->faker->sentence(2),
            'title_en' => $this->faker->sentence(2),
            'slug' => $this->faker->unique()->slug,
            'second_title' => $this->faker->optional()->sentence(2),
            'second_title_en' => $this->faker->optional()->sentence(2),
            'pre_title' => $this->faker->optional()->sentence(2),
            'pre_title_en' => $this->faker->optional()->sentence(2),
            'type' => $this->faker->randomElement(EntityType::cases()),
            'publish_status' => $this->faker->randomElement(PublishStatus::cases()),
            'weekly_release_schedule_day' => $this->faker->randomElement(WeekDay::cases()),
            'weekly_release_schedule_hour' => $this->faker->time('H:i:s'),
            'about_movie' => $this->faker->optional()->paragraph(3),
            'about_movie_en' => $this->faker->optional()->paragraph(3),
            'age_range_id' => null, // تنظیم در Seeder یا با relation
            'main_audio' => $this->faker->randomElement(Audio::cases()),
            'exclusive' => $this->faker->boolean(),
            'is_free_movie' => $this->faker->boolean(),
            'logo' => $this->faker->optional()->imageUrl(),
            'movie_logo' => $this->faker->optional()->imageUrl(),
            'pro_year' => $this->faker->numberBetween(1990, now()->year),
        ];
    }

}
