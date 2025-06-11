<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function index(Request $request)
    {
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
            }
        }

        $games = $query
            ->with(['consoles', 'genres', 'developer'])
            ->paginate(20)
            ->withQueryString();

        if ($games->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Nessun gioco trovato per i criteri specificati.'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => $games,
        ]);
    }

    public function show($id)
    {
        $game = Game::with(['developer', 'genres', 'consoles'])->find($id);

        if (!$game) {
            return response()->json([
                'success' => false,
                'message' => 'Gioco non trovato.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $game,
        ]);
    }

    public function images(Game $game)
    {
        if ($game->images->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $game->images,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $game->images,
        ]);
    }

    public function sections(Game $game)
    {
        if ($game->images->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $game->sections,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $game->sections,
        ]);
    }
}
