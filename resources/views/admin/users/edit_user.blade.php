@include('shared.html')

@include('shared.head')

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">

        @include('shared.session-error')

        <div class="row mt-4 mb-4 text-center">
            <h1>Edytuj dane użytkownika</h1>
        </div>

        @include('shared.validation-error')

        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="username" class="form-label">Username</label>
                        <input id="username" name="username" type="text"
                            class="form-control @if ($errors->first('username')) is-invalid @endif"
                            value="{{ $user->username }}">
                        <div class="invalid-feedback">Nieprawidłowy username!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Imię</label>
                        <input id="name" name="name" type="text"
                            class="form-control @if ($errors->first('name')) is-invalid @endif"
                            value="{{ $user->name }}">
                        <div class="invalid-feedback">Nieprawidłowe imię!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="surname" class="form-label">Nazwisko</label>
                        <input id="surname" name="surname" type="text"
                            class="form-control @if ($errors->first('surname')) is-invalid @endif"
                            value="{{ $user->surname }}">
                        <div class="invalid-feedback">Nieprawidłowe nazwisko!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email"
                            class="form-control @if ($errors->first('email')) is-invalid @endif"
                            value="{{ $user->email }}">
                        <div class="invalid-feedback">Nieprawidłowy email!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="password" class="form-label">Hasło</label>
                        <input id="password" name="password" type="password"
                            class="form-control @if ($errors->first('password')) is-invalid @endif">
                        <div class="invalid-feedback">Nieprawidłowe hasło!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="password_confirmation" class="form-label">Potwierdź hasło</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="form-control @if ($errors->first('password_confirmation')) is-invalid @endif">
                        <div class="invalid-feedback">Hasła nie pasują do siebie!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="avatar" class="form-label">Avatar</label>
                        <input id="avatar" name="avatar" type="text"
                            class="form-control @if ($errors->first('avatar')) is-invalid @endif"
                            value="{{ $user->avatar }}">
                        <div class="invalid-feedback">Nieprawidłowy avatar!</div>
                    </div>
                    <div class="text-center mt-4 mb-4">
                        <input class="btn btn-success" type="submit" value="Wyślij">
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('shared.footer')
</body>

</html>
