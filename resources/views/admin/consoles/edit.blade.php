@extends('layouts.games-layout')

@section('title', 'Lista Console')

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

        <h1 class="mb-4">Modifica Console</h1>

        <form action="{{ route('admin.consoles.update', $console) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome Console</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $console->name) }}" required>
            </div>

            <div class=" d-flex justify-content-between">
                <a href="{{ route('admin.consoles.index') }}" class="btn btn-secondary">Annulla</a>
                <button type="submit" class="btn btn-primary">Salva modifiche</button>
            </div>
        </form>
    </div>

@endsection
