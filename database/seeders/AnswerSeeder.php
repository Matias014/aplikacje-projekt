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
                    'answer' => 'Powodzenia!'
                ],
                [
                    'user_id' => '6',
                    'tournament_id' => '2',
                    'answer' => 'Ciekawe, czy pogoda będzie dobra w dniu turnieju.'
                ],
                [
                    'user_id' => '6',
                    'tournament_id' => '3',
                    'answer' => 'Mam nadzieję, że zabawa będzie ekstra :D'
                ],
                [
                    'user_id' => '7',
                    'tournament_id' => '3',
                    'answer' => 'Oby, zapowiada się na mega ciekawy turniej.'
                ],
                [
                    'user_id' => '8',
                    'tournament_id' => '3',
                    'answer' => 'Powodzenia tam, na turnieju!.'
                ],
                [
                    'user_id' => '4',
                    'tournament_id' => '4',
                    'answer' => 'Hmm, ciekawe, ile osób będzie brało udzial w tym turnieju.'
                ],
            ]
        );
    }
}
