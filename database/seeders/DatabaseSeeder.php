<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Creates a default admin user so you can log in right away.
     * Run with: php artisan db:seed
     *
     * Login credentials:
     *   Email:    admin@poachy.com
     *   Password: password123
     */
    public function run(): void
    {
        // firstOrCreate: if the user already exists, skip — no duplicate
        User::firstOrCreate(
            ['email' => 'admin@poachy.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password123'),
            ]
        );

        $this->command->info('✅ Default admin user ready.');
        $this->command->info('   Email:    admin@poachy.com');
        $this->command->info('   Password: password123');
    }
}
