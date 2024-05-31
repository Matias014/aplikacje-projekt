<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Tournament;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    public function store(Request $request, Tournament $tournament)
    {
        $request->validate([
            'team' => 'required|string|max:20',
        ]);

        $team = $request->input('team');

        // Pobieramy ilość graczy w danej drużynie
        $teamCount = $tournament->participants()->wherePivot('team', $team)->count();

        // Pobieramy maksymalną ilość graczy dla danej drużyny z atrybutów turnieju
        $maxTeamSize = $tournament->getAttribute("max_team_$team");

        if ($teamCount >= $maxTeamSize) {
            return redirect()->route('tournaments.show', $tournament)
                ->withErrors('Drużyna osiągnęła maksymalną liczbę członków.');
        }

        // Dodajemy uczestnika do turnieju z odpowiednią drużyną
        $tournament->participants()->attach(Auth::id(), ['team' => $team]);

        return redirect()->route('tournaments.show', $tournament)
            ->with('success', 'Zapisano do turnieju.');
    }

    public function destroy(Tournament $tournament, Participant $participant)
    {
        $tournament->participants()->detach($participant->id);

        return redirect()->route('tournaments.show', $tournament);
    }
}
