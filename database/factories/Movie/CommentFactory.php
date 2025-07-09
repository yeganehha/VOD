<?php

namespace Database\Factories\Movie;

use App\Enums\Gender;
use App\Enums\PublishStatus;
use App\Models\Movie\Movie;
use App\Models\User\Profile;
use App\Models\User\User;
use Database\Fakers\MovieFakerProvider;
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
        $this->faker->addProvider(new MovieFakerProvider($this->faker));
        return [
            'movie_id' => $this->faker->randomElement(Movie::all()->pluck('id')->toArray()),
            'parent_id' => null,
            'profile_id' => $this->faker->randomElement(Profile::all()->pluck('id')->toArray()),
            'comment' => $this->faker->movieComment(),
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
