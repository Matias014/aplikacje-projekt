@include('shared.html')

@include('shared.head', ['pageTitle' => 'Turnieje'])

<body>
    @include('shared.navbar')

    <main>
        <div class="container text-center mt-2">
            <div class="row mt-5">
                <h1>Turnieje</h1>
            </div>
            @include('shared.session-error')
            @if (Auth::check() && Auth::user()->isAdmin())
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="{{ route('admin.tournaments.create') }}" class="btn btn-success">Dodaj nowy turniej</a>
                    </div>
                </div>
            @endif
            <div class="row">
                @forelse ($tournaments as $tournament)
                    <div class="col-12 col-lg-6 mt-3">
                        <div class="card">
                            <img src="{{ asset('storage/img/' . $tournament->img) }}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{ $tournament->name }}</h5>
                                <p class="card-text">{{ $tournament->description }}</p>
                                <p class="card-text">Data turnieju: {{ $tournament->date }}</p>
                                <p class="card-text">Cena wejściowa: {{ $tournament->price }} zł</p>
                                <a href="{{ route('tournaments.show', $tournament->id) }}"
                                    class="btn btn-primary">Więcej szczegółów</a>
                            </div>
                            @if (Auth::check() && Auth::user()->isAdmin())
                                <div class="card-footer">
                                    <a href="{{ route('admin.tournaments.edit', $tournament->id) }}"
                                        class="btn btn-warning mt-2">Edytuj</a>
                                    <form action="{{ route('admin.tournaments.destroy', $tournament) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mt-2">Usuń</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p>Brak turniejów.</p>
                @endforelse
            </div>
        </div>
    </main>

    @include('shared.footer')
</body>

</html>
