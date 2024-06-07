@include('shared.html')

@include('shared.head', ['pageTitle' => 'Dodaj nowego użytkownika'])

<body class="d-flex flex-column min-vh-100">
    @include('shared.navbar')

    <div class="container mt-5 mb-5">

        @include('shared.session-error')

        <div class="row mt-4 mb-4 text-center">
            <h1>Dodaj nowego użytkownika</h1>
        </div>

        @include('shared.validation-error')

        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <form method="POST" action="{{ route('users.store') }}" class="needs-validation"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="form-group mb-2">
                        <label for="username" class="form-label">Nazwa użytkownika</label>
                        <input id="username" name="username" type="text"
                            class="form-control @if ($errors->first('username')) is-invalid @endif"
                            value="{{ old('username') }}" required>
                        <div class="invalid-feedback">Nieprawidłowa nazwa użytkownika!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Imię</label>
                        <input id="name" name="name" type="text"
                            class="form-control @if ($errors->first('name')) is-invalid @endif"
                            value="{{ old('name') }}" required>
                        <div class="invalid-feedback">Nieprawidłowe imię!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="surname" class="form-label">Nazwisko</label>
                        <input id="surname" name="surname" type="text"
                            class="form-control @if ($errors->first('surname')) is-invalid @endif"
                            value="{{ old('surname') }}" required>
                        <div class="invalid-feedback">Nieprawidłowe nazwisko!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email"
                            class="form-control @if ($errors->first('email')) is-invalid @endif"
                            value="{{ old('email') }}" required>
                        <div class="invalid-feedback">Nieprawidłowy email!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="password" class="form-label">Hasło</label>
                        <input id="password" name="password" type="password"
                            class="form-control @if ($errors->first('password')) is-invalid @endif" required>
                        <div class="invalid-feedback">Nieprawidłowe hasło!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="avatar" class="form-label">Avatar</label>
                        <input id="avatar" name="avatar" type="file"
                            class="form-control @if ($errors->first('avatar')) is-invalid @endif" required>
                        <div class="invalid-feedback">Nieprawidłowy plik zdjęcia!</div>
                    </div>
                    <div class="text-center mt-4 mb-4">
                        <input class="btn btn-success" type="submit" value="Dodaj">
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('shared.footer')
</body>

</html>
