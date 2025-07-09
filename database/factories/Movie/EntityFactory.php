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
            'title' => fake('fa_IR')->sentence(2),
            'title_en' => fake('fa_IR')->sentence(2),
            'slug' => fake('fa_IR')->unique()->slug,
            'second_title' => fake('fa_IR')->optional()->sentence(2),
            'second_title_en' => fake('fa_IR')->optional()->sentence(2),
            'pre_title' => fake('fa_IR')->optional()->sentence(2),
            'pre_title_en' => fake('fa_IR')->optional()->sentence(2),
            'type' => fake('fa_IR')->randomElement(EntityType::cases()),
            'publish_status' => fake('fa_IR')->randomElement(PublishStatus::cases()),
            'weekly_release_schedule_day' => fake('fa_IR')->randomElement(WeekDay::cases()),
            'weekly_release_schedule_hour' => fake('fa_IR')->time('H:i:s'),
            'about_movie' => fake('fa_IR')->optional()->paragraph(3),
            'about_movie_en' => fake('fa_IR')->optional()->paragraph(3),
            'age_range_id' => null, // تنظیم در Seeder یا با relation
            'main_audio' => fake('fa_IR')->randomElement(Audio::cases()),
            'exclusive' => fake('fa_IR')->boolean(),
            'is_free_movie' => fake('fa_IR')->boolean(),
            'logo' => fake('fa_IR')->optional()->imageUrl(),
            'movie_logo' => fake('fa_IR')->optional()->imageUrl(),
            'pro_year' => fake('fa_IR')->numberBetween(1990, now()->year),
        ];
    }

}
