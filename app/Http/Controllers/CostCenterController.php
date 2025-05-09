<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use App\Models\Sector;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    public function index()
    {
        // Lista todos os centros de custo com setores relacionados
        $costCenters = CostCenter::with('sectors')->paginate(10);
        return view('cost_center.index', compact('costCenters'));
    }

    public function create()
    {
        // Lista todos os setores
        $sectors = Sector::all();
        return view('cost_center.create', compact('sectors'));
    }

    public function store(Request $request)
    {
        // Valida os dados recebidos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string',
            'sectors' => 'array|nullable',
        ]);

        // Cria o centro de custo
        $costCenter = CostCenter::create($validated);

        // Sincroniza os setores selecionados
        $costCenter->sectors()->sync($request->sectors ?? []);

        return redirect()->route('cost_center.index')->with('success', 'Centro de Custo criado com sucesso.');
    }

    public function edit(CostCenter $costCenter)
    {
        // Lista todos os setores
        $sectors = Sector::all();
        $costCenter->load('sectors');
        return view('cost_center.edit', compact('costCenter', 'sectors'));
    }

    public function update(Request $request, CostCenter $costCenter)
    {
        // Valida os dados recebidos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string',
            'sectors' => 'array|nullable',
        ]);

        // Atualiza o centro de custo
        $costCenter->update($validated);

        // Sincroniza os setores selecionados
        $costCenter->sectors()->sync($request->sectors ?? []);

        return redirect()->route('cost_center.index')->with('success', 'Centro de Custo atualizado com sucesso.');
    }

    public function destroy(CostCenter $costCenter)
    {
        // Remove a relação com os setores e exclui o centro de custo
        $costCenter->sectors()->detach();
        $costCenter->delete();

        return redirect()->route('cost_center.index')->with('success', 'Centro de Custo excluído com sucesso.');
    }
}
