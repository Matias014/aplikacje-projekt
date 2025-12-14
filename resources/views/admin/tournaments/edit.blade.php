@include('shared.html')

@include('shared.head', ['pageTitle' => 'Edytuj dane turnieju'])

<body class="d-flex flex-column min-vh-100">
    @include('shared.navbar')

    <div class="container mt-5 mb-5 flex-grow-1">

        @include('shared.session-error')

        <div class="row mt-4 mb-4 text-center">
            <h1>Edytuj dane turnieju</h1>
        </div>

        @include('shared.validation-error')

        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <form method="POST" action="{{ route('tournaments.update', ['tournament' => $tournament]) }}"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Nazwa</label>
                        <input id="name" name="name" type="text"
                            class="form-control @if ($errors->first('name')) is-invalid @endif"
                            value="{{ $tournament->name }}">
                        <div class="invalid-feedback">Nieprawidłowa nazwa!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="description" class="form-label">Opis</label>
                        <textarea id="description" name="description" type="text" rows="5"
                            class="form-control @if ($errors->first('description')) is-invalid @endif">{{ $tournament->description }}</textarea>
                        <div class="invalid-feedback">Nieprawidłowy opis!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="date" class="form-label">Data</label>
                        <input id="date" name="date" type="date"
                            class="form-control @if ($errors->first('date')) is-invalid @endif"
                            value="{{ $tournament->date }}" min="{{ date('Y-m-d') }}">
                        <div class="invalid-feedback">Nieprawidłowa data!</div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="price" class="form-label">Cena</label>
                        <div class="input-group mb-3">
                            <input id="price" type="number" name="price" min="0" placeholder="0"
                                step="any" class="form-control @if ($errors->first('price')) is-invalid @endif"
                                value="{{ $tournament->price }}">
                            <span class="input-group-text"> PLN</span>
                        </div>
                        <div class="invalid-feedback">Nieprawidłowa cena!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="img" class="form-label">Nazwa obrazka</label>
                        <input id="img" name="img" type="file"
                            class="form-control @if ($errors->first('img')) is-invalid @endif"
                            value="{{ $tournament->img }}">
                        <div class="invalid-feedback">Nieprawidłowa nazwa obrazka!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="max_participants" class="form-label">Max uczestników dla jednej drużyny</label>
                        <input id="max_participants" name="max_participants" type="number" min="0"
                            class="form-control @if ($errors->first('max_participants')) is-invalid @endif"
                            value="{{ $tournament->max_participants }}">
                        <div class="invalid-feedback">Nieprawidłowa wartość!</div>
                    </div>
                    <div class="text-center mt-4 mb-4">
                        <input class="btn btn-success" type="submit" value="Zaktualizuj">
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('shared.footer')
</body>

</html>
