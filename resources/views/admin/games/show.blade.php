@extends('layouts.games-layout')

@section('title', $game->title)

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

    <x-edit-bar :return="route('admin.games.index')" :edit="route('admin.games.edit', $game)" :delete="route('admin.games.destroy', $game)" :item="$game" />

    <div class="row mt-4">
        <div class="col-9">
            <h2>{{ $game->title }}</h2>

            <h4 class="text-secondary">{{ $game->developer->name }}</h4>

            <div class="text-secondary">
                @foreach ($game->genres as $genre)
                    <span>{{ $genre->name }}</span>
                @endforeach
            </div>

            <div class="pt-3">
                <h5>Disponibile su:</h5>
                @foreach ($game->consoles as $console)
                    <span>{{ $console->name }}@if (!$loop->last)
                            ,
                        @endif
                    </span>
                @endforeach
            </div>

            <div class="pt-3">
                <h5>Descrizione:</h5>
                <p>{{ $game->short_description }}</p>
            </div>
        </div>

        <div class="col-3">
            <div class="border border-2 rounded overflow-hidden shadow" style="aspect-ratio: 2/3;">
                <img src="{{ asset('storage/' . $game->cover_image) }}" alt="{{ $game->title }}"
                    class="img-fluid w-100 h-100 object-fit-cover">
            </div>
        </div>

        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center pb-3">
                <h2>Lista Sezioni</h2>
                <div>
                    <a href="{{ route('admin.sections.create', $game) }}" class="btn btn-primary">Nuova sezione</a>
                    <button id="toggle-ordering" class="btn btn-secondary">Ordina</button>
                </div>
            </div>

            @if ($game->sections->isEmpty())
                <h5>Non ci sono sezioni per questo gioco</h5>
            @else
                <div id="sections-cards-container">
                    @foreach ($game->sections as $section)
                        <x-section-card :section="$section" />
                    @endforeach
                </div>
            @endif
        </div>

        @if (!$game->sections->isEmpty())
            <div id="sections-list-ordering" class="d-none mt-3">
                <ul id="sections-list" class="list-group">
                    @foreach ($game->sections as $section)
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            data-id="{{ $section->id }}">
                            <span>{{ $section->title }}</span>
                            <span class="handle bi bi-list"></span>
                        </li>
                    @endforeach
                </ul>
                <small class="text-muted">Trascina le sezioni per riordinarle.</small>
            </div>
        @endif

        <div class="pt-5">
            @if ($game->images->isEmpty())
                <h2>Non ci sono immagini per questo gioco</h2>
            @else
                <div class="row">
                    qui ci sono le immagini
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const orderingContainer = document.getElementById('sections-list-ordering');
            const cardsContainer = document.getElementById('sections-cards-container');
            const toggleOrderingBtn = document.getElementById('toggle-ordering');
            const createBtn = document.querySelector('a.btn.btn-primary');
            let orderingActive = false;

            const el = document.getElementById('sections-list');
            const sortable = Sortable.create(el, {
                animation: 150,
                handle: '.handle',
                onEnd: function(evt) {
                    let order = [];
                    el.querySelectorAll('li').forEach((li, index) => {
                        order.push({
                            id: li.dataset.id,
                            position: index + 1
                        });
                    });

                    axios.post("{{ route('admin.sections.update-order') }}", {
                            order: order
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            console.log(response.data.message);
                        })
                        .catch(error => {
                            console.error('Errore:', error);
                        });
                }
            });

            toggleOrderingBtn.addEventListener('click', () => {
                orderingActive = !orderingActive;
                orderingContainer.classList.toggle('d-none');
                cardsContainer.classList.toggle('d-none');
                toggleOrderingBtn.classList.remove('btn-primary');
                toggleOrderingBtn.classList.add('btn-secondary');
                createBtn.classList.toggle('d-none');
                toggleOrderingBtn.innerText = orderingActive ? 'Chiudi Ordinamento' : 'Ordina';
                if (!orderingActive) {
                    window.location.reload();
                }
            });
        });
    </script>


@endsection
