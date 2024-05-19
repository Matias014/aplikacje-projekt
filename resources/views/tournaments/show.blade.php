@include('shared.html')

@include('shared.head')

<body class="d-flex flex-column min-vh-100">
    @include('shared.navbar')

    <main class="flex-grow-1">
        <div class="container text-center mt-2">
            {{-- <div class="row mt-5">
                <h1>Turnieje</h1>
            </div> --}}
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 mt-5">
                    <div class="card">
                        <img src="{{ asset('storage/img/' . $tournament->img) }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $tournament->name }}</h5>
                            <p class="card-text">{{ $tournament->description }}</p>
                            <p class="card-text">Data turnieju: {{ $tournament->date }}</p>
                            <p class="card-text">Cena wejściowa: {{ $tournament->price }} zł</p>
                            <div class="text-center mt-4">
                                <input class="btn btn-light" type="submit" value="Zapisz się">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 mt-5">
                    <h1>Uczestnicy</h1>
                    <div class="row">
                        @php
                            $teams = $tournament->participants->groupBy('pivot.team');
                        @endphp

                        @foreach ($teams as $team => $participants)
                            <div class="col-12 col-md-6 mb-4 mt-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h2>Drużyna {{ $team }}</h2>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($participants as $participant)
                                            <div class="participant d-flex align-items-center mb-3">
                                                <img src="{{ asset('img/' . $participant->avatar) }}"
                                                    alt="{{ $participant->name }}" class="rounded-circle" width="50"
                                                    height="50">
                                                <div class="ms-3">
                                                    <p class="mb-0"><strong>{{ $participant->name }}
                                                            {{ $participant->surname }}</strong></p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 mt-5">
                    <h1>Komentarze</h1>
                    @foreach ($tournament->answers as $answer)
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="card-text">{{ $answer->answer }}</p>
                                <footer class="blockquote-footer">{{ $answer->user->name }}
                                    {{ $answer->user->surname }}</footer>
                            </div>
                        </div>
                    @endforeach

                    @auth
                        @if ($tournament->participants->contains('user_id', Auth::id()))
                            <form action="{{ route('answers.store', $tournament) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="answer">Dodaj komentarz</label>
                                    <textarea class="form-control" id="answer" name="answer" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Dodaj</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>

        </div>
    </main>

    @include('shared.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
