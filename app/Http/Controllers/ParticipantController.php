<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Tournament;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ParticipantController extends Controller
{
    public function store(Request $request, Tournament $tournament)
    {
        Gate::authorize('create', [Participant::class, $tournament]);

        $request->validate([
            'team' => 'required|string|in:A,B|max:20',
        ]);

        if ($tournament->date <= now()) {
            return redirect()->route('tournaments.show', $tournament)->withErrors('Nie można zapisać się na turniej, który już się odbył.');
        }

        if ($tournament->participants->contains(Auth::id())) {
            return redirect()->route('tournaments.show', $tournament)->withErrors('Jesteś już zapisany na ten turniej.');
        }

        $team = $request->input('team');
        $teamCount = $tournament->participants()->wherePivot('team', $team)->count();
        $maxTeamSize = (int) $tournament->getAttribute('max_participants');

        if ($teamCount >= $maxTeamSize) {
            return redirect()->route('tournaments.show', $tournament)->withErrors('Drużyna osiągnęła maksymalną liczbę członków.');
        }

        $tournament->participants()->attach(Auth::id(), ['team' => $team]);
        ActivityLogger::log('participant.join', $tournament);

        return redirect()->route('tournaments.show', $tournament)->with('success', 'Zapisano do turnieju.');
    }

    public function destroy(Tournament $tournament, $participantId)
    {
        $participant = Participant::query()
            ->where('tournament_id', $tournament->id)
            ->where('user_id', $participantId)
            ->first();

        if (!$participant) {
            return redirect()->route('tournaments.show', $tournament)->withErrors('Uczestnik nie został znaleziony.');
        }

        Gate::authorize('delete', [$participant, $tournament]);

        if ($tournament->date <= now()) {
            return redirect()->route('tournaments.show', $tournament)->withErrors('Nie można usuwać uczestników z turnieju, który już się odbył.');
        }

        $participant->delete();
        ActivityLogger::log('participant.leave', $tournament);

        return redirect()->route('tournaments.show', $tournament)->with('success', 'Uczestnik został usunięty.');
    }
}
