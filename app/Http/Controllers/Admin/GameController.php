<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Console;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $consoles = Console::all();
        $genres = Genre::all();
        $developers = Developer::all();

        $query = Game::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('console')) {
            $query->whereHas('consoles', function ($q) use ($request) {
                $q->where('consoles.id', $request->input('console'));
            });
        }

        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id', $request->input('genre'));
            });
        }

        if ($request->filled('developer')) {
            $query->where('developer_id', $request->input('developer'));
        }

        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'recent':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'updated_recent':
                    $query->orderBy('updated_at', 'desc');
                    break;
                case 'updated_oldest':
                    $query->orderBy('updated_at', 'asc');
                    break;
                default:
                    break;
            }
        }

        $games = $query->paginate(20)->withQueryString();

        return view('admin.games.index', compact('games', 'consoles', 'genres', 'developers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $consoles = Console::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();
        $developers = Developer::orderBy('name')->get();

        return view('admin.games.create', compact('consoles', 'genres', 'developers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'developer_id' => ['required'],
            'short_description' => ['required', 'string'],
            'release_date' => ['required', 'date'],
            'cover_image' => ['required', 'image', 'max:2048'],
            'consoles' => ['required', 'array'],
            'genres' => ['required', 'array'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:100'],
        ], [
            'title.required' => 'Il titolo è obbligatorio!',
            'title.max' => 'Il titolo non può superare i 255 caratteri.',

            'developer_id.required' => 'Devi selezionare uno sviluppatore.',

            'short_description.required' => 'La descrizione è obbligatoria.',

            'release_date.required' => 'La data di rilascio è obbligatoria.',

            'cover_image.required' => 'L\'immagine è obbligatoria.',
            'cover_image.image' => 'Il file deve essere un\'immagine.',
            'cover_image.max' => 'L\'immagine non può superare 2MB.',

            'consoles.required' => 'Seleziona almeno una console!',
            'genres.required' => 'Seleziona almeno un genere!',

            'rating.integer' => 'Il voto deve essere un numero intero.',
            'rating.min' => 'Il voto minimo è 1.',
            'rating.max' => 'Il voto massimo è 100.',
        ]);

        $slug = Str::slug($request['title']);

        $newGame = new Game();
        $newGame->title = $validated['title'];
        $newGame->slug = $slug;
        $newGame->rating = $validated['rating'];
        $newGame->developer_id = $validated['developer_id'];
        $newGame->short_description = $validated['short_description'];
        $newGame->release_date = $validated['release_date'];

        if ($request->hasFile('cover_image')) {
            $img_path = $request->file('cover_image')->store('games/covers', 'public');
            $newGame->cover_image = $img_path;
        }

        $newGame->save();

        $newGame->consoles()->attach($validated['consoles']);
        $newGame->genres()->attach($validated['genres']);

        return redirect()->route('admin.games.show', $newGame)
            ->with('message', 'Gioco creato con successo!')
            ->with('message_type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        return view('admin.games.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        $consoles = Console::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();
        $developers = Developer::orderBy('name')->get();

        return view('admin.games.edit', compact('game', 'consoles', 'genres', 'developers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'developer_id' => ['required', 'exists:developers,id'],
            'short_description' => ['required', 'string'],
            'release_date' => ['required', 'date'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'consoles' => ['required', 'array'],
            'genres' => ['required', 'array'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:100'],
        ], [
            'title.required' => 'Il titolo è obbligatorio!',
            'title.max' => 'Il titolo non può superare i 255 caratteri.',

            'developer_id.required' => 'Devi selezionare uno sviluppatore.',
            'developer_id.exists' => 'Lo sviluppatore selezionato non esiste.',

            'short_description.required' => 'La descrizione è obbligatoria.',

            'release_date.required' => 'La data di rilascio è obbligatoria.',

            'cover_image.image' => 'Il file deve essere un\'immagine.',
            'cover_image.max' => 'L\'immagine non può superare 2MB.',

            'consoles.required' => 'Seleziona almeno una console!',
            'genres.required' => 'Seleziona almeno un genere!',

            'rating.integer' => 'Il voto deve essere un numero intero.',
            'rating.min' => 'Il voto minimo è 1.',
            'rating.max' => 'Il voto massimo è 100.',
        ]);

        if ($request->title !== $game->title) {
            $slug = Str::slug($request['title']);
            $game->slug = $slug;
        }

        $game->title = $validated['title'];
        $game->developer_id = $validated['developer_id'];
        $game->short_description = $validated['short_description'];
        $game->release_date = $validated['release_date'];
        $game->rating = $validated['rating'];

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($game->cover_image);
            $img_path = $request->file('cover_image')->store('games/covers', 'public');
            $game->cover_image = $img_path;
        }

        $game->save();

        $game->consoles()->sync($validated['consoles']);
        $game->genres()->sync($validated['genres']);

        return redirect()->route('admin.games.show', $game)
            ->with('message', 'Gioco aggiornato con successo!')
            ->with('message_type', 'success');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        if ($game->cover_image) {
            Storage::disk('public')->delete($game->cover_image);
        }

        $game->delete();

        return redirect()->route('admin.games.index')
            ->with('message', 'Gioco eliminato con successo!')
            ->with('message_type', 'success');
    }
}
