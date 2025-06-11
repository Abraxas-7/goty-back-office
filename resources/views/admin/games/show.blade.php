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
                            <div class="d-flex align-items-center gap-2">
                                @if ($section->section_image_path)
                                    <img src="{{ asset('storage/' . $section->section_image_path) }}"
                                        alt="{{ $section->title }}"
                                        style="width: 160px; height: 90px; object-fit: cover; border-radius: 4px;">
                                @endif
                                <span>{{ $section->title }} ({{ $section->section_order }})</span>
                            </div>
                            <span class="handle bi bi-list"></span>
                        </li>
                    @endforeach
                </ul>
                <small class="text-muted">Trascina le sezioni per riordinarle.</small>
            </div>
        @endif

        <div class="mt-5">
            <div class="d-flex pb-2">
                <h2>Galleria</h2>
            </div>
            <div class="row align-items-center">
                <div class="col-12">
                    <form action="{{ route('admin.images.store', $game) }}" method="POST" enctype="multipart/form-data"
                        class="d-flex align-items-center gap-2">
                        @csrf
                        <input type="file" class="form-control" name="image" required accept="image/*">
                        <button type="submit" class="btn btn-success">Aggiungi</button>
                    </form>
                </div>
            </div>
            <div class="mb-3">
                <small class="text-muted">Carica un immagine da aggiungere alla galleria</small>
            </div>


            @if ($game->images->isEmpty())
                <h5>Non ci sono immagini per questo gioco</h5>
            @else
                <div id="images-cards-container" class="row g-2">
                    @foreach ($game->images as $image)
                        <div class="col-4 py-1 position-relative">
                            <x-image-card :path="$image->gallery_image_path" :alt="$game->title" />

                            <div class="position-absolute top-0 end-0 py-2 px-2">
                                <button type="button" class="border-0 bg-transparent text-danger p-0"
                                    data-bs-toggle="modal" data-bs-target="#deleteImageModal-{{ $image->id }}">
                                    <i class="fa fa-times px-1"></i>
                                </button>

                                <!-- Modale eliminazione form -->
                                <div class="modal fade" id="deleteImageModal-{{ $image->id }}" tabindex="-1"
                                    aria-labelledby="deleteImageModalLabel-{{ $image->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5"
                                                    id="deleteImageModalLabel-{{ $image->id }}">
                                                    Conferma eliminazione
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Chiudi"></button>
                                            </div>
                                            <div class="modal-body">
                                                Sei sicuro di voler eliminare quest'immagine di
                                                <strong>{{ $game->title }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Annulla</button>
                                                <form action="{{ route('admin.images.destroy', $image) }}" method="POST"
                                                    class="d-inline">
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
                            </div>
                        </div>
                    @endforeach
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
