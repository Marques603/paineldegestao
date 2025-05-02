<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    public function index()
    {
        $cost_centers = CostCenter::orderBy('name')->paginate(10);

        return view('cost_center.index', compact('cost_centers'));
    }

    public function create()
    {
        return view('cost_center.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        CostCenter::create($request->all());

        return redirect()->route('cost_center.index')->with('success', 'Centro de Custo criado com sucesso.');
    }

    public function edit(CostCenter $cost_center)
    {
        return view('cost_center.edit', compact('cost_center'));
    }

    public function update(Request $request, CostCenter $cost_center)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $cost_center->update($request->all());

        return redirect()->route('cost_center.index')->with('success', 'Centro de Custo atualizado com sucesso.');
    }

    public function destroy(CostCenter $cost_center)
    {
        $cost_center->delete();

        return redirect()->route('cost_center.index')->with('success', 'Centro de Custo removido com sucesso.');
    }

    public function updateStatus(CostCenter $cost_center)
    {
        $cost_center->status = !$cost_center->status;
        $cost_center->save();

        return redirect()->back()->with('success', 'Status atualizado.');
    }
}
