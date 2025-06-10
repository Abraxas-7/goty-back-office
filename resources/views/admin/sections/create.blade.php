@extends('layouts.games-layout')

@section('title', 'Aggiungi Sezione')

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

    <h2 class="py-3">Crea una nuova sezione per: <strong>{{ $game->title }}</strong></h2>


    <form action="{{ route('admin.sections.store', $game->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-12 mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                    required>
            </div>

            <div class="col-12 mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea id="description" name="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="image" class="form-label">Immagine</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>

            <div class="col-12 mb-5">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('admin.games.show', $game) }}" class="btn btn-secondary w-100">Annulla</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary w-100">Aggiungi Sezione</button>
                    </div>
                </div>
            </div>
        </div>

    </form>

@endsection
