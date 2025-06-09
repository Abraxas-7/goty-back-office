<div class="p-2 border border-1 bg-white rounded-3 shadow-sm mt-4">
    <div class="row">
        <div class="col-6">
            <a href="{{ $return }}" class="text-black">
                <i class="bi bi-arrow-left fs-5 px-2"></i>
            </a>
        </div>

        <div class="col-6 d-flex justify-content-end">
            <a href="{{ $edit }}" class="text-warning">
                <i class="bi bi-pencil fs-5 px-2"></i>
            </a>

            <button type="button" class="border-0 bg-transparent text-danger p-0" data-bs-toggle="modal"
                data-bs-target="#deleteGenreModal-{{ $item->id }}">
                <i class="bi bi-trash fs-5 px-2"></i>
            </button>

            <!-- Modale eliminazione form -->
            <div class="modal fade" id="deleteGenreModal-{{ $item->id }}" tabindex="-1"
                aria-labelledby="deleteGenreModalLabel-{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="deleteGenreModalLabel-{{ $item->id }}">
                                Conferma eliminazione
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Chiudi"></button>
                        </div>
                        <div class="modal-body">
                            Sei sicuro di voler eliminare <strong>{{ $item->title }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                            <form action="{{ $delete }}" method="POST" class="d-inline">
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
