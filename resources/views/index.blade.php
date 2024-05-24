@include('shared.html')

@include('shared.head', ['pageTitle' => 'Strona główna'])

<body>
    @include('shared.navbar')

    <main>
        <div class="container-fluid p-0">
            <div class="hero-section text-center text-white d-flex align-items-center justify-content-center"
                style="background-image: url('img/paintballMatch.webp'); background-size: cover; height: 70vh;">
                <div class="content d-flex flex-column justify-content-center"
                    style="z-index: 1; background-color: rgba(0, 0, 0, 0.5); width: 100%; height: 100%;">
                    <h1 class="display-3">Witamy w Klubie Paintballowym</h1>
                    <p class="lead">Dołącz do nas i przeżyj niezapomniane emocje!</p>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <img src="img/paintballMatch.webp" alt="Obraz przedstawiający mecz paintballa"
                        class="img-fluid rounded">
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-center">
                    <h2>Witamy na naszej stronie klubu paintballowego!</h2>
                    <p>Niezależnie od tego czy jesteś początkujący lub zawodowcem w paintballu, zawsze z chęcią witamy
                        nowych członków naszej społeczności! Nasz klub oferuje możliwość dołączenia do turniejów, które
                        są dostępne w zakładce "Turnieje" w menu nawigacji. Tam będzie można zobaczyć aktualnie dostępne
                        turnieje. Mamy nadzieję, że wkrótce zobaczymy Cię na meczu paintballowym :)</p>
                    <a href="{{ route('tournaments.index') }}" class="btn btn-primary mt-3">Zobacz Turnieje</a>
                </div>
            </div>
        </div>

        <div id="carouselExampleIndicators" class="carousel slide mt-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="6000">
                    <img src="img/slide1.webp" class="d-block w-100" alt="Slide 1">
                    <div class="carousel-caption d-none d-md-block text-white">
                        <h5>Intensywne rozgrywki</h5>
                        <p>Przeżyj niezapomniane chwile z naszym klubem paintballowym.</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="10000">
                    <img src="img/slide2.webp" class="d-block w-100" alt="Slide 2">
                    <div class="carousel-caption d-none d-md-block text-white">
                        <h5>Zawodowi gracze</h5>
                        <p>Dołącz do naszych profesjonalnych zawodników i zdobywaj doświadczenie.</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="10000">
                    <img src="img/slide3.webp" class="d-block w-100" alt="Slide 3">
                    <div class="carousel-caption d-none d-md-block text-white">
                        <h5>Najlepsze turnieje</h5>
                        <p>Sprawdź naszą ofertę turniejów i wybierz coś dla siebie.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="container mt-5">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="img/benefit1.webp" class="card-img-top" alt="Benefit 1">
                        <div class="card-body">
                            <h5 class="card-title">Profesjonalne wyposażenie</h5>
                            <p class="card-text">Zapewniamy najnowsze i najlepsze wyposażenie dla naszych członków.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="img/benefit2.webp" class="card-img-top" alt="Benefit 2">
                        <div class="card-body">
                            <h5 class="card-title">Bezpieczne warunki</h5>
                            <p class="card-text">Dbamy o bezpieczeństwo naszych graczy podczas każdego meczu.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="img/benefit3.webp" class="card-img-top" alt="Benefit 3">
                        <div class="card-body">
                            <h5 class="card-title">Doskonała lokalizacja</h5>
                            <p class="card-text">Nasze pole paintballowe znajduje się w malowniczej okolicy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('shared.footer')
</body>

</html>
