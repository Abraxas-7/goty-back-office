<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $developers = Developer::all();

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
        $developer = Developer::firstOrCreate([
            'name' => $request->input('name'),
        ]);

        if ($developer->wasRecentlyCreated) {
            return redirect()->route('admin.developers.index')
                ->with('message', 'Developer aggiunto con successo.')
                ->with('message_type', 'success');;
        } else {
            return redirect()->route('admin.developers.index')
                ->with('message', 'Developer già esistente.')
                ->with('message_type', 'error');;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Developer $developer)
    {
        return view('admin.developers.show', compact('developer'));
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
        $data = $request->all();

        $developer->name = $data['name'];

        $developer->update();

        return redirect()->route('admin.developers.show', $developer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Developer $developer)
    {
        $developer->delete();

        return redirect()->route('admin.developers.index');
    }
}
