<?php

namespace Database\Factories\User;

use App\Models\User\Profile;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'phone' => fake()->unique()->numerify('09#########'),
            'max_profiles' => fake()->randomElement([1,2,3,4,5]),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function noPassword(): static
    {
        return $this->state(fn (array $attributes) => [
            'password' => null,
        ]);
    }
    public function defaultLimit(): static
    {
        return $this->state(fn (array $attributes) => [
            'max_profiles' => null,
        ]);
    }


    public function withProfiles($count = 3)
    {
        return $this->afterCreating(function (User $user) use($count) {
            Profile::factory()
                ->count(1)
                ->mainUser()
                ->for($user)
                ->create();
            Profile::factory()
                ->count($count-1)
                ->for($user)
                ->create();
        });
    }
}
