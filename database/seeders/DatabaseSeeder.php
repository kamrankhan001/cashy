<?php

namespace Database\Seeders;

use App\Models\{User, Setting, Work, Wallet};
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
    }
}
