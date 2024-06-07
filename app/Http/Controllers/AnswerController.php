<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AnswerController extends Controller
{
    public function store(Request $request, Tournament $tournament)
    {
        Gate::authorize('create', [Answer::class, $tournament]);

        $request->validate([
            'answer' => 'required|string|max:500',
        ]);

        if (!$tournament->participants->contains(Auth::id())) {
            return redirect()->route('tournaments.show', $tournament)->withErrors('Nie jesteś zarejestrowany na ten turniej.');
        }

        Answer::create([
            'user_id' => Auth::id(),
            'tournament_id' => $tournament->id,
            'answer' => $request->input('answer'),
        ]);

        return redirect()->route('tournaments.show', $tournament)->with('success', 'Komentarz został dodany.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        if (Gate::denies('update', $answer)) {
            return redirect()->route('tournaments.show', $answer->tournament_id)->withErrors('Nie możesz zaktualizować tego komentarza.');
        }

        $request->validate([
            'answer' => 'required|string|max:500',
        ]);

        if (!Auth::user()->role == "admin" && $answer->user_id !== Auth::id()) {
            return redirect()->route('tournaments.show', $answer->tournament_id)->withErrors('Nie możesz zaktualizować ten komentarz.');
        }

        $answer->update([
            'answer' => $request->input('answer'),
        ]);

        return redirect()->route('tournaments.show', $answer->tournament_id)->with('success', 'Komentarz został zaktualizowany.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        if (Gate::denies('delete', $answer)) {
            return redirect()->route('tournaments.show', $answer->tournament_id)->withErrors('Nie możesz usunąć tego komentarza.');
        }

        if (!Auth::user()->role == "admin" && $answer->user_id !== Auth::id()) {
            return redirect()->route('tournaments.show', $answer->tournament_id)->withErrors('Nie możesz usunąć ten komentarz.');
        }

        $answer->delete();
        return redirect()->route('tournaments.show', $answer->tournament_id)->with('success', 'Komentarz został usunięty.');
    }
}
