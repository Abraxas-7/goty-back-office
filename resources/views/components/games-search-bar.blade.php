<div class="p-3 border border-1 bg-white rounded-3 shadow-sm mt-3">
    <form action="{{ $action }}" method="GET" class="row g-2">
        <div class="col-md-9">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cerca...">
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select w-100">
                <option value="">Ordina per</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A-Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z-A</option>
                <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Più recenti (creazione)
                </option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Meno recenti (creazione)
                </option>
                <option value="updated_recent" {{ request('sort') == 'updated_recent' ? 'selected' : '' }}>Più recenti
                    (aggiornamento)</option>
                <option value="updated_oldest" {{ request('sort') == 'updated_oldest' ? 'selected' : '' }}>Meno recenti
                    (aggiornamento)</option>
            </select>
        </div>


        <div class="col-md-4">
            <select name="console" class="form-select">
                <option value="">Console</option>
                @foreach ($consoles as $console)
                    <option value="{{ $console->id }}" {{ request('console') == $console->id ? 'selected' : '' }}>
                        {{ $console->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="genre" class="form-select">
                <option value="">Genere</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="developer" class="form-select">
                <option value="">Developer</option>
                @foreach ($developers as $developer)
                    <option value="{{ $developer->id }}"
                        {{ request('developer') == $developer->id ? 'selected' : '' }}>
                        {{ $developer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12">
            <div class="row d-flex align-items-center justify-content-evenly ">
                <div class="col-md-4">
                    <a href="{{ $action }}" class="btn btn-secondary w-100">Azzera filtri</a>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Cerca</button>
                </div>
            </div>
        </div>
    </form>
</div>
