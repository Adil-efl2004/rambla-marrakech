<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomPhoto;
use Illuminate\Database\Seeder;

class RoomPhotoSeeder extends Seeder
{
    /**
     * URLs par type de chambre, indexées par position.
     *
     * @var array<string, array<int, string>>
     */
    private array $photosByType = [
        'simple' => [
            0 => 'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg',
            1 => 'https://images.pexels.com/photos/18201945/pexels-photo-18201945.jpeg',
        ],
        'double' => [
            0 => 'https://images.pexels.com/photos/36852547/pexels-photo-36852547.jpeg',
            1 => 'https://images.pexels.com/photos/34763215/pexels-photo-34763215.jpeg',
        ],
        'suite' => [
            0 => 'https://images.pexels.com/photos/10890710/pexels-photo-10890710.jpeg',
            1 => 'https://images.pexels.com/photos/34645114/pexels-photo-34645114.jpeg',
        ],
    ];

    public function run(): void
    {
        Room::all()->each(function (Room $room) {
            $photos = $this->photosByType[$room->type] ?? null;

            if ($photos === null) {
                return; // type inconnu, on ignore
            }

            foreach ($photos as $position => $url) {
                RoomPhoto::updateOrCreate(
                    [
                        'room_id'  => $room->id,
                        'position' => $position,
                    ],
                    [
                        'url' => $url,
                    ]
                );
            }
        });
    }
}
