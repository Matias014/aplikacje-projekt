@include('shared.html')

@include('shared.head', ['pageTitle' => 'Użytkownik - ' . $user->username])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">
        <div class="row mb-1">
            <h1>Użytkownik</h1>
        </div>
        @include('shared.session-error')
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
                    <td><img src="{{ asset('img/' . $user->avatar) }}" style="width: 50px; height: 50px;"></td>
                </tr>
                <tr>
                    <th scope="col"></th>
                    <td><a href="{{ route('admin.users.update', ['user' => $user->id]) }}"
                            class="btn btn-primary mb-2">Zmień dane</a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger" value="Usuń konto" />
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    @include('shared.footer')
</body>

</html>
