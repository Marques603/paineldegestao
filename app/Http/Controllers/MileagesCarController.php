<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MileagesCarController extends Controller
{
    public function index()
    {
        // Lógica para listar as milhagens dos carros
        // Pode incluir paginação, filtros, etc.
        return view('mileages.index');
    }
    public function store(Request $request)
{
    $request->validate([
        'vehicle_id' => 'required|exists:vehicles,id',
        'date'       => 'required|date',
        'km'         => 'required|integer|min:0',
        'observation'=> 'nullable|string',
    ]);

    \App\Models\MileagesCar::create([
        'vehicle_id' => $request->vehicle_id,
        'date'       => $request->date,
        'km'         => $request->km,
        'observation'=> $request->observation,
    ]);

    return redirect()->back()->with('success', 'Quilometragem registrada com sucesso!');
}
public function show($id)
{
    // Lógica para exibir detalhes de uma milhagem específica
    $mileage = \App\Models\MileagesCar::findOrFail($id);
    return view('mileages.show', compact('mileage'));
}
public function edit($id)
{
    // Lógica para exibir o formulário de edição de uma milhagem específica
    $mileage = \App\Models\MileagesCar::findOrFail($id);
    return view('mileages.edit', compact('mileage'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'concierge_id' => 'required|exists:concierge,id',
        'vehicle_id' => 'required|exists:vehicles,id',
        'date'       => 'required|date',
        'km'         => 'required|integer|min:0',
        'observation'=> 'nullable|string',
    ]);

    $mileage = \App\Models\MileagesCar::findOrFail($id);
    $mileage->update([
        'concierge_id' => $request->concierge_id,
        'vehicle_id' => $request->vehicle_id,
        'date'       => $request->date,
        'km'         => $request->km,
        'observation'=> $request->observation,
    ]);

    return redirect()->route('mileages.index')->with('success', 'Quilometragem atualizada com sucesso!');
}
}