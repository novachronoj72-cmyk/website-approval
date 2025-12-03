<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('cob@1'),
            'role' => UserRole::ADMIN,
            'email_verified_at' => now(),
        ]);

        // Akun Verifikator
        User::create([
            'name' => 'Verifikator',
            'email' => 'verifikator@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::VERIFIKATOR,
            'email_verified_at' => now(),
        ]);

        // Akun User Biasa
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::USER,
            'email_verified_at' => now(),
        ]);

        // Opsional: Buat beberapa user dummy
        User::factory(10)->create();
    }
}
