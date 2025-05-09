<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\User;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index()
    {
        $sectors = Sector::with('users')->paginate(10);
        return view('sector.index', compact('sectors'));
    }

    public function create()
    {
        $users = User::all();
        return view('sector.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'users' => 'array|nullable',
        ]);

        $sector = Sector::create($validated);
        $sector->users()->sync($request->users ?? []);

        return redirect()->route('sector.index')->with('success', 'Setor criado com sucesso.');
    }

    public function edit(Sector $sector)
    {
        $users = User::all();
        $sector->load('users');
        return view('sector.edit', compact('sector', 'users'));
    }

    public function update(Request $request, Sector $sector)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'users' => 'array|nullable',
        ]);

        $sector->update($validated);
        $sector->users()->sync($request->users ?? []);

        return redirect()->route('sector.index')->with('success', 'Setor atualizado com sucesso.');
    }

    public function destroy(Sector $sector)
    {
        $sector->users()->detach();
        $sector->delete();

        return redirect()->route('sector.index')->with('success', 'Setor excluído com sucesso.');
    }
}
