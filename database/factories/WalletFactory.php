<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->numberBetween(100, 1000), // Random amount between 100 and 1000
            'daily_earning' => $this->faker->numberBetween(0, 50), // Random daily earning between 0 and 50
            'last_earning_date' => $this->faker->optional()->date(), // Random or null date
            'referral_bonus' => $this->faker->optional()->numberBetween(0, 100), // Random or null bonus
            'extra_coins' => $this->faker->optional()->numberBetween(0, 500), // Random or null coins
            'user_id' => User::factory(), // A
        ];
    }
}
