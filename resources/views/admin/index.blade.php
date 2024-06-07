@include('shared.html')

@include('shared.head', ['pageTitle' => 'Panel admina'])

<body class="d-flex flex-column min-vh-100">
    @include('shared.navbar')
    <div class="container mt-5 flex-grow-1">
        <h1 class="text-center mb-4">Panel Administratora</h1>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Zarządzaj użytkownikami</h5>
                        <p class="card-text">Przeglądaj, edytuj i usuwaj użytkowników.</p>
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Zarządzaj użytkownikami</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Zarządzaj turniejami</h5>
                        <p class="card-text">Dodawaj, edytuj i usuwaj turnieje.</p>
                        <a href="{{ route('tournaments.index') }}" class="btn btn-primary">Zarządzaj
                            turniejami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('shared.footer')
</body>

</html>
