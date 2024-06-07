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
        Participant::insert(
            [
                [
                    'tournament_id' => '1',
                    'user_id' => '2',
                    'team' => 'A'
                ],
                [
                    'tournament_id' => '1',
                    'user_id' => '3',
                    'team' => 'B'
                ],
                [
                    'tournament_id' => '1',
                    'user_id' => '4',
                    'team' => 'A'
                ],
                [
                    'tournament_id' => '1',
                    'user_id' => '5',
                    'team' => 'B'
                ],
                [
                    'tournament_id' => '2',
                    'user_id' => '6',
                    'team' => 'A'
                ],
                [
                    'tournament_id' => '2',
                    'user_id' => '7',
                    'team' => 'B'
                ],
                [
                    'tournament_id' => '2',
                    'user_id' => '8',
                    'team' => 'A'
                ],
                [
                    'tournament_id' => '2',
                    'user_id' => '9',
                    'team' => 'B'
                ],
                [
                    'tournament_id' => '3',
                    'user_id' => '9',
                    'team' => 'A'
                ],
                [
                    'tournament_id' => '3',
                    'user_id' => '8',
                    'team' => 'A'
                ],
                [
                    'tournament_id' => '3',
                    'user_id' => '7',
                    'team' => 'A'
                ],
                [
                    'tournament_id' => '3',
                    'user_id' => '6',
                    'team' => 'A'
                ],
                [
                    'tournament_id' => '3',
                    'user_id' => '5',
                    'team' => 'B'
                ],
                [
                    'tournament_id' => '3',
                    'user_id' => '4',
                    'team' => 'B'
                ],
                [
                    'tournament_id' => '4',
                    'user_id' => '2',
                    'team' => 'A'
                ],
                [
                    'tournament_id' => '4',
                    'user_id' => '3',
                    'team' => 'B'
                ],
                [
                    'tournament_id' => '4',
                    'user_id' => '4',
                    'team' => 'B'
                ],
                [
                    'tournament_id' => '5',
                    'user_id' => '7',
                    'team' => 'A'
                ],
            ]
        );
    }
}
