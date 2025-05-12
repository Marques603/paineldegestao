<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use App\Models\Sector;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    public function index()
    {
        $costCenters = CostCenter::with('sectors')->paginate(10);
        return view('cost_center.index', compact('costCenters'));
    }

    public function create()
    {
        $sectors = Sector::all();
        return view('cost_center.create', compact('sectors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'sectors' => 'array|nullable',
        ]);

        $costCenter = CostCenter::create($validated);
        $costCenter->sectors()->sync($request->sectors ?? []);

        return redirect()->route('cost_center.index')->with('success', 'Centro de Custo criado com sucesso.');
    }

    public function edit(CostCenter $costCenter)
    {
        $sectors = Sector::all();
        $costCenter->load('sectors');
        return view('cost_center.edit', compact('costCenter', 'sectors'));
    }

    public function update(Request $request, CostCenter $costCenter)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'sectors' => 'array|nullable',
        ]);

        $costCenter->update($validated);
        $costCenter->sectors()->sync($request->sectors ?? []);

        return redirect()->route('cost_center.index')->with('success', 'Centro de Custo atualizado com sucesso.');
    }

    public function destroy(CostCenter $costCenter)
    {
        $costCenter->sectors()->detach();
        $costCenter->delete();

        return redirect()->route('cost_center.index')->with('success', 'Centro de Custo excluído com sucesso.');
    }
}
