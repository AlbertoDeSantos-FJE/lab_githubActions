<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Place;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar para asegurar idempotencia
        Place::query()->delete();
        Category::query()->delete();

        $categories = [
            ['name' => 'Monuments', 'color' => 'red', 'icon' => 'account_balance'],
            ['name' => 'Parcs', 'color' => 'green', 'icon' => 'park'],
            ['name' => 'Museus', 'color' => 'blue', 'icon' => 'museum'],
            ['name' => 'Restaurants', 'color' => 'orange', 'icon' => 'restaurant'],
            ['name' => 'Centres Esportius', 'color' => 'purple', 'icon' => 'fitness_center'],
        ];

        $placesArray = [
            // Monuments
            [
                ['name' => "L'Acollidora", 'address' => "Rambla Just Oliveras, L'Hospitalet", 'lat' => 41.3615, 'lng' => 2.1030],
                ['name' => 'Ermita de Bellvitge', 'address' => "Ermita de Bellvitge, L'Hospitalet", 'lat' => 41.3481, 'lng' => 2.1098],
                ['name' => 'Castell de Bellvís', 'address' => "Torrassa, L'Hospitalet", 'lat' => 41.3651, 'lng' => 2.1155],
                ['name' => 'Creu de la Santa Eulàlia', 'address' => "Plaça de l'Ajuntament, L'Hospitalet", 'lat' => 41.3600, 'lng' => 2.0990],
                ['name' => 'El Cap', 'address' => "Plaça Francesc Macià, L'Hospitalet", 'lat' => 41.3630, 'lng' => 2.1120],
            ],
            // Parcs
            [
                ['name' => 'Parc de Bellvitge', 'address' => "Bellvitge, L'Hospitalet", 'lat' => 41.3490, 'lng' => 2.1105],
                ['name' => 'Parc de les Planes', 'address' => "Les Planes, L'Hospitalet", 'lat' => 41.3695, 'lng' => 2.1120],
                ['name' => 'Parc de Can Buxeres', 'address' => "Can Buxeres, L'Hospitalet", 'lat' => 41.3640, 'lng' => 2.0965],
                ['name' => 'Parc de l\'Alhambra', 'address' => "Santa Eulàlia, L'Hospitalet", 'lat' => 41.3670, 'lng' => 2.1320],
                ['name' => 'Parc de la Torrassa', 'address' => "La Torrassa, L'Hospitalet", 'lat' => 41.3685, 'lng' => 2.1225],
            ],
            // Museus
            [
                ['name' => 'Museu de L\'Hospitalet', 'address' => "C/ Joan Pallarès 38, L'Hospitalet", 'lat' => 41.3615, 'lng' => 2.0990],
                ['name' => 'Fundació Arranz-Bravo', 'address' => "Av. Josep Tarradellas 44, L'Hospitalet", 'lat' => 41.3645, 'lng' => 2.1025],
                ['name' => 'Tecla Sala', 'address' => "Av. Josep Tarradellas 44, L'Hospitalet", 'lat' => 41.3645, 'lng' => 2.1025],
                ['name' => 'Ca n\'Arús', 'address' => "Rambla de la Marina, L'Hospitalet", 'lat' => 41.3580, 'lng' => 2.1010],
                ['name' => 'L\'Harmonia', 'address' => "Plaça Josep Bordonau, L'Hospitalet", 'lat' => 41.3610, 'lng' => 2.0988],
            ],
            // Restaurants
            [
                ['name' => 'Restaurant La Barca', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3600, 'lng' => 2.1100],
                ['name' => 'Restaurant El Racó', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3620, 'lng' => 2.1050],
                ['name' => 'Tapas Gaudí', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3640, 'lng' => 2.1150],
                ['name' => 'Pizzeria Napoletana', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3580, 'lng' => 2.1200],
                ['name' => 'Sushi Club L\'H', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3650, 'lng' => 2.1080],
            ],
            // Centres Esportius
            [
                ['name' => 'Poliesportiu Bellvitge', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3530, 'lng' => 2.1150],
                ['name' => 'Poliesportiu del Centre', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3610, 'lng' => 2.1000],
                ['name' => 'Estadi de Futbol L\'Hospitalet', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3520, 'lng' => 2.1100],
                ['name' => 'Piscines Municipals L\'H', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3650, 'lng' => 2.1040],
                ['name' => 'Poliesportiu Gornal', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3570, 'lng' => 2.1220],
            ]
        ];

        foreach ($categories as $index => $catData) {
            $cat = Category::create($catData);
            $placesObjects = [];
            foreach ($placesArray[$index] as $placeData) {
                $placesObjects[] = [
                    'name' => $placeData['name'],
                    'address' => $placeData['address'],
                    'latitude' => $placeData['lat'],
                    'longitude' => $placeData['lng'],
                    'description' => 'Un lloc interessant a L\'Hospitalet de Llobregat',
                    'category_id' => $cat->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            Place::insert($placesObjects);
        }
    }
}
