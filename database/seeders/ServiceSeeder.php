<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Spa',
            'description' => 'Séance de relaxation et soins du corps.',
            'price' => 200.00,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Navette Aéroport',
            'description' => 'Transport aller-retour vers l\'aéroport Mohammed V.',
            'price' => 150.00,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Location Vélo',
            'description' => 'Location de vélo pour la journée.',
            'price' => 50.00,
            'is_active' => true,
        ]);
    }
}
