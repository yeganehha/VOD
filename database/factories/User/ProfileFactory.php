<?php

namespace Database\Factories\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProfileFactory extends Factory
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
            'age_range_id' => fake()->randomElement([1,2,3,4,5,6]),
            'main_user' => false,
        ];
    }

    public function mainUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'main_user' => true,
        ]);
    }
}
