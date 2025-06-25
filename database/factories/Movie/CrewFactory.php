<?php

namespace Database\Factories\Movie;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\Admin>
 */
class CrewFactory extends Factory
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
            'name' => fake()->name(),
            'name_en' => fake('en')->name(),
            'slug' => fake('en')->slug(),
            'biography' => fake('fa')->paragraphs(asText: true),
            'biography_en' => fake('en')->paragraphs(asText: true),
            'birthday' => fake()->date(),
            'avatar' => fake()->randomElement(['Avatar/comment01.jpeg','Avatar/comment02.jpeg','Avatar/comment03.jpeg','Avatar/comment04.jpeg','Avatar/comment05.jpeg']),
            'birth_location_id' => fake()->randomNumber(1,250),
            'gender' => fake()->randomElement(Gender::values()),
            'main_position_id' => fake()->randomNumber(1,26),
        ];
    }
    public function dead(): static
    {
        return $this->state(fn (array $attributes) => [
            'death_at' => fake()->date(),
        ]);
    }
}
