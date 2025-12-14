@include('shared.html')

@include('shared.head', ['pageTitle' => 'Użytkownik - ' . $user->username])

<body class="d-flex flex-column min-vh-100">
    @include('shared.navbar')

    <main class="flex-grow-1">
        <div class="container mt-5 mb-5">
            <div class="row mb-3 text-center">
                <h1>Panel użytkownika</h1>
            </div>
            @include('shared.session-error')
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header text-center">
                            <h3>Dane użytkownika</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <th scope="col">Username</th>
                                        <td>{{ $user->username }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Imię</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Nazwisko</th>
                                        <td>{{ $user->surname }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Avatar</th>
                                        <td><img src="{{ asset('storage/img/' . $user->avatar) }}"
                                                class="rounded-circle" style="width: 50px; height: 50px;"></td>
                                    </tr>
                                    <tr>
                                        <th scope="col"></th>
                                        <td class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                                class="btn btn-primary mb-2">Zmień dane</a>
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="btn btn-danger" value="Usuń konto" />
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header text-center">
                            <h3>Raporty</h3>
                        </div>
                        <div class="card-body text-center">
                            <p class="m-0 mb-3">Generuj raport PDF i eksportuj wykresy PNG/JPG ze statystyk.</p>
                            <a class="btn btn-outline-secondary"
                                href="{{ route('account.reports.statistics') }}">Przejdź do raportów</a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header text-center">
                            <h3>Turnieje, w których brałeś lub bierzesz udział</h3>
                        </div>
                        <div class="card-body">
                            @if ($tournaments->isEmpty())
                                <p class="text-center">Nie bierzesz udziału w żadnych turniejach.</p>
                            @else
                                <ul class="list-group">
                                    @foreach ($tournaments as $tournament)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $tournament->name }}
                                            <span class="badge bg-primary rounded-pill">{{ $tournament->date }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    @include('shared.footer')
</body>

</html>
