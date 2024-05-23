<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Models\Tournament;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tournaments.index', [
            'tournaments' => Tournament::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentRequest $request)
    {
        $input = $request->all();
        Tournament::create($input);

        return redirect()->route('tournaments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tournament = Tournament::with(['participants', 'answers.user'])->findOrFail($id);

        // Pobierz unikalne nazwy drużyn
        $teams = $tournament->participants->pluck('pivot.team')->unique();

        return view('tournaments.show', ['tournament' => $tournament, 'teams' => $teams]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        return view('tournaments.edit', ['tournament' => $tournament]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTournamentRequest $request, Tournament $tournament)
    {
        // if ($request->user()->cannot('update', $country)) {
        //     abort(403);
        // }

        Gate::authorize('update', $tournament);

        $input = $request->all();
        $tournament->update($input);
        return redirect()->route('tournaments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        $tournament->delete();
        return redirect()->route('tournaments.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeParticipant(Request $request, Tournament $tournament)
    {
        $request->validate([
            'team' => 'required|string|max:20',
        ]);

        $team = $request->input('team');

        if ($tournament->hasReachedMaxTeamSize($team)) {
            return redirect()->route('tournaments.show', $tournament)
                ->withErrors('Drużyna osiągnęła maksymalną liczbę członków.');
        }

        $tournament->participants()->attach(Auth::id(), ['team' => $team]);

        return redirect()->route('tournaments.show', $tournament)
            ->with('success', 'Zapisano do turnieju.');
    }

    public function destroyParticipant(Request $request, Tournament $tournament)
    {
        $tournament->participants()->detach(Auth::id());

        return redirect()->route('tournaments.show', $tournament);
    }
}
