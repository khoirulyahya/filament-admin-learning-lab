<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with synthetic demo data only.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Demo Admin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        User::factory(5)->create();
    }
}
