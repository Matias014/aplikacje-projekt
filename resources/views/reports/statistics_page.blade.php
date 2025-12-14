@include('shared.html')

@include('shared.head', ['pageTitle' => 'Raporty i eksport'])

<body class="d-flex flex-column min-vh-100">
    @include('shared.navbar')

    <main class="flex-grow-1">
        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    <div class="card shadow-sm">
                        <div
                            class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                            <h1 class="m-0 fs-4">Raporty i eksport statystyk</h1>
                            <a class="btn btn-outline-secondary" href="{{ route('users.show', Auth::user()->id) }}">Wróć
                                do konta</a>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('account.reports.statistics') }}" id="reportForm"
                                class="row g-3">
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="year">Rok</label>
                                    <input id="year" type="number" name="year"
                                        class="form-control @error('year') is-invalid @enderror" min="2000"
                                        max="{{ now()->year + 1 }}" value="{{ $filters['year'] ?? now()->year }}">
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="date_from">Data od</label>
                                    <input id="date_from" type="date" name="date_from"
                                        class="form-control @error('date_from') is-invalid @enderror"
                                        value="{{ $filters['date_from'] ?? '' }}">
                                    @error('date_from')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="date_to">Data do</label>
                                    <input id="date_to" type="date" name="date_to"
                                        class="form-control @error('date_to') is-invalid @enderror"
                                        value="{{ $filters['date_to'] ?? '' }}">
                                    @error('date_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="scope">Zakres</label>
                                    <select id="scope" name="scope"
                                        class="form-select @error('scope') is-invalid @enderror">
                                        <option value="all" @if (($filters['scope'] ?? 'all') === 'all') selected @endif>
                                            Wszystkie</option>
                                        <option value="future" @if (($filters['scope'] ?? 'all') === 'future') selected @endif>Tylko
                                            przyszłe</option>
                                        <option value="past" @if (($filters['scope'] ?? 'all') === 'past') selected @endif>Tylko
                                            przeszłe</option>
                                    </select>
                                    @error('scope')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="price_min">Cena min</label>
                                    <div class="input-group">
                                        <input id="price_min" type="number" step="0.01" min="0"
                                            max="100000" name="price_min" inputmode="decimal"
                                            class="form-control @error('price_min') is-invalid @enderror"
                                            value="{{ $filters['price_min'] ?? '' }}">
                                        <span class="input-group-text">PLN</span>
                                        @error('price_min')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="price_max">Cena max</label>
                                    <div class="input-group">
                                        <input id="price_max" type="number" step="0.01" min="0"
                                            max="100000" name="price_max" inputmode="decimal"
                                            class="form-control @error('price_max') is-invalid @enderror"
                                            value="{{ $filters['price_max'] ?? '' }}">
                                        <span class="input-group-text">PLN</span>
                                        @error('price_max')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 d-flex flex-wrap gap-2">
                                    <button class="btn btn-primary" type="submit">Zastosuj</button>
                                    <a class="btn btn-outline-secondary"
                                        href="{{ route('account.reports.statistics') }}">Wyczyść</a>
                                    <a class="btn btn-outline-info"
                                        href="{{ route('reports.statistics.pdf', request()->query()) }}">Pobierz
                                        PDF</a>
                                </div>
                            </form>

                            <hr class="my-4">

                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <div class="card">
                                        <div
                                            class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                            <span>Liczba turniejów</span>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-outline-success btn-sm"
                                                    id="downloadMatchesPng">PNG</button>
                                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                                    id="downloadMatchesJpg">JPG</button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="matchesPerMonthChart"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="card">
                                        <div
                                            class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                            <span>Średnia cena wejść</span>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-outline-success btn-sm"
                                                    id="downloadAveragePng">PNG</button>
                                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                                    id="downloadAverageJpg">JPG</button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="averagePricePerMonthChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 text-center">
                                <div class="col-12 col-lg-6">
                                    <table class="table table-bordered table-striped m-0">
                                        <thead>
                                            <tr>
                                                <th>Mediana max uczestników w drużynie</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $participantsPerTeam }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 col-lg-6 mt-3 mt-lg-0">
                                    <table class="table table-bordered table-striped m-0">
                                        <thead>
                                            <tr>
                                                <th>Odchylenie standardowe ceny</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ number_format($priceStdDeviation, 2, ',', ' ') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-3 text-body-secondary small">
                                Jeśli wybierzesz daty, rok jest ignorowany. Jeśli nie wybierzesz dat, filtr działa po
                                roku.
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('shared.footer')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const yearEl = document.getElementById('year');
        const dateFromEl = document.getElementById('date_from');
        const dateToEl = document.getElementById('date_to');
        const priceMinEl = document.getElementById('price_min');
        const priceMaxEl = document.getElementById('price_max');

        function setFieldValidity(el, ok, msg) {
            if (!el) return;
            el.setCustomValidity(ok ? '' : msg);
        }

        function validateReportForm() {
            const dateFrom = dateFromEl.value ? new Date(dateFromEl.value) : null;
            const dateTo = dateToEl.value ? new Date(dateToEl.value) : null;

            if (dateFrom && dateTo && dateTo < dateFrom) {
                setFieldValidity(dateToEl, false, 'Data "do" nie może być wcześniejsza niż "od".');
            } else {
                setFieldValidity(dateToEl, true, '');
            }

            const pMin = priceMinEl.value === '' ? null : Number(priceMinEl.value);
            const pMax = priceMaxEl.value === '' ? null : Number(priceMaxEl.value);

            if (pMin !== null && (Number.isNaN(pMin) || pMin < 0)) {
                setFieldValidity(priceMinEl, false, 'Cena min musi być liczbą >= 0.');
            } else {
                setFieldValidity(priceMinEl, true, '');
            }

            if (pMax !== null && (Number.isNaN(pMax) || pMax < 0)) {
                setFieldValidity(priceMaxEl, false, 'Cena max musi być liczbą >= 0.');
            } else if (pMin !== null && pMax !== null && pMax < pMin) {
                setFieldValidity(priceMaxEl, false, 'Cena max nie może być mniejsza niż cena min.');
            } else {
                setFieldValidity(priceMaxEl, true, '');
            }

            const y = yearEl.value === '' ? null : Number(yearEl.value);
            const minY = Number(yearEl.min);
            const maxY = Number(yearEl.max);
            if (y !== null && (!Number.isInteger(y) || y < minY || y > maxY)) {
                setFieldValidity(yearEl, false, 'Rok musi być w zakresie ' + minY + ' - ' + maxY + '.');
            } else {
                setFieldValidity(yearEl, true, '');
            }
        }

        ['input', 'change'].forEach(evt => {
            dateFromEl.addEventListener(evt, validateReportForm);
            dateToEl.addEventListener(evt, validateReportForm);
            priceMinEl.addEventListener(evt, validateReportForm);
            priceMaxEl.addEventListener(evt, validateReportForm);
            yearEl.addEventListener(evt, validateReportForm);
        });

        validateReportForm();

        const monthLabels = ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień',
            'Październik', 'Listopad', 'Grudzień'
        ];

        const matchesPerMonthData = Array(12).fill(0);
        @foreach ($matchesPerMonth as $month => $count)
            matchesPerMonthData[{{ $month - 1 }}] = {{ $count }};
        @endforeach

        const averagePricePerMonthData = Array(12).fill(0);
        @foreach ($averagePricePerMonth as $month => $avg_price)
            averagePricePerMonthData[{{ $month - 1 }}] = {{ $avg_price }};
        @endforeach

        const matchesChart = new Chart(document.getElementById('matchesPerMonthChart'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Liczba turniejów',
                    data: matchesPerMonthData
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const avgChart = new Chart(document.getElementById('averagePricePerMonthChart'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Średnia cena wejść (PLN)',
                    data: averagePricePerMonthData
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        async function downloadCanvasAs(format, name, canvas) {
            const mime = format === 'png' ? 'image/png' : 'image/jpeg';
            const data = format === 'png' ? canvas.toDataURL(mime) : canvas.toDataURL(mime, 0.92);

            const form = new FormData();
            form.append('image', data);
            form.append('format', format);
            form.append('name', name);

            const resp = await fetch('{{ route('reports.statistics.image') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: form
            });

            if (!resp.ok) {
                alert('Nie udało się wygenerować pliku. Upewnij się, że jesteś zalogowany i spróbuj ponownie.');
                return;
            }

            const blob = await resp.blob();
            if (!blob || blob.size === 0) {
                alert('Wygenerowano pusty plik. Spróbuj ponownie.');
                return;
            }

            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = name + '.' + (format === 'png' ? 'png' : 'jpg');
            document.body.appendChild(a);
            a.click();
            a.remove();
            URL.revokeObjectURL(url);
        }

        document.getElementById('downloadMatchesPng').addEventListener('click', () => downloadCanvasAs('png',
            'wykres_liczba_turniejow', document.getElementById('matchesPerMonthChart')));
        document.getElementById('downloadMatchesJpg').addEventListener('click', () => downloadCanvasAs('jpg',
            'wykres_liczba_turniejow', document.getElementById('matchesPerMonthChart')));
        document.getElementById('downloadAveragePng').addEventListener('click', () => downloadCanvasAs('png',
            'wykres_srednia_cena', document.getElementById('averagePricePerMonthChart')));
        document.getElementById('downloadAverageJpg').addEventListener('click', () => downloadCanvasAs('jpg',
            'wykres_srednia_cena', document.getElementById('averagePricePerMonthChart')));
    </script>
</body>

</html>
