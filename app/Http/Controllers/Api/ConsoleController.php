<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Console;
use Illuminate\Http\Request;

class ConsoleController extends Controller
{
    public function index()
    {
        $consoles = Console::all();

        if ($consoles->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Nessuna console trovata.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $consoles,
        ]);
    }
}
