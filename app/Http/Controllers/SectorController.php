<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\User;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    
    public function index(Request $request)
    {
        $sector = Sector::query();
    
        if ($request->has('search')) {
            $sector->where('name', 'like', '%' . $request->input('search') . '%');
        }
    
        $sector = $sector->paginate(10);
        return view('sector.index', compact('sector'));
    }
    

    public function create()
    {
        $users = User::all();
        return view('sector.create', compact('users'));
    }

    public function store(Request $request)
    {
        // Validação
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'centro_custo' => 'nullable|string|max:255',
        ]);

        // Definindo status como inativo (0) por padrão
        $validated['status'] = 0;

        // Criando o setor
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
        // Validação
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|boolean',
            'user_id' => 'nullable|exists:users,id',
            'centro_custo' => 'nullable|string|max:255',
        ]);

        // Atualizando apenas os campos validados
        $sector->update($validated);

        return redirect()->route('sector.index')->with('success', 'Setor atualizado com sucesso!');
    }

    public function destroy(Sector $sector)
    {
        // Excluindo o setor
        $sector->delete();
        return redirect()->route('sector.index')->with('success', 'Setor deletado com sucesso!');
    }
}
