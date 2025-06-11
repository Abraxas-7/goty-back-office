<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function index()
    {
        $developer = Developer::all();

        if ($developer->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Nessun developer trovato.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $developer,
        ]);
    }
}
