<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Raport statystyk</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Raport statystyk</h1>

    @php($scope = $filters['scope'] ?? 'all')
    @php($scopeLabel = $scope === 'future' ? 'tylko przyszłe' : ($scope === 'past' ? 'tylko przeszłe' : 'wszystkie'))

    <p>
        Filtry:
        rok={{ $filters['year'] ?? '-' }},
        od={{ $filters['date_from'] ?? '-' }},
        do={{ $filters['date_to'] ?? '-' }},
        cena_min={{ $filters['price_min'] ?? '-' }},
        cena_max={{ $filters['price_max'] ?? '-' }},
        zakres={{ $scopeLabel }}
    </p>

    <h3>Liczba turniejów na miesiąc</h3>
    <table>
        <thead>
            <tr>
                <th>Miesiąc</th>
                <th>Liczba</th>
            </tr>
        </thead>
        <tbody>
            @for ($m = 1; $m <= 12; $m++)
                <tr>
                    <td>{{ $m }}</td>
                    <td>{{ $matchesPerMonth[$m] ?? 0 }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <h3>Średnia cena wejść na miesiąc</h3>
    <table>
        <thead>
            <tr>
                <th>Miesiąc</th>
                <th>Średnia cena</th>
            </tr>
        </thead>
        <tbody>
            @for ($m = 1; $m <= 12; $m++)
                <tr>
                    <td>{{ $m }}</td>
                    <td>{{ number_format($averagePricePerMonth[$m] ?? 0, 2, ',', ' ') }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <h3>Podsumowania</h3>
    <table>
        <tbody>
            <tr>
                <th>Mediana członków drużyn</th>
                <td>{{ $participantsPerTeam }}</td>
            </tr>
            <tr>
                <th>Odchylenie standardowe ceny</th>
                <td>{{ number_format($priceStdDeviation, 2, ',', ' ') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
