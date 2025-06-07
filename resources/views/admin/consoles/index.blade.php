@extends('layouts.games-layout')

@section('title', 'Lista Consoles')

@section('content')

    @if (session('message'))
        @php
            $type = session('message_type') ?? 'info';
            $alertClass = match ($type) {
                'success' => 'alert-success',
                'error' => 'alert-danger',
            };
        @endphp

        <div class="alert {{ $alertClass }} alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <x-search-bar :action="route('admin.consoles.index')" />

    <div class="mt-3 row g-3">
        <div class="col-8">
            @if ($consoles->count() == 0)
                <div class="text-center py-5">
                    <h2 class="text-center">Nessuna console trovata</h2>
                </div>
            @else
                <table class="table table-striped table-bordered ">
                    <thead class="table-dark">
                        <tr class="fs-5">
                            <th class="col-10">Nome</th>
                            <th class="col-1"></th>
                            <th class="col-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consoles as $console)
                            <tr>
                                <td class="align-middle">{{ $console->name }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.consoles.edit', $console) }}"
                                        class="btn btn-outline-warning border-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger border-2" data-bs-toggle="modal"
                                        data-bs-target="#deleteConsoleModal-{{ $console->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <!-- Modale eliminazione form -->
                                    <div class="modal fade" id="deleteConsoleModal-{{ $console->id }}" tabindex="-1"
                                        aria-labelledby="deleteConsoleModalLabel-{{ $console->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5"
                                                        id="deleteConsoleModalLabel-{{ $console->id }}">
                                                        Conferma eliminazione
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Chiudi"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Sei sicuro di voler eliminare <strong>{{ $console->name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annulla</button>
                                                    <form action="{{ route('admin.consoles.destroy', $console) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            Elimina
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="mt-3">
                {{ $consoles->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <div class="col-4">
            <form action="{{ route('admin.consoles.store') }}" method="POST">
                @csrf

                <h3 class="text-center mb-3">Aggiungi console</h3>

                <div class="row d-flex justify-content-center">
                    <div class="col-10">
                        <label for="name" class="form-label">Nome nuova console</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="col-5">
                        <button type="submit" class="btn btn-primary mt-3">Aggiungi console</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection
