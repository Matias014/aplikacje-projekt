<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Answer::insert(
            [
                [
                    'user_id' => '2',
                    'tournament_id' => '1',
                    'answer' => 'Mam zamiar wygrać pierwsze miejsce!'
                ],
                [
                    'user_id' => '3',
                    'tournament_id' => '1',
                    'answer' => 'Hmm, powodzenia!'
                ],
                [
                    'user_id' => '6',
                    'tournament_id' => '2',
                    'answer' => 'Ciekawe, czy pogoda będzie dobra w dniu turnieju.'
                ],
            ]
        );
    }
}
