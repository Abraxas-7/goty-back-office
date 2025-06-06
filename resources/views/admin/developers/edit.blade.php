@extends('layouts.games-layout')

@section('title', 'Modifica Developer')

@section('content')

    <div class="mt-5">
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
