<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request, Game $game)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ], [
            'image.required' => 'L\'immagine è obbligatoria!',
            'image.image' => 'Il file deve essere un\'immagine!',
            'image.max' => 'L\'immagine non può superare i 2MB.',
        ]);

        $path = $request->file('image')->store('games/gallery/' . $game->id, 'public');

        $newImage = new Image();
        $newImage->game_id = $game->id;
        $newImage->gallery_image_path = $path;
        $newImage->image_order = ($game->images()->max('image_order') ?? 0) + 1;;

        $newImage->save();


        return redirect()
            ->route('admin.games.show', $game)
            ->with('message', 'Immagine caricata con successo!')
            ->with('message_type', 'success');
    }

    public function destroy(Image $image)
    {

        Storage::disk('public')->delete($image->gallery_image_path);

        $image->delete();

        return redirect()
            ->route('admin.games.show', $image->game_id)
            ->with('message', 'Immagine eliminata con successo!')
            ->with('message_type', 'success');
    }
}
