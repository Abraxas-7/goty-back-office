<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Game $game)
    {

        return view('admin.sections.create', compact('game'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ], [
            'title.required' => 'Il titolo è obbligatorio!',
            'title.max' => 'Il titolo non può superare i 255 caratteri.',
            'description.required' => 'La descrizione è obbligatoria!',
            'image.image' => 'Il file caricato deve essere un\'immagine.',
            'image.max' => 'L\'immagine non può superare i 2MB.',
        ]);

        $maxOrder = $game->sections()->max('section_order');
        $newOrder = $maxOrder !== null ? $maxOrder + 1 : 1;

        $section = new Section($validated);
        $section->game_id = $game->id;
        $section->section_order = $newOrder;

        if ($request->hasFile('image')) {
            $img_path = $request->file('image')->store('games/sections/' . $game->id, 'public');
            $section->section_image_path = $img_path;
        }

        $section->save();

        return redirect()
            ->route('admin.games.show', $game->id)
            ->with('message', 'Sezione creata con successo!')
            ->with('message_type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ], [
            'title.required' => 'Il titolo è obbligatorio!',
            'title.max' => 'Il titolo non può superare i 255 caratteri.',
            'description.required' => 'La descrizione è obbligatoria!',
            'image.image' => 'Il file caricato deve essere un\'immagine.',
            'image.max' => 'L\'immagine non può superare i 2MB.',
        ]);

        $section->title = $validated['title'];
        $section->description = $validated['description'];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($section->section_image_path);
            $img_path = $request->file('image')->store('games/sections/' . $section->game_id, 'public');
            $section->section_image_path = $img_path;
        }

        $section->save();

        return redirect()
            ->route('admin.games.show', $section->game_id)
            ->with('message', 'Sezione aggiornata con successo!')
            ->with('message_type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        Storage::disk('public')->delete($section->section_image_path);

        $section->delete();

        return redirect()
            ->route('admin.games.show', $section->game_id)
            ->with('message', 'Sezione eliminata con successo!')
            ->with('message_type', 'success');
    }

    // ORDINE
    public function updateOrder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $item) {
            Section::where('id', $item['id'])->update([
                'section_order' => $item['position']
            ]);
        }

        return response()->json(['message' => 'Ordine aggiornato!']);
    }
}
