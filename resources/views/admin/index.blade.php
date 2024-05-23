@include('shared.html')

@include('shared.head')

<body>
    @include('shared.navbar')
    <div class="container">
        <h1>Panel Administratora</h1>
        <ul>
            <li><a href="{{ route('admin.users.index') }}">Zarządzaj użytkownikami</a></li>
            <li><a href="{{ route('admin.tournaments.index') }}">Zarządzaj turniejami</a></li>
            <!-- Dodaj więcej linków według potrzeb -->
        </ul>
    </div>

    @include('shared.footer')
</body>

</html>
