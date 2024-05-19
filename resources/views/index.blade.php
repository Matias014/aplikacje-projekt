@include('shared.html')

@include('shared.head')

<body>
    @include('shared.navbar')

    <main>
        <div class="container">
            <div class="row mt-5">
                <div class="card col-6 border-0">
                    <img src="img/paintballMatch.webp" alt="Obraz przedstawiający mecz paintballa">
                </div>
                <div class="card col-6 border-0">
                    <h1>Witamy na naszej stronie klubu paintballowego!</h1>
                    <p class="mt-3">Niezależnie od tego czy jesteś początkujący lub zawodowcem w paintballu, zawsze z chęcią
                        witamy nowych członków naszej społeczności! Nasz klub oferuje możliwość dołączenia do turniejów,
                        które są dostępne w zakładce "turnieje" w menu nawigacji. Tam będzie można zobaczyć aktualne dostępne
                        turnieje. Mamy nadzieję, że wkrótce zobaczymy Cię na meczu paintballowym :) !
                </div>
            </div>
        </div>

        <div id="karuzela" class="container carousel slide mt-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="6000">
                    <img src="img/slide1.webp" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="10000">
                    <img src="img/slide2.webp" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="10000">
                    <img src="img/slide3.webp" class="d-block w-100" alt="...">
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
