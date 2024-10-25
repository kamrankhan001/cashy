<?php

namespace Database\Seeders;

use App\Models\{User, Setting, Work, Wallet, Level};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $users =  User::factory(20)->create();
        Work::factory(100)->create();

        // Assign one wallet to each user
        // $users->each(function ($user) {
        //     Wallet::factory()->create([
        //         'user_id' => $user->id, // Ensure each user gets a wallet
        //     ]);
        // });

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'country' => 'UK',
            'city' => 'London',
            'address' => 'some address here',
            'password' => '12345678',
            'is_admin' => true,
        ]);

        Setting::create([
            'jazzcash_account_title' => 'Admin',
            'jazzcash_account_number' => '0300 0011011',
            'easy_asa_account_title' => 'Admin',
            'easy_asa_account_number' => '0300 0011011',
            'per_coin_price' => '0.2',
            'job_per_coin' => '20',
        ]);

        $settings = Setting::first(); // Get the first setting (assuming only one exists)

        $levels = [
            ['level_number' => 1, 'members' => 1, 'task_income' => 25, 'referral_bonus' => 150, 'extra_coins' => 25],
            ['level_number' => 2, 'members' => 4, 'task_income' => 35, 'referral_bonus' => 150, 'extra_coins' => 40],
            ['level_number' => 3, 'members' => 20, 'task_income' => 45, 'referral_bonus' => 150, 'extra_coins' => 60],
            ['level_number' => 4, 'members' => 40, 'task_income' => 60, 'referral_bonus' => 150, 'extra_coins' => 80],
            ['level_number' => 5, 'members' => 100, 'task_income' => 80, 'referral_bonus' => 150, 'extra_coins' => 100],
            ['level_number' => 6, 'members' => 180, 'task_income' => 120, 'referral_bonus' => 150, 'extra_coins' => 100],
            ['level_number' => 7, 'members' => 280, 'task_income' => 200, 'referral_bonus' => 150, 'extra_coins' => 100],
            ['level_number' => 8, 'members' => 400, 'task_income' => 300, 'referral_bonus' => 150, 'extra_coins' => 100],
            ['level_number' => 9, 'members' => 450, 'task_income' => 400, 'referral_bonus' => 150, 'extra_coins' => 100],
            ['level_number' => 10, 'members' => 500, 'task_income' => 500, 'referral_bonus' => 150, 'extra_coins' => 100],
        ];

        foreach ($levels as $level) {
            Level::create(array_merge($level, ['setting_id' => $settings->id]));
        }
    }
}
