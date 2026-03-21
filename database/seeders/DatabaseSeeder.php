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
        DB::table('users')->where('email', 'admin@admin.com')->delete();

        // Crear usuari admin
        \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'admin'
        ]);

        $categories = [
            ['name' => 'Monuments', 'color' => 'red', 'icon' => 'account_balance'],
            ['name' => 'Parcs', 'color' => 'green', 'icon' => 'park'],
            ['name' => 'Museus', 'color' => 'blue', 'icon' => 'museum'],
            ['name' => 'Restaurants', 'color' => 'orange', 'icon' => 'restaurant'],
            ['name' => 'Centres Esportius', 'color' => 'purple', 'icon' => 'fitness_center'],
            ['name' => 'Sense categoria', 'color' => '#64748b', 'icon' => 'help_outline'],
        ];

        $placesArray = [
            // Monuments
            [
                ['name' => "L'Acollidora", 'address' => "Rambla Just Oliveras, L'Hospitalet", 'lat' => 41.3615, 'lng' => 2.1030, 'description' => 'Escultura de bronze de Francisco López, símbol de la benvinguda i hospitalitat de la nostra ciutat.'],
                ['name' => 'Ermita de Bellvitge', 'address' => "Ermita de Bellvitge, L'Hospitalet", 'lat' => 41.3481, 'lng' => 2.1098, 'description' => 'Petita joia del romànic del segle XII, testimoni de la rica història medieval de la zona.'],
                ['name' => 'Castell de Bellvís', 'address' => "Torrassa, L'Hospitalet", 'lat' => 41.3651, 'lng' => 2.1155, 'description' => 'Antiga fortificació medieval que ara forma part del conjunt històric del barri de la Torrassa.'],
                ['name' => 'Creu de la Santa Eulàlia', 'address' => "Plaça de l'Ajuntament, L'Hospitalet", 'lat' => 41.3600, 'lng' => 2.0990, 'description' => 'Monument emblemàtic situat al cor de la ciutat, recordant les tradicions més arrelades.'],
                ['name' => 'El Cap', 'address' => "Plaça Francesc Macià, L'Hospitalet", 'lat' => 41.3630, 'lng' => 2.1120, 'description' => 'Escultura moderna que s\'ha convertit en un punt de referència visual per als vianants de la zona.'],
            ],
            // Parcs
            [
                ['name' => 'Parc de Bellvitge', 'address' => "Bellvitge, L'Hospitalet", 'lat' => 41.3490, 'lng' => 2.1105, 'description' => 'Un gran espai verd ideal per passejar i gaudir de l\'aire lliure en un entorn urbà.'],
                ['name' => 'Parc de les Planes', 'address' => "Les Planes, L'Hospitalet", 'lat' => 41.3695, 'lng' => 2.1120, 'description' => 'Parc amb zones de joc i descans, molt visitat per les famílies del barri.'],
                ['name' => 'Parc de Can Buxeres', 'address' => "Can Buxeres, L'Hospitalet", 'lat' => 41.3640, 'lng' => 2.0965, 'description' => 'Jardins històrics amb un palauet del segle XIX i una gran diversitat botànica.'],
                ['name' => 'Parc de l\'Alhambra', 'address' => "Santa Eulàlia, L'Hospitalet", 'lat' => 41.3670, 'lng' => 2.1320, 'description' => 'Espai de lleure amb fonts i zones d\'ombra, perfecte per a les tardes d\'estiu.'],
                ['name' => 'Parc de la Torrassa', 'address' => "La Torrassa, L'Hospitalet", 'lat' => 41.3685, 'lng' => 2.1225, 'description' => 'Ofereix unes vistes panoràmiques excel·lents de la ciutat i un ambient molt tranquil.'],
            ],
            // Museus
            [
                ['name' => 'Museu de L\'Hospitalet', 'address' => "C/ Joan Pallarès 38, L'Hospitalet", 'lat' => 41.3615, 'lng' => 2.0990, 'description' => 'Sede central del museu a Casa Espanya, dedicada a la història i el patrimoni local.'],
                ['name' => 'Fundació Arranz-Bravo', 'address' => "Av. Josep Tarradellas 44, L'Hospitalet", 'lat' => 41.3645, 'lng' => 2.1025, 'description' => 'Espai d\'art contemporani que acull l\'obra del reconegut artista Arranz-Bravo.'],
                ['name' => 'Tecla Sala', 'address' => "Av. Josep Tarradellas 44, L'Hospitalet", 'lat' => 41.3645, 'lng' => 2.1025, 'description' => 'Centre d\'Art contemporani ubicat en una antiga fàbrica tèxtil rehabilitada.'],
                ['name' => 'Ca n\'Arús', 'address' => "Rambla de la Marina, L'Hospitalet", 'lat' => 41.3580, 'lng' => 2.1010, 'description' => 'Edifici emblemàtic que acull serveis municipals i activitats culturals diverses.'],
                ['name' => 'L\'Harmonia', 'address' => "Plaça Josep Bordonau, L'Hospitalet", 'lat' => 41.3610, 'lng' => 2.0988, 'description' => 'Espai dedicat a la difusió de l\'art i la cultura al casc antic de la ciutat.'],
            ],
            // Restaurants
            [
                ['name' => 'Restaurant La Barca', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3600, 'lng' => 2.1100, 'description' => 'Cuina mediterrània tradicional amb ingredients frescos del mercat local.'],
                ['name' => 'Restaurant El Racó', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3620, 'lng' => 2.1050, 'description' => 'Especialitzat en carns a la brasa i plats típics de la gastronomia catalana.'],
                ['name' => 'Tapas Gaudí', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3640, 'lng' => 2.1150, 'description' => 'Àmplia varietat de tapes creatives en un ambient acollidor i informal.'],
                ['name' => 'Pizzeria Napoletana', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3580, 'lng' => 2.1200, 'description' => 'Autèntiques pureses italianes fetes al forn de llenya amb receptes tradicionals.'],
                ['name' => 'Sushi Club L\'H', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3650, 'lng' => 2.1080, 'description' => 'Cuina japonesa de fusió en un local de disseny modern al centre de la ciutat.'],
            ],
            // Centres Esportius
            [
                ['name' => 'Poliesportiu Bellvitge', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3530, 'lng' => 2.1150, 'description' => 'Instal·lacions esportives completes amb piscines, gimnasos i pistes polivalents.'],
                ['name' => 'Poliesportiu del Centre', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3610, 'lng' => 2.1000, 'description' => 'Equipament esportiu clau al barri centre per a la pràctica de l\'esport federat.'],
                ['name' => 'Estadi de Futbol L\'Hospitalet', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3520, 'lng' => 2.1100, 'description' => 'Seu oficial del Centre d\'Esports L\'Hospitalet amb gespa d\'última generació.'],
                ['name' => 'Piscines Municipals L\'H', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3650, 'lng' => 2.1040, 'description' => 'Complex aquàtic amb piscines olímpiques i espais de relaxació per a tothom.'],
                ['name' => 'Poliesportiu Gornal', 'address' => "L'Hospitalet de Llobregat", 'lat' => 41.3570, 'lng' => 2.1220, 'description' => 'Centre neuràlgic de l\'activitat esportiva al barri del Gornal, totalment equipat.'],
            ],
            // Sense categoria
            []
        ];

        foreach ($categories as $index => $catData) {
            $cat = Category::create($catData);
            $placesObjects = [];
            if (isset($placesArray[$index])) {
                foreach ($placesArray[$index] as $placeData) {
                    $placesObjects[] = [
                        'name' => $placeData['name'],
                        'address' => $placeData['address'],
                        'latitude' => $placeData['lat'],
                        'longitude' => $placeData['lng'],
                        'description' => $placeData['description'],
                        'category_id' => $cat->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
            if (!empty($placesObjects)) {
                Place::insert($placesObjects);
            }
        }
    }
}
