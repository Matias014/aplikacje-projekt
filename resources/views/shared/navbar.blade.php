<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index') }}">Klub paintballowy</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-link">
                    <a class="nav-link @if (Route::is('index')) active @endif" aria-current="page"
                        href="{{ route('index') }}">Strona główna</a>
                </li>
                <li class="nav-link">
                    <a class="nav-link @if (Route::is('tournaments.*')) active @endif"
                        href="{{ route('tournaments.index') }}">Turnieje</a>
                </li>
                <li class="nav-link">
                    <a class="nav-link" href="{{ route('index') }}#statystyki">Statystyki</a>
                </li>
                @if (Auth::check())
                    <li class="nav-link">
                        <a class="nav-link @if (Route::is('users.show')) active @endif"
                            href="{{ route('users.show', Auth::user()->id) }}">Konto</a>
                    </li>
                @endif
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <li class="nav-link">
                        <a class="nav-link @if (Route::is('admin.*')) active @endif"
                            href="{{ route('admin.index') }}">Panel Admina</a>
                    </li>
                    <li class="nav-link">
                        <a class="nav-link @if (Route::is('admin.logs.index')) active @endif"
                            href="{{ route('admin.logs.index') }}">Logi</a>
                    </li>
                @endif
            </ul>
            <ul id="navbar-user" class="navbar-nav mb-2 mb-lg-0">
                @if (Auth::check())
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="nav-link btn btn-link p-0 m-0" type="submit">{{ Auth::user()->name }},
                                wyloguj się</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Zaloguj się</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
