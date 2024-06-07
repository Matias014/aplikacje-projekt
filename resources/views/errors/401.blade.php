@include('shared.html')

@include('shared.head', ['pageTitle' => 'Błąd 401'])

<style>
    body {
        background-image: url("../../img/slide1.jpg");
    }
</style>

<body class="d-flex flex-column min-vh-100">
    @include('shared.navbar')

    <div class="container mt-5 mb-5">
        @if (session('error'))
            <div class="row d-flex justify-content-center">
                <div class="alert alert-danger">{{ session('error') }}</div>
            </div>
        @endif
        <div class="row mt-4 mb-4 text-center card">
            <h1 class="display-1 fw-bold">401</h1>
            <h2>
                @if (App::environment('local'))
                    Nieuprawniony dostęp
                @else
                    Nie znaleziono
                @endif
            </h2>
        </div>

        @include('shared.validation-error')
    </div>

    @include('shared.footer')
    <script>
        document.getElementById("navbar-user").remove();
    </script>
</body>

</html>
