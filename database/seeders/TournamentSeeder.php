<?php

namespace Database\Seeders;

use App\Models\Tournament;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            Tournament::truncate();
        });

        Tournament::insert(
            [
                [
                    'name' => 'Turniej o tytuł mistrza paintballa',
                    'description' => 'Dołącz do najbardziej prestiżowego turnieju paintballowego tego sezonu i walcz o tytuł mistrza! Zapewniamy niezapomniane emocje, zaciętą rywalizację i wspaniałe nagrody. Zarezerwuj miejsce dla swojej drużyny już dziś!',
                    'date' => '2024-05-31 12:00:00',
                    'price' => '30',
                    'img' => 'turniej1.jpg',
                    'max_team_A' => '10',
                    'max_team_B' => '10'
                ],
                [
                    'name' => 'Turniej młodzieżowy',
                    'description' => 'Zapraszamy młodzież na ekscytujący turniej paintballowy! To doskonała okazja, aby sprawdzić swoje umiejętności, poznać nowych przyjaciół i świetnie się bawić. Przygotowaliśmy mnóstwo atrakcji i nagrody dla najlepszych zespołów!',
                    'date' => '2024-06-30 13:00:00',
                    'price' => '20',
                    'img' => 'turniej2.jpg',
                    'max_team_A' => '10',
                    'max_team_B' => '10'
                ]
            ]
        );
    }
}
