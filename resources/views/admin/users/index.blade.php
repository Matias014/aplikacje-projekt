@include('shared.html')

@include('shared.head', ['pageTitle' => 'Użytkownicy'])

<body class="d-flex flex-column min-vh-100">
    @include('shared.navbar')

    <main class="flex-grow-1">
        <div class="container text-center mt-2 flex-grow-1">
            <div class="row mt-5">
                <h1>Użytkownicy</h1>
            </div>
            <div class="row mb-2">
                <a href="{{ route('users.create') }}">Dodaj nowego użytkownika</a>
            </div>
            @include('shared.session-error')
            <div class="row mt-5">
                <div class="table-responsive-sm">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Imię</th>
                                <th scope="col">Nazwisko</th>
                                <th scope="col">Email</th>
                                <th scope="col">Avatar</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->surname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->avatar }}</td>
                                    <td>
                                        @can('update', $user)
                                            <a href="{{ route('users.edit', $user) }}">Edycja</a>
                                        @endcan
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-danger" value="Usuń"
                                                style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" />
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th scope="row" colspan="6">Brak użytkowników.</th>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
    </main>

    @include('shared.footer')
</body>

</html>
