<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Tournament;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function index()
    {
        return view('tournaments.index', [
            'tournaments' => Answer::all()
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
    public function store(Request $request, Tournament $tournament)
    {
        $request->validate([
            'answer' => 'required|string|max:500',
        ]);

        Answer::create([
            'user_id' => Auth::id(),
            'tournament_id' => $tournament->id,
            'answer' => $request->input('answer'),
        ]);

        return redirect()->route('tournament.show', $tournament)->with('success', 'Komentarz został dodany.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tournament = Answer::with('participants')->findOrFail($id);
        return view('tournaments.show', compact('tournament'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $tournament)
    {
        return view('tournaments.edit', ['tournament' => $tournament]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTournamentRequest $request, Answer $answer)
    {
        // if ($request->user()->cannot('update', $country)) {
        //     abort(403);
        // }

        Gate::authorize('update', $answer);

        $input = $request->all();
        $answer->update($input);
        return redirect()->route('tournaments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $tournament)
    {
        $tournament->delete();
        return redirect()->route('tournaments.index');
    }
}
