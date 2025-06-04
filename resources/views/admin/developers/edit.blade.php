@extends('layouts.games-layout')

@section('title', 'Lista progetti')

@section('content')

    <div class="container py-5">
        <h1 class="mb-4">Modifica Developer</h1>

        <form action="{{ route('admin.developers.update', $developer) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome Developer</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $developer->name) }}" required>
            </div>

            <div class=" d-flex justify-content-between">
                <a href="{{ route('admin.developers.index') }}" class="btn btn-secondary">Annulla</a>
                <button type="submit" class="btn btn-primary">Salva modifiche</button>
            </div>
        </form>
    </div>

@endsection
