<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Raport turnieju</title>
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
    <h1>{{ $tournament->name }}</h1>
    <table>
        <tbody>
            <tr>
                <th>Opis</th>
                <td>{{ $tournament->description }}</td>
            </tr>
            <tr>
                <th>Data</th>
                <td>{{ $tournament->date }}</td>
            </tr>
            <tr>
                <th>Cena</th>
                <td>{{ $tournament->price }}</td>
            </tr>
            <tr>
                <th>Max uczestników w drużynie</th>
                <td>{{ $tournament->max_participants }}</td>
            </tr>
        </tbody>
    </table>
    <h3>Uczestnicy</h3>
    <table>
        <thead>
            <tr>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Username</th>
                <th>Drużyna</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tournament->participants as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->surname }}</td>
                    <td>{{ $p->username }}</td>
                    <td>{{ $p->pivot->team }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
