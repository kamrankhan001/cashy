<?php

namespace Database\Factories;

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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_admin' => false,
            'initial_deposit' => $this->faker->randomElement(['no', 'yes']),
            'verified_deposit' => $this->faker->randomElement(['pending', 'verified']),
            'level' => ($level = $this->faker->numberBetween(1, 10)), // Generate a random level between 1 and 10
            'work_limit' => $level * 5, // Work limit is 5 times the level
            'last_viewed_date' => $this->faker->optional()->date(),
            'ref_link' => null,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'email_verified_at' => null,
            ],
        );
    }
}
