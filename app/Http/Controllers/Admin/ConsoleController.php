<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Console;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ConsoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Console::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'desc':
                    $query->orderBy('name', 'desc');
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

        $consoles = $query->paginate(20)->withQueryString();

        return view('admin.consoles.index', compact('consoles'));
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
        $console = Console::firstOrCreate([
            'name' => $request->input('name'),
        ]);

        if ($console->wasRecentlyCreated) {
            return redirect()->route('admin.consoles.index')
                ->with('message', 'Console aggiunta con successo.')
                ->with('message_type', 'success');;
        } else {
            return redirect()->route('admin.consoles.index')
                ->with('message', 'Console già esistente.')
                ->with('message_type', 'error');;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Console $console)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Console $console)
    {
        return view('admin.consoles.edit', compact('console'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Console $console)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('consoles', 'name')->ignoreModel($console),
            ],
        ], [
            'name.required' => 'Il nome è obbligatorio!',
            'name.unique' => 'Questa console esiste già!',
            'name.max' => 'Il nome non può superare i 255 caratteri.',
        ]);

        $data = $request->all();

        $console->name = $data['name'];

        $console->update();

        return redirect()->route('admin.consoles.index')
            ->with('message', 'Console aggiornata con successo!')
            ->with('message_type', 'success');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Console $console)
    {
        $console->delete();

        return redirect()->route('admin.consoles.index');
    }
}
