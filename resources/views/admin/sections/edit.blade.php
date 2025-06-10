@php
    $game = \App\Models\Game::find($section->game_id);
@endphp

@extends('layouts.games-layout')

@section('title', 'Modifica Sezione')

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

    <h2 class="py-3">Modifica la sezione: <strong>{{ $section->title }}</strong></h2>

    <form action="{{ route('admin.sections.update', $section) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12 mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ old('title', $section->title) }}" required>
            </div>

            <div class="col-12 mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea id="description" name="description" rows="4" class="form-control" required>{{ old('description', $section->description) }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="image" class="form-label">Immagine (opzionale)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">

                <div class="d-flex justify-content-center">
                    @if ($section->section_image_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $section->section_image_path) }}" alt="{{ $section->title }}"
                                class="img-fluid rounded border shadow my-3" style="max-height: 300px;">
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-center mb-3">
                    <small class="text-muted ">Carica una nuova immagine per sostituire quella attuale</small>
                </div>
            </div>

            <div class="col-12 mb-5">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('admin.games.show', $game) }}" class="btn btn-secondary w-100">Annulla</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary w-100">Salva Modifiche</button>
                    </div>
                </div>
            </div>
        </div>

    </form>

@endsection
