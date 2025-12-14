<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatisticsFilterRequest;
use App\Http\Requests\StatisticsImageRequest;
use App\Models\Tournament;
use App\Services\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function statisticsPage(StatisticsFilterRequest $request)
    {
        $filters = $this->normalizeFilters($request->validated());
        $data = $this->buildStats($filters);

        return view('reports.statistics_page', $data);
    }

    public function statisticsPdf(StatisticsFilterRequest $request)
    {
        $filters = $this->normalizeFilters($request->validated());
        $data = $this->buildStats($filters);

        ActivityLogger::log('report.statistics.pdf');
        $pdf = Pdf::loadView('reports.statistics', $data)->setPaper('a4', 'portrait');

        return $pdf->download('raport-statystyki.pdf');
    }

    public function tournamentPdf(Tournament $tournament)
    {
        $tournament->load(['participants', 'answers.user']);
        ActivityLogger::log('report.tournament.pdf', $tournament);
        $pdf = Pdf::loadView('reports.tournament', ['tournament' => $tournament])->setPaper('a4', 'portrait');
        return $pdf->download('raport-turniej-' . $tournament->id . '.pdf');
    }

    public function statisticsImage(StatisticsImageRequest $request)
    {
        $format = $request->input('format');
        $mime = $format === 'png' ? 'image/png' : 'image/jpeg';

        $nameRaw = $request->input('name');
        $name = preg_replace('/[^a-zA-Z0-9 _-]/', '_', $nameRaw);
        $name = trim(preg_replace('/\s+/', ' ', $name));
        if ($name === '') {
            abort(422);
        }

        $image = $request->input('image');

        $prefix = 'data:' . $mime . ';base64,';
        if (strpos($image, $prefix) !== 0) {
            abort(422);
        }

        $content = substr($image, strlen($prefix));
        $binary = base64_decode($content, true);
        if ($binary === false) {
            abort(422);
        }

        if (strlen($binary) > 5 * 1024 * 1024) {
            abort(422);
        }

        ActivityLogger::log('report.statistics.image.' . $format);

        $filename = $name . '.' . ($format === 'png' ? 'png' : 'jpg');

        return response($binary, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function normalizeFilters(array $filters): array
    {
        $scope = $filters['scope'] ?? null;

        if ($scope === null) {
            if (array_key_exists('include_past', $filters) && $filters['include_past'] !== null) {
                $scope = $filters['include_past'] ? 'all' : 'future';
            } else {
                $scope = 'all';
            }
        }

        $includePast = $scope !== 'future';

        return [
            'year' => (int)($filters['year'] ?? now()->year),
            'date_from' => $filters['date_from'] ?? null,
            'date_to' => $filters['date_to'] ?? null,
            'price_min' => array_key_exists('price_min', $filters) ? $filters['price_min'] : null,
            'price_max' => array_key_exists('price_max', $filters) ? $filters['price_max'] : null,
            'scope' => $scope,
            'include_past' => $includePast,
        ];
    }

    private function buildStats(array $filters): array
    {
        $year = (int)$filters['year'];
        $dateFrom = $filters['date_from'];
        $dateTo = $filters['date_to'];
        $priceMin = $filters['price_min'];
        $priceMax = $filters['price_max'];
        $scope = $filters['scope'];
        $includePast = (bool)($filters['include_past'] ?? ($scope !== 'future'));

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
        $participantsPerTeam = $count ? (($count % 2) ? $maxParticipantsValues[$middle] : ($maxParticipantsValues[$middle] + $maxParticipantsValues[$middle + 1]) / 2) : 0;

        $avg = (float)((clone $base)->avg('price') ?: 0);
        $variance = (float)((clone $base)->selectRaw('AVG(POW(price - ?, 2)) as variance', [$avg])->value('variance') ?: 0);
        $std = $variance > 0 ? sqrt($variance) : 0;

        return [
            'matchesPerMonth' => $matchesPerMonth,
            'averagePricePerMonth' => $averagePricePerMonth,
            'participantsPerTeam' => $participantsPerTeam,
            'priceStdDeviation' => $std,
            'filters' => [
                'year' => $year,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'price_min' => $priceMin,
                'price_max' => $priceMax,
                'scope' => $scope,
                'include_past' => $includePast,
            ],
        ];
    }
}
