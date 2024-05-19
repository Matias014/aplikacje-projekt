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
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in placerat sapien. Suspendisse facilisis libero eros, eget consectetur risus accumsan eu. Fusce commodo pretium risus, vitae rutrum erat tristique eget. Curabitur sed bibendum sapien vel. ',
                    'date' => '2024-05-31 12:00:00',
                    'price' => '30',
                    'img' => 'turniej1.jpg'
                ],
                [
                    'name' => 'Turniej młodzieżowy',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in placerat sapien. Suspendisse facilisis libero eros, eget consectetur risus accumsan eu. Fusce commodo pretium risus, vitae rutrum erat tristique eget. Curabitur sed bibendum sapien vel. ',
                    'date' => '2024-06-30 13:00:00',
                    'price' => '20',
                    'img' => 'turniej2.jpg'
                ]
            ]
        );
    }
}
