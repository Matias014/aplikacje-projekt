<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Http\Requests\StatisticsFilterRequest;
use App\Models\Tournament;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TournamentController extends Controller
{
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

    public function create()
    {
        Gate::authorize('create', Tournament::class);
        return view('admin.tournaments.create');
    }

    public function store(StoreTournamentRequest $request)
    {
        Gate::authorize('create', Tournament::class);

        $input = $request->all();

        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('storage/img'), $imageName);
            $input['img'] = $imageName;
        }

        $tournament = Tournament::create($input);
        ActivityLogger::log('tournament.create', $tournament);

        return redirect()->route('tournaments.index');
    }

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

    public function edit(Tournament $tournament)
    {
        Gate::authorize('update', $tournament);
        return view('admin.tournaments.edit', ['tournament' => $tournament]);
    }

    public function update(UpdateTournamentRequest $request, Tournament $tournament)
    {
        Gate::authorize('update', $tournament);

        $input = $request->all();

        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('storage/img'), $imageName);
            $input['img'] = $imageName;
        }

        $tournament->update($input);
        ActivityLogger::log('tournament.update', $tournament);

        return redirect()->route('tournaments.index');
    }

    public function destroy(Tournament $tournament)
    {
        Gate::authorize('delete', $tournament);
        $id = $tournament->id;
        $tournament->delete();
        ActivityLogger::log('tournament.delete', (new Tournament(['id' => $id])));
        return redirect()->route('tournaments.index');
    }

    public function statistics(StatisticsFilterRequest $request)
    {
        $v = $request->validated();

        $scope = $v['scope'] ?? null;
        if ($scope === null) {
            if (array_key_exists('include_past', $v) && $v['include_past'] !== null) {
                $scope = $v['include_past'] ? 'all' : 'future';
            } else {
                $scope = 'all';
            }
        }
        $includePast = $scope !== 'future';

        $year = (int)($v['year'] ?? now()->year);
        $dateFrom = $v['date_from'] ?? null;
        $dateTo = $v['date_to'] ?? null;
        $priceMin = array_key_exists('price_min', $v) ? $v['price_min'] : null;
        $priceMax = array_key_exists('price_max', $v) ? $v['price_max'] : null;

        $q = Tournament::query();

        if ($dateFrom) {
            $q->whereDate('date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $q->whereDate('date', '<=', $dateTo);
        }

        if (!$dateFrom && !$dateTo) {
            $q->whereYear('date', '=', $year);
        }

        if ($scope === 'future') {
            $q->where('date', '>', now());
        }

        if ($scope === 'past') {
            $q->where('date', '<=', now());
        }

        if ($priceMin !== null) {
            $q->where('price', '>=', (float)$priceMin);
        }

        if ($priceMax !== null) {
            $q->where('price', '<=', (float)$priceMax);
        }

        $base = clone $q;

        $matchesPerMonth = (clone $q)
            ->select(DB::raw('MONTH(date) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $averagePricePerMonth = (clone $q)
            ->select(DB::raw('MONTH(date) as month'), DB::raw('AVG(price) as avg_price'))
            ->groupBy('month')
            ->pluck('avg_price', 'month')
            ->toArray();

        $maxParticipantsValues = (clone $base)->pluck('max_participants')->toArray();
        sort($maxParticipantsValues);
        $count = count($maxParticipantsValues);
        $middle = $count ? (int)floor(($count - 1) / 2) : 0;
        $participantsPerTeam = $count ? (($count % 2) ? $maxParticipantsValues[$middle] : ($maxParticipantsValues[$middle + 1] + $maxParticipantsValues[$middle]) / 2) : 0;

        $avg = (float)((clone $base)->avg('price') ?: 0);
        $variance = (float)((clone $base)->selectRaw('AVG(POW(price - ?, 2)) as variance', [$avg])->value('variance') ?: 0);
        $priceStdDeviation = $variance > 0 ? sqrt($variance) : 0;

        return view('index', [
            'matchesPerMonth' => $matchesPerMonth,
            'averagePricePerMonth' => $averagePricePerMonth,
            'participantsPerTeam' => $participantsPerTeam,
            'priceStdDeviation' => $priceStdDeviation,
            'filters' => [
                'year' => $year,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'price_min' => $priceMin,
                'price_max' => $priceMax,
                'scope' => $scope,
                'include_past' => $includePast,
            ],
        ]);
    }
}
