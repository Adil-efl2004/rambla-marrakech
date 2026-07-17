<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            ['number' => '101', 'floor' => 1, 'type' => 'simple', 'price_per_night' => 450.00, 'wifi_vlan' => 'VLAN10'],
            ['number' => '102', 'floor' => 1, 'type' => 'double', 'price_per_night' => 600.00, 'wifi_vlan' => 'VLAN10'],
            ['number' => '103', 'floor' => 1, 'type' => 'suite',  'price_per_night' => 850.00, 'wifi_vlan' => 'VLAN10'],
            ['number' => '201', 'floor' => 2, 'type' => 'simple', 'price_per_night' => 500.00, 'wifi_vlan' => 'VLAN20'],
            ['number' => '202', 'floor' => 2, 'type' => 'double', 'price_per_night' => 700.00, 'wifi_vlan' => 'VLAN20'],
            ['number' => '203', 'floor' => 2, 'type' => 'suite',  'price_per_night' => 900.00, 'wifi_vlan' => 'VLAN20'],
        ];

        foreach ($rooms as $room) {
            Room::create([
                ...$room,
                'status' => 'libre',
            ]);
        }
    }
}
