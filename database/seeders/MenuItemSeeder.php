<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imagePaths = [
            'Harira' => 'https://tasteofmaroc.com/wp-content/uploads/2017/05/harira-2-moroccan-soup-picturepartners-bigstock.jpg',
            'Salade César' => 'https://api.allonaya.ma/assets/files/Media/zrEFHaePqyQsCgonD/large/i34581-salade-nicoise-rapide.jpg',
            'Pizza Margherita' => 'https://cdn.colombia.com/gastronomia/2011/08/25/pizza-margarita-3684.jpg',
            'Tajine Poulet' => 'https://www.cuisinejoie.com/wp-content/uploads/2025/11/cuisson-tajine-poulet-marocain.webp',
            'Tarte Tatin' => 'https://www.patisserie-et-gourmandise.com/wp-content/uploads/2018/04/recette-tarte-fraise-2.jpg',
            'Coca-Cola' => 'https://yaseminlife.com/img/987896172.jpg',
            'Jus d\'Orange' => 'https://www.pourquoidocteur.fr/media/article/istock-1492304672-1764503622.jpg',
            'Thé à la menthe' => 'https://gomorocconow.com/fr/wp-content/uploads/2022/05/Moroccan-Mint-Tea-scaled-1.jpeg',
        ];

        $items = [
            ['name' => 'Harira',            'category' => 'entree',   'price' => 35.00,  'description' => 'Soupe traditionnelle marocaine aux lentilles et tomates.'],
            ['name' => 'Salade César',      'category' => 'entree',   'price' => 55.00,  'description' => 'Laitue romaine, croûtons, parmesan et sauce César.'],
            ['name' => 'Tajine Poulet',     'category' => 'plat',     'price' => 95.00,  'description' => 'Poulet mijoté aux olives et citrons confits.'],
            ['name' => 'Pizza Margherita',  'category' => 'plat',     'price' => 80.00,  'description' => 'Tomate, mozzarella fraîche et basilic.'],
            ['name' => 'Tarte Tatin',       'category' => 'dessert',  'price' => 45.00,  'description' => 'Tarte renversée aux pommes caramélisées.'],
            ['name' => 'Jus d\'Orange',     'category' => 'boisson',  'price' => 25.00,  'description' => 'Jus d\'orange fraîchement pressé.'],
            ['name' => 'Coca-Cola',         'category' => 'boisson',  'price' => 20.00,  'description' => 'Canette 33 cl, servie bien fraîche.'],
            ['name' => 'Thé à la menthe',   'category' => 'boisson',  'price' => 30.00,  'description' => 'Thé vert à la menthe fraîche, service marocain.'],
        ];

        foreach ($items as $item) {
            MenuItem::updateOrCreate(
                ['name' => $item['name']],
                [
                    ...$item,
                    'image_path' => $imagePaths[$item['name']] ?? null,
                    'is_available' => true,
                ]
            );
        }
    }
}
