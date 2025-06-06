@extends('layouts.games-layout')

@section('title', $game->title)

@section('content')

    <div class="row mt-4">
        <div class="col-8">
            <h2 class="">
                {{ $game->title }}
            </h2>

            <h4 class="text-secondary">
                {{ $game->developer->name }}
            </h4>

            <div class=" text-secondary">
                @foreach ($game->genres as $genre)
                    <span>{{ $genre->name }}</span>
                @endforeach
            </div>

            <div class="pt-3">
                <h5> Disponibile su:</h5>
                @foreach ($game->consoles as $console)
                    <span>{{ $console->name }}
                        @if (!$loop->last)
                            ,
                        @endif
                    </span>
                @endforeach
            </div>

            <div class="pt-3">
                <h5>Descrizione:</h5>
                <p>
                    {{ $game->short_description }}
                </p>
            </div>

        </div>

        <div class="col-4">
            immagine appena ho voglia di caricarla
        </div>

        <div class="pt-5">
            @if ($game->images->isEmpty())
                <h2>Non ci sono immagini per questo gioco</h2>
            @else
                <div class="row">
                    qui ci sono le immagini
                </div>
            @endif
        </div>

        <div class="pt-5">
            @if ($game->images->isEmpty())
                <h2>Non ci sono sezioni per questo gioco</h2>
            @else
                <div class="row">
                    qui ci sono le immagini
                </div>
            @endif
        </div>
    </div>

@endsection
