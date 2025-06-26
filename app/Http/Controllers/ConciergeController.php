<?php

namespace App\Http\Controllers;

use App\Models\Concierge;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\MileagesCar;
use App\Models\User;




class ConciergeController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
}

public function index(Request $request)
{
    $query = Concierge::query();

    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('destination', 'like', "%$search%")
              ->orWhere('motive', 'like', "%$search%");
    }

    $concierges = $query->paginate(10);
    $vehicles = Vehicle::all();
    $users = User::all();

    // Pega a última quilometragem de cada veículo
    $mileages = [];
    foreach ($vehicles as $vehicle) {
        $lastMileage = MileagesCar::where('vehicle_id', $vehicle->id)
            ->orderByDesc('id')
            ->first();

        $mileages[$vehicle->id] = [
            'kminit'    => $lastMileage->kminit ?? 'Sem registro',
            'kmcurrent' => $lastMileage->kmcurrent ?? 'Sem registro'
        ];
    }

    return view('concierge.index', compact('concierges', 'vehicles', 'users', 'mileages'));
}



public function create()
{
    $vehicles = Vehicle::all();
    $users = User::all();

    // Buscar a última quilometragem de cada veículo
    $mileage = [];

    foreach ($vehicles as $vehicle) {
        $lastMileage = MileagesCar::where('vehicle_id', $vehicle->id)
            ->orderByDesc('id')
            ->first();

        $mileage[$vehicle->id] = $lastMileage ? $lastMileage->kmcurrent : 0;
    }

    return view('concierge.create', compact('vehicles', 'users', 'mileage'));
}

public function store(Request $request)
{
    $request->validate([
       
        'motive'      => 'required|string',
        'destination' => 'required|string',
        'vehicle_id'  => 'required|exists:vehicles,id',
        'user_id'     => 'required|exists:vehicles,id',
        'kminit'      => 'required|integer|min:0',
    ]);

    // $vehicle = Vehicle::find($request->vehicle_id);


    $concierge = Concierge::create([

        'user_upload' => auth()->id(),
        'motive'      => $request->motive,
        'destination' => $request->destination,
        'status' => 1, // 1 para ativo, 0 para inativo

     ]);

    // Criar o registro de quilometragem inicial
    \App\Models\MileagesCar::create([
        'concierge_id' => $concierge->id,
        'vehicle_id'   => $request->vehicle_id,
        'kminit'       => $request->kminit,
    ]);


    // Relacionamento com tabela pivot
    $concierge->vehicles()->sync([$request->vehicle_id]);
    $concierge->users()->sync([$request->user_id]);
    // Se necessário, você pode adicionar mais lógica aqui, como enviar notificações ou registrar logs
    // Redirecionar ou retornar uma resposta
    // Exemplo de redirecionamento com mensagem de sucesso
    return redirect()->route('concierge.index')->with('success', 'Registro salvo com sucesso!');
    
}
    public function show($id)
    {
    }   
    public function edit($id)
{
    $concierge = Concierge::with('mileages.vehicle')->findOrFail($id);

    // Pegando o primeiro mileage (registro de quilometragem)
    $mileage = $concierge->mileages->first();

    return view('concierge.edit', [
        'concierge' => $concierge,
        'mileage'   => $mileage, // ← Aqui você envia para a view
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'kmcurrent' => 'required|integer|min:0',

    ]);

    $data = $request->all();
$data['status'] = 0;

// Agora sim pode atualizar o model
$concierge = Concierge::findOrFail($id);
$concierge->update($data); 
    $concierge = Concierge::findOrFail($id);
    
    // Atualiza quilometragem de retorno na tabela mileages_car
    $mileage = $concierge->mileages()->first();
    if ($mileage) {
        $mileage->update([
            'kmcurrent' => $request->kmcurrent,
        ]);
    }

    return redirect()->route('concierge.index')->with('success', 'Retorno registrado com sucesso!');
}


  public function destroy($id)
  { 
    $concierge = Concierge::find($id);
    $concierge->delete();
    return redirect()->back()->with("success","
    Registro salvo com sucesso!");
  }
 

public function index2(Request $request)
{
    $vehicleId = 2; // ID fixo do veículo que você quer acompanhar (ex: Gol)

    // Lista os registros do concierge apenas para esse veículo
    $concierges = Concierge::whereHas('vehicles', function ($query) use ($vehicleId) {
        $query->where('vehicles.id', $vehicleId);
    })
    ->with(['vehicles', 'users'])
    ->orderByDesc('id')
    ->paginate(10);

    // Último KM final registrado desse veículo
    $ultimoKm = MileagesCar::where('vehicle_id', $vehicleId)
        ->whereNotNull('kminit')
        ->orderByDesc('id')
        ->first();

    return view('concierge.index2', compact('concierges', 'ultimoKm'));
}







}