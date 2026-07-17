<?php

namespace Database\Seeders;

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
        User::create([
            'name' => 'Sara Serveur',
            'email' => 'serveur@hotel.test',
            'password' => Hash::make('password'),
            'role' => 'serveur',
        ]);

        User::create([
            'name' => 'Youssef Technicien',
            'email' => 'technicien@hotel.test',
            'password' => Hash::make('password'),
            'role' => 'technicien',
        ]);

        User::create([
            'name' => 'Fatima Admin',
            'email' => 'admin@hotel.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
