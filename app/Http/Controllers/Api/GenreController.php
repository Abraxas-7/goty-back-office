<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();

        if ($genres->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Nessun genere trovato.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $genres,
        ]);
    }
}
