@extends('layouts.games-layout')

@section('title', 'Lista Giochi')

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

    <x-games-search-bar :action="route('admin.games.index')" />

    <div class="d-flex flex-row-reverse mt-5">
        <a href="{{ route('admin.games.create') }}" class="btn btn-primary">Aggiungi gioco</a>
    </div>

    <div class="mt-3">
        @if (!$games->count())
            <div class="text-center py-5">
                <h2 class="text-center">Nessun gioco trovato</h2>
            </div>
        @else
            <table class="table table-striped table-bordered ">
                <thead class="table-dark">
                    <tr class="fs-5">
                        <th class="col-10">Nome</th>
                        <th class="col-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($games as $game)
                        <tr>
                            <td class="align-middle">{{ $game->title }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.games.show', $game) }}" class="btn btn-outline-primary border-2">
                                    Visualizza gioco
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="mt-3">
            {{ $games->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
