<header>
    <div class="container-fluid bg-dark">
        <h1 class="p-5 text-white mb-0"> @yield('title') </h1>
    </div>

    <div class="container-fluid bg-secondary py-2 px-4 d-flex flex-row">
        <a href="{{ route('admin.games.index') }}" class="btn btn-outline-light fw-bold border-0 fs-6 p-2 me-2">
            Giochi
        </a>

        <a href="{{ route('admin.genres.index') }}" class="btn btn-outline-light fw-bold border-0 fs-6 p-2 me-2">
            Generi
        </a>

        <a href="{{ route('admin.consoles.index') }}" class="btn btn-outline-light fw-bold border-0 fs-6 p-2 me-2">
            Consoles
        </a>

        <a href="{{ route('admin.developers.index') }}" class="btn btn-outline-light fw-bold border-0 fs-6 p-2 me-2">
            Developers
        </a>
    </div>
</header>
