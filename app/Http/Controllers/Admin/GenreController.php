<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::all();

        return view('admin.genres.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $genre = Genre::firstOrCreate([
            'name' => $request->input('name'),
        ]);

        if ($genre->wasRecentlyCreated) {
            return redirect()->route('admin.genres.index')
                ->with('message', 'Genere aggiunto con successo.')
                ->with('message_type', 'success');;
        } else {
            return redirect()->route('admin.genres.index')
                ->with('message', 'Genere già esistente.')
                ->with('message_type', 'error');;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('genres', 'name')->ignoreModel($genre),
            ],
        ], [
            'name.required' => 'Il nome è obbligatorio!',
            'name.unique' => 'Questa genere esiste già!',
            'name.max' => 'Il nome non può superare i 255 caratteri.',
        ]);

        $data = $request->all();

        $genre->name = $data['name'];

        $genre->update();

        return redirect()->route('admin.genres.index')
            ->with('message', 'Genere aggiornato con successo!')
            ->with('message_type', 'success');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()->route('admin.genres.index');
    }
}
