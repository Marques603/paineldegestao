<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle; // Certifique-se de que o modelo Vehicle está importado corretamente
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
public function index()
{
    $vehicles = Vehicle::paginate(10); // importante
    return view('vehicles.index', compact('vehicles'));
}

    public function create()
    {
        // Lógica para exibir o formulário de criação de veículo
        
        return view('vehicles.create');
    }
    public function store(Request $request)
  {
    $request->validate([
        'name'=> 'required',
        'model' => 'required|in:Hatch,Sedan,SUV,Picape,Caminhonete,Van,Utilitário,Caminhão',
        'plate' => 'required',
        'brand' => 'required',
        'kminit' => 'nullable|numeric',
        'kmcurrent' => 'nullable|numeric',
        'kmend' => 'nullable|numeric',
    ]);

    // Criar e salvar o veículo
    Vehicle::create([
        'name' => $request->name,
        'model' => $request->model,
        'plate' => $request->plate,
        'brand' => $request->brand,
        'kminit' => $request->kminit,
        'kmcurrent' => $request->kmcurrent,
        'kmend' => $request->kmend,
        'user_id' => Auth::id(), // se houver relacionamento com usuário
    ]);

    return redirect()->route('vehicles.index')->with('success', 'Veículo criado com sucesso!');
}
    public function edit($id)
    {
        // Lógica para exibir o formulário de edição de veículo
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicles.edit', compact('vehicle'));

    }
   public function update(Request $request, $id)
{
    // Validação dos dados
    $validated = $request->validate([
        'name' => 'required',
        'model' => 'required|in:Hatch,Sedan,SUV,Picape,Caminhonete,Van,Utilitário,Caminhão',
        'plate' => 'required',
        'brand' => 'required',
        'kminit' => 'nullable|numeric',
        'kmcurrent' => 'nullable|numeric',
        'kmend' => 'nullable|numeric',
    ]);

try {
    $vehicle = Vehicle::findOrFail($id);
    $vehicle->update($validated);
    return redirect()->route('vehicles.index')->with('success', 'Veículo atualizado com sucesso!');
} catch (\Exception $e) {
    return back()->with('error', 'Erro ao atualizar: ' . $e->getMessage());
}

}
    public function destroy($id)
    {
        Vehicle::findOrFail($id)->delete();
        return redirect()->route('vehicles.index')->with('success','Veículos deletado com sucesso!');
}
}