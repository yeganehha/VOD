<?php

namespace Database\Factories\Movie;

use App\Enums\Gender;
use App\Enums\PublishStatus;
use App\Models\Movie\Movie;
use App\Models\User\Profile;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\Admin>
 */
class CommentFactory extends Factory
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
            'parent_id' => null,
            'profile_id' => fake()->randomElement(Profile::all()->pluck('id')->toArray()),
            'comment' => fake('fa_IR')->sentences(5,true),
            'publish_status' => PublishStatus::Publish->value,
            'is_spoiler' => rand(0, 1),
        ];
    }
    public function chiled(): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => fake()->randomNumber(1,2000),
        ]);
    }
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'publish_status' => fake()->randomElement([PublishStatus::Pending->value , PublishStatus::Reject->value]),
        ]);
    }
}
