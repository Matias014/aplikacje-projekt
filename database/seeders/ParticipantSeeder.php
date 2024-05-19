<?php

namespace Database\Seeders;

use App\Models\Participant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Participant::insert(
            [
                [
                    'tournament_id' => '1',
                    'user_id' => '2',
                    'team' => 'Alfa'
                ],
                [
                    'tournament_id' => '2',
                    'user_id' => '3',
                    'team' => 'Delta'
                ],
                [
                    'tournament_id' => '1',
                    'user_id' => '4',
                    'team' => 'Alfa'
                ],
                [
                    'tournament_id' => '2',
                    'user_id' => '5',
                    'team' => 'Beta'
                ],
                [
                    'tournament_id' => '1',
                    'user_id' => '6',
                    'team' => 'Beta'
                ],
                [
                    'tournament_id' => '2',
                    'user_id' => '7',
                    'team' => 'Gamma'
                ],
                [
                    'tournament_id' => '1',
                    'user_id' => '8',
                    'team' => 'Beta'
                ],
                [
                    'tournament_id' => '2',
                    'user_id' => '9',
                    'team' => 'Beta'
                ],
            ]
        );
    }
}