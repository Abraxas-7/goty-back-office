<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Developer::query();

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

        $developers = $query->paginate(20)->withQueryString();

        return view('admin.developers.index', compact('developers'));
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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:developers,name',
        ], [
            'name.required' => 'Il nome è obbligatorio!',
            'name.unique' => 'Questo developer esiste già!',
            'name.max' => 'Il nome non può superare i 255 caratteri.',
        ]);

        Developer::create($validated);

        return redirect()->route('admin.developers.index')
            ->with('message', 'Developer aggiunto con successo.')
            ->with('message_type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Developer $developer)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Developer $developer)
    {
        return view('admin.developers.edit', compact('developer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Developer $developer)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('developers', 'name')->ignoreModel($developer),
            ],
        ], [
            'name.required' => 'Il nome è obbligatorio!',
            'name.unique' => 'Questa casa produtrice esiste già!',
            'name.max' => 'Il nome non può superare i 255 caratteri.',
        ]);

        $data = $request->all();

        $developer->name = $data['name'];

        $developer->update();

        return redirect()->route('admin.developers.index')
            ->with('message', 'Developer aggiornato con successo!')
            ->with('message_type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Developer $developer)
    {
        $developer->delete();

        return redirect()->route('admin.developers.index')
            ->with('message', 'Developer eliminato con successo!')
            ->with('message_type', 'success');
    }
}
