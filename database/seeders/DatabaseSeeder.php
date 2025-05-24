<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Roles
        Role::insert([
            ['id' => 1, 'name' => 'admin'],
            ['id' => 2, 'name' => 'pengguna'],
        ]);

        // Seed Users
        User::insert([
            [
                'name' => 'aulia',
                'email' => 'aulia@gmail.com',
                'password_hash' => Hash::make('123'),  // hash password supaya aman
                'birth_date' => '2005-01-01',
                'gender' => 'perempuan',
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'awan',
                'email' => 'awan@gmail.com',
                'password_hash' => Hash::make('123'),
                'birth_date' => '2005-02-02',
                'gender' => 'laki-laki',
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rio',
                'email' => 'rio@gmail.com',
                'password_hash' => Hash::make('123'),
                'birth_date' => '2005-07-07',
                'gender' => 'laki-laki',
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
