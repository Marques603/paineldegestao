<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\User;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index(Request $request)
    {
        $query = Sector::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $sectors = Sector::with('user')->paginate(14);

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
            'descricao' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'centro_custo' => 'nullable|string|max:255',
        ]);

        $validated['status'] = 0;

        Sector::create($validated);

        return redirect()->route('sector.index')->with('success', 'Setor criado como inativo!');
    }

    public function edit(Sector $sector)
    {
        $users = User::all();
        return view('sector.edit', compact('sector', 'users'));
    }

    public function update(Request $request, Sector $sector)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|boolean',
            'user_id' => 'nullable|exists:users,id',
            'centro_custo' => 'nullable|string|max:255',
        ]);

        $sector->update($request->all());

        return redirect()->route('sector.index')->with('success', 'Setor atualizado com sucesso!');
    }

    public function destroy(Sector $sector)
    {
        $sector->delete();
        return redirect()->route('sector.index')->with('success', 'Setor deletado com sucesso!');
    }
}
