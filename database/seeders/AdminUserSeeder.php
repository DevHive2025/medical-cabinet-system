<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'nom' => 'Admin',
                'prenom' => 'System',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
            ]
        );
    }
}
