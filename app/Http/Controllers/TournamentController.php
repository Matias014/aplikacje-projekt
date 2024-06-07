<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentDate = now();
        $upcomingTournaments = Tournament::where('date', '>', $currentDate)->get();
        $pastTournaments = Tournament::where('date', '<=', $currentDate)->get();

        return view('tournaments.index', [
            'upcomingTournaments' => $upcomingTournaments,
            'pastTournaments' => $pastTournaments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Tournament::class);

        return view('admin.tournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentRequest $request)
    {
        Gate::authorize('create', Tournament::class);

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

        $teams = $tournament->participants->groupBy('pivot.team');

        $maxParticipants = $tournament->max_participants;

        return view('tournaments.show', [
            'tournament' => $tournament,
            'teams' => $teams,
            'maxParticipants' => $maxParticipants
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        Gate::authorize('update', $tournament);

        return view('admin.tournaments.edit', ['tournament' => $tournament]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTournamentRequest $request, Tournament $tournament)
    {
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
        Gate::authorize('delete', $tournament);

        $tournament->delete();
        return redirect()->route('tournaments.index');
    }

    public function statistics()
    {
        $currentYear = now()->year;

        // Liczba meczy w każdym miesiącu
        $matchesPerMonth = Tournament::select(DB::raw('MONTH(date) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('date', '=', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Średnia cena w każdym miesiącu
        $averagePricePerMonth = Tournament::select(DB::raw('MONTH(date) as month'), DB::raw('AVG(price) as avg_price'))
            ->whereYear('date', '=', $currentYear)
            ->groupBy('month')
            ->pluck('avg_price', 'month')
            ->toArray();

        // Mediana max_participants
        $maxParticipantsValues = Tournament::pluck('max_participants')->toArray();
        sort($maxParticipantsValues);
        $count = count($maxParticipantsValues);
        $middle = floor(($count - 1) / 2);
        $participantsPerTeam = ($count % 2) ? $maxParticipantsValues[$middle] : ($maxParticipantsValues[$middle] + $maxParticipantsValues[$middle + 1]) / 2;

        // Odchylenie standardowe ceny wejść
        $averagePriceOverall = Tournament::avg('price');
        $priceVariance = Tournament::select(DB::raw('avg(pow(price - ' . $averagePriceOverall . ', 2)) as variance'))
            ->first()
            ->variance;
        $priceStdDeviation = sqrt($priceVariance);

        return view('index', [
            'matchesPerMonth' => $matchesPerMonth,
            'averagePricePerMonth' => $averagePricePerMonth,
            'participantsPerTeam' => $participantsPerTeam,
            'priceStdDeviation' => $priceStdDeviation,
        ]);
    }
}
