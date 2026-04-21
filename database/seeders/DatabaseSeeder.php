<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $email = (string) env('SEED_ADMIN_EMAIL', 'admin@poachy.com');
        $name = (string) env('SEED_ADMIN_NAME', 'Admin');
        $password = (string) env('SEED_ADMIN_PASSWORD', 'password123');

        User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password)]
        );

        $this->command?->info('Seeded: admin user only');
    }
}
