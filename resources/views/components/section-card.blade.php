<div class="row border border-1 bg-white rounded-3 shadow-sm p-3 mb-3">
    <div class="col-12">
        <div class="d-flex flex-row justify-content-between pb-2">
            <div class="">
                <h3>
                    {{ $section->title }}
                </h3>
            </div>

            <div class="d-flex flex-row align-items-center gap-2">
                <a href="{{ route('admin.sections.edit', $section) }}" class="text-warning">
                    <i class="bi bi-pencil fs-5 px-1"></i>
                </a>

                <button type="button" class="border-0 bg-transparent text-danger p-0" data-bs-toggle="modal"
                    data-bs-target="#deleteGenreModal-{{ $section->id }}">
                    <i class="bi bi-trash fs-5 px-2"></i>
                </button>

                <!-- Modale eliminazione form -->
                <div class="modal fade" id="deleteGenreModal-{{ $section->id }}" tabindex="-1"
                    aria-labelledby="deleteGenreModalLabel-{{ $section->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="deleteGenreModalLabel-{{ $section->id }}">
                                    Conferma eliminazione
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Chiudi"></button>
                            </div>
                            <div class="modal-body">
                                Sei sicuro di voler eliminare <strong>{{ $section->title }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annulla</button>
                                <form action="{{ route('admin.sections.destroy', $section) }}" method="POST"
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
    </div>
    <div class="col-9">
        <p>
            {{ $section->description }}
        </p>
    </div>
    <div class="col-3">
        <img src="{{ asset('storage/' . $section->section_image_path) }}" alt="{{ $section->title }}"
            class="img-fluid object-fit-cover rounded" style="aspect-ratio: 16/9; width: 100%; max-width: 100%;">
    </div>
</div>
