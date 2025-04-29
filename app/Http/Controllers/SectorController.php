<?php

namespace App\Http\Controllers;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index(Request $request)
{
    $query = Sector::query();

    // Se quiser aplicar busca por nome
    if ($request->has('search')) {
        $query->where('nome', 'like', '%' . $request->search . '%');
    }

    // Se quiser filtro por status
    if ($request->has('status') && $request->status !== '') {
        $query->where('status', $request->status);
    }

    $sectors = $query->paginate(14);

    return view('sector.index', compact('sectors'));
}
    public function create()
    {
        return view('sector.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'responsavel' => 'nullable|string|max:255',
            'centro_custo' => 'nullable|string|max:255',
        ]);
    
        // Força o status como inativo
        $validated['status'] = 0; // Adiciona o status como inativo (0)
    
        // Cria o setor com os dados validados
        Sector::create($validated);
    
        // Redireciona para a página de lista com mensagem de sucesso
        return redirect()->route('sector.index')->with('success', 'Setor criado como inativo!');
    }

    public function edit(Sector $sector)
    {
        return view('sector.edit', compact('sector'));
    }

    public function update(Request $request, sector $sector)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|boolean',
            'responsavel' => 'nullable|string|max:255',
            'centro_custo' => 'nullable|string|max:255',
        ]);

        $sector->update($request->all());
        return redirect()->route('sector.index')->with('success', 'setor atualizado com sucesso!');
    }

    public function destroy(sector $sector)
    {
        $sector->delete();
        return redirect()->route('sector.index')->with('success', 'setor deletado com sucesso!');
    }
}
