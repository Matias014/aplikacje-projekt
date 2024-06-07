<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ParticipantController extends Controller
{
    public function store(Request $request, Tournament $tournament)
    {
        if (Gate::denies('create', [Participant::class, $tournament])) {
            return redirect()->route('tournaments.show', $tournament)->withErrors('Nie masz uprawnień do zapisania się na ten turniej.');
        }

        $request->validate([
            'team' => 'required|string|in:A,B|max:20',
        ]);

        if ($tournament->date <= now()) {
            return redirect()->route('tournaments.show', $tournament)
                ->withErrors('Nie można zapisać się na turniej, który już się odbył.');
        }

        $team = $request->input('team');
        $teamCount = $tournament->participants()->wherePivot('team', $team)->count();
        $maxTeamSize = $tournament->getAttribute("max_participants");

        if ($teamCount >= $maxTeamSize) {
            return redirect()->route('tournaments.show', $tournament)
                ->withErrors('Drużyna osiągnęła maksymalną liczbę członków.');
        }

        $tournament->participants()->attach(Auth::id(), ['team' => $team]);

        return redirect()->route('tournaments.show', $tournament)
            ->with('success', 'Zapisano do turnieju.');
    }

    public function destroy(Tournament $tournament, $participantId)
    {
        $participant = $tournament->participants()->wherePivot('user_id', $participantId)->first();

        if (!$participant) {
            return redirect()->route('tournaments.show', $tournament)->withErrors('Uczestnik nie został znaleziony.');
        }

        if (Gate::denies('delete', [$participant, $tournament])) {
            return redirect()->route('tournaments.show', $tournament)->withErrors('Nie masz uprawnień do usunięcia tego uczestnika.');
        }

        if ($tournament->date <= now()) {
            return redirect()->route('tournaments.show', $tournament)->withErrors('Nie można usuwać uczestników z turnieju, który już się odbył.');
        }

        $tournament->participants()->detach($participantId);

        return redirect()->route('tournaments.show', $tournament)->with('success', 'Uczestnik został usunięty.');
    }
}
