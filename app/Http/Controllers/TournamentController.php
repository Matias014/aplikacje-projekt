<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        return view('admin.tournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('storage/img'), $imageName);

            $input['img'] = $imageName;
        }

        Tournament::create($input);

        return redirect()->route('tournaments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tournament = Tournament::with(['participants', 'answers.user'])->findOrFail($id);

        // $teams = $tournament->participants->pluck('pivot.team')->unique(); // do poprawy koniecznie!!!!!!!!!!

        return view('tournaments.show', ['tournament' => $tournament, 'teams' => ['A', 'B']]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        if (!Gate::allows('is-admin')) {
            // abort(403);
            return view('errors.403');
        }
        return view('admin.tournaments.edit', ['tournament' => $tournament]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTournamentRequest $request, Tournament $tournament)
    {
        if (!Gate::allows('is-admin')) {
            abort(403);
        }

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

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function storeParticipant(Request $request, Tournament $tournament)
    // {
    //     $request->validate([
    //         'team' => 'required|string|max:20',
    //     ]);

    //     $team = $request->input('team');

    //     // Pobieramy ilość graczy w danej drużynie
    //     $teamCount = $tournament->participants()->wherePivot('team', $team)->count();

    //     // Pobieramy maksymalną ilość graczy dla danej drużyny z atrybutów turnieju
    //     $maxTeamSize = $tournament->getAttribute("max_team_$team");

    //     if ($teamCount >= $maxTeamSize) {
    //         return redirect()->route('tournaments.show', $tournament)
    //             ->withErrors('Drużyna osiągnęła maksymalną liczbę członków.');
    //     }

    //     // Dodajemy uczestnika do turnieju z odpowiednią drużyną
    //     $tournament->participants()->attach(Auth::id(), ['team' => $team]);

    //     return redirect()->route('tournaments.show', $tournament)
    //         ->with('success', 'Zapisano do turnieju.');
    // }


    // public function destroyParticipant(Tournament $tournament, User $participant)
    // {
    //     $tournament->participants()->detach($participant->id);

    //     return redirect()->route('tournaments.show', $tournament);
    // }
}
