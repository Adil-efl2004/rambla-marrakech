<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            // ── Étage 1 ────────────────────────────────────────────────────────
            [
                'number'         => '101',
                'floor'          => 1,
                'type'           => 'simple',
                'price_per_night'=> 450.00,
                'wifi_vlan'      => 'VLAN10',
                'surface_m2'     => 22,
                'capacity'       => 2,
                'bed_type'       => 'double',
                'amenities'      => ['climatisation', 'wifi', 'télévision', 'coffre-fort'],
                'description'    => 'Chambre confortable avec vue sur le patio intérieur. Idéale pour un séjour en solo ou en duo, elle associe un cadre chaleureux et des équipements essentiels pour un repos parfait.',
            ],
            [
                'number'         => '102',
                'floor'          => 1,
                'type'           => 'double',
                'price_per_night'=> 600.00,
                'wifi_vlan'      => 'VLAN10',
                'surface_m2'     => 30,
                'capacity'       => 2,
                'bed_type'       => 'queen',
                'amenities'      => ['climatisation', 'wifi', 'télévision', 'minibar', 'coffre-fort', 'baignoire'],
                'description'    => 'Chambre double spacieuse avec lit queen size et salle de bain privative. Le minibar et la baignoire apportent une touche de confort supplémentaire pour un séjour reposant.',
            ],
            [
                'number'         => '103',
                'floor'          => 1,
                'type'           => 'suite',
                'price_per_night'=> 850.00,
                'wifi_vlan'      => 'VLAN10',
                'surface_m2'     => 45,
                'capacity'       => 4,
                'bed_type'       => 'king',
                'amenities'      => ['climatisation', 'wifi', 'télévision', 'minibar', 'coffre-fort', 'baignoire', 'jacuzzi', 'salon privé', 'vue jardin'],
                'description'    => 'Suite luxueuse avec salon privatif, jacuzzi et vue sur les jardins de Rambla. Conçue pour les séjours d\'exception, elle offre espace, intimité et prestations cinq étoiles.',
            ],

            // ── Étage 2 ────────────────────────────────────────────────────────
            [
                'number'         => '201',
                'floor'          => 2,
                'type'           => 'simple',
                'price_per_night'=> 500.00,
                'wifi_vlan'      => 'VLAN20',
                'surface_m2'     => 24,
                'capacity'       => 2,
                'bed_type'       => 'double',
                'amenities'      => ['climatisation', 'wifi', 'télévision', 'coffre-fort', 'balcon'],
                'description'    => 'Chambre simple en étage avec balcon privatif donnant sur la médina. Profitez de la lumière naturelle et de l\'animation marocaine depuis votre propre terrasse.',
            ],
            [
                'number'         => '202',
                'floor'          => 2,
                'type'           => 'double',
                'price_per_night'=> 700.00,
                'wifi_vlan'      => 'VLAN20',
                'surface_m2'     => 32,
                'capacity'       => 2,
                'bed_type'       => 'king',
                'amenities'      => ['climatisation', 'wifi', 'télévision', 'minibar', 'coffre-fort', 'balcon', 'baignoire'],
                'description'    => 'Chambre double supérieure avec lit king size, balcon panoramique et baignoire. Situé en étage, ce logement offre calme et vue dégagée sur les toits de Marrakech.',
            ],
            [
                'number'         => '203',
                'floor'          => 2,
                'type'           => 'suite',
                'price_per_night'=> 900.00,
                'wifi_vlan'      => 'VLAN20',
                'surface_m2'     => 48,
                'capacity'       => 4,
                'bed_type'       => 'king',
                'amenities'      => ['climatisation', 'wifi', 'télévision', 'minibar', 'coffre-fort', 'baignoire', 'jacuzzi', 'salon privé', 'balcon', 'vue montagne'],
                'description'    => 'Suite premium en étage supérieur avec jacuzzi, salon privé et balcon face aux sommets de l\'Atlas. L\'alliance parfaite du luxe oriental et du panorama naturel marocain.',
            ],
            [
                'number'         => '204',
                'floor'          => 2,
                'type'           => 'simple',
                'price_per_night'=> 480.00,
                'wifi_vlan'      => 'VLAN20',
                'surface_m2'     => 23,
                'capacity'       => 2,
                'bed_type'       => 'double',
                'amenities'      => ['climatisation', 'wifi', 'télévision'],
                'description'    => 'Chambre simple fonctionnelle et lumineuse, idéale pour les séjours courts. Située au second étage, elle offre calme et discrétion à deux pas des commodités de l\'hôtel.',
            ],
        ];

        foreach ($rooms as $data) {
            Room::updateOrCreate(
                ['number' => $data['number']],
                array_merge($data, ['status' => 'libre']),
            );
        }
    }
}
