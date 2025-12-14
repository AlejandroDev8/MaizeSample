<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'role' => 'Administrador',
                // Si tu tabla users requiere password, lo seteamos siempre
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Si quieres datos fake adicionales:
        // User::factory()->count(10)->create();
    }
}
