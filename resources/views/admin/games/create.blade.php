@extends('layouts.games-layout')

@section('title', 'Aggiungi Gioco')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="py-3">Crea un nuovo gioco</h2>

    <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-8 mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                    required>
            </div>

            <div class="col-2 mb-3">
                <label for="rating" class="form-label">Voto Metacritic</label>
                <input type="number" class="form-control" id="rating" name="rating" min="1" max="100"
                    value="{{ old('rating') }}" placeholder="Es. 89">
                <small class="text-muted">Inserisci un valore da 1 a 100</small>
            </div>

            <div class="col-2 mb-3">
                <label for="release_date" class="form-label">Data di rilascio</label>
                <input type="date" id="release_date" name="release_date" class="form-control"
                    value="{{ old('release_date') }}" required>
            </div>

            <div class="col-12 mb-3">
                <label for="developer_id" class="form-label">Developer</label>
                <select id="developer_id" name="developer_id" class="form-select">
                    <option value="">Seleziona uno sviluppatore</option>
                    @foreach ($developers as $developer)
                        <option value="{{ $developer->id }}" {{ old('developer_id') == $developer->id ? 'selected' : '' }}>
                            {{ $developer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Console</label>
                <div class=" border border-1 bg-white rounded-3 p-2">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($consoles as $console)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="consoles[]"
                                    value="{{ $console->id }}" id="console-{{ $console->id }}"
                                    {{ in_array($console->id, old('consoles', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="console-{{ $console->id }}">
                                    {{ $console->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <small class="text-muted">Seleziona una o più console</small>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Generi</label>
                <div class=" border border-1 bg-white rounded-3 p-2">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($genres as $genre)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                    id="genre-{{ $genre->id }}"
                                    {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="genre-{{ $genre->id }}">
                                    {{ $genre->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <small class="text-muted">Seleziona una o più genre</small>
            </div>

            <div class="col-12 mb-3">
                <label for="short_description" class="form-label">Descrizione</label>
                <textarea id="short_description" name="short_description" rows="4" class="form-control" required>{{ old('short_description') }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="cover_image" class="form-label">Immagine</label>
                <input type="file" class="form-control" id="cover_image" name="cover_image" required accept="image/*">
            </div>

            <div class="col-12 mb-5">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary w-100">Annulla</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary w-100">Aggiungi Gioco</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
