<div class="p-3 border border-1 border bg-white rounded-3 shadow-sm">
    <form action="{{ $action }}" method="GET" class="row w-100 g-2 d-flex align-items-center justify-between">
        <div class="col-8">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cerca...">
        </div>

        <div class="col-2">
            <select name="sort" class="form-select w-100">
                <option value="">Ordina per</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A-Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z-A</option>
                <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Più recenti (creazione)
                </option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Meno recenti (creazione)
                </option>
                <option value="updated_recent" {{ request('sort') == 'updated_recent' ? 'selected' : '' }}>Più recenti
                    (aggiornamento)</option>
                <option value="updated_oldest" {{ request('sort') == 'updated_oldest' ? 'selected' : '' }}>Meno recenti
                    (aggiornamento)</option>
            </select>
        </div>

        <div class="col-2 pe-0">
            <button type="submit" class="btn btn-success w-100">Cerca</button>
        </div>
    </form>
</div>
