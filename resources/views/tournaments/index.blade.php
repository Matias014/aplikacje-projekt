@include('shared.html')

@include('shared.head')

<body>
    @include('shared.navbar')

    <main>
        <div class="container text-center mt-2">
            <div class="row mt-5">
                <h1>Turnieje</h1>
            </div>
            <div class="row">
                @forelse ($tournaments as $tournament)
                    <div class="col-12 col-lg-6 mt-5">
                        <div class="card">
                            <img src="{{ asset('storage/img/'.$tournament->img) }}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{ $tournament->name }}</h5>
                                <p class="card-text">{{ $tournament->description }}</p>
                                <p class="card-text">Data turnieju: {{ $tournament->date }}</p>
                                <p class="card-text">Cena wejściowa: {{ $tournament->price }} zł</p>
                                <a href="{{route('tournaments.show', ['id' => $tournament->id])}}" class="btn btn-primary">Więcej szczegółów</a>
                            </div>
                        </div>
                    </div>
                    @empty
                        <p>Brak turniejów.</p>
                    @endforelse
                </div>
        </div>


    </main>

    @include('shared.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
