<?php

namespace App\Http\Controllers;

use App\Models\Concierge;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Vehiclelog;


class ConciergeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function index(Request $request)
    {
    $concierges = Concierge::with('log.vehicle', 'log.user')
        ->where('status', 1)
        ->when($request->filled('search'), function ($query) use ($request) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('destination', 'like', "%{$search}%")
                ->orWhere('motive', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->paginate(10);

        $vehicles = Vehicle::all();
        $users = User::all();

        return view('concierge.index', compact('concierges', 'vehicles', 'users'));
    }


        public function create()
        {
            // Obtém os veículos que estão em uso
        $vehiclesInUse = Vehiclelog::where('status', 1)->pluck('vehicle_id')->toArray();
        $vehicles = Vehicle::when(!empty($vehiclesInUse), function ($query) use ($vehiclesInUse) {
            $query->whereNotIn('id', $vehiclesInUse);
        })->get();

        $users = User::all();

        // // Passa um flag para a view se não houver veículos disponíveis
        // $noVehiclesAvailable = $vehicles->isEmpty();

        // Pega IDs dos usuários que ainda estão com veículos na estrada
        $usersInUse = VehicleLog::where('status', 1)->pluck('user_id');

        // Pega todos os usuários exceto os que estão com veículo na estrada
        $users = User::whereNotIn('id', $usersInUse)->get();

        $vehiclesInUse = VehicleLog::where('status', 1)->pluck('vehicle_id');
        $vehicles = Vehicle::whereNotIn('id', $vehiclesInUse)->get();


        return view('concierge.create', compact('vehicles', 'users'));
        
    }

public function store(Request $request)
{
    $request->validate([
        'vehicle_id' => 'required|exists:vehicles,id',
        'user_id'    => 'required|exists:users,id',
        'motive'     => 'required|string',
        'destination'=> 'required|string',
        'kminit'     => 'required|numeric',
    ]);

    // Cria o concierge
    $concierge = Concierge::create([
        'user_upload' => auth()->id(),
        'motive'      => $request->motive,
        'destination' => $request->destination,
        'status'      => 1,
    ]);

    // Cria o registro de log de veículo vinculado
    VehicleLog::create([
        'concierge_id' => $concierge->id,
        'vehicle_id'   => $request->vehicle_id,
        'user_id'      => $request->user_id,
        'kminit'       => $request->kminit,
        'status'       => 1, // veículo em uso
    ]);



    $vehicleId = $request->vehicle_id;

    // Último KM atual do veículo
    $lastKm = VehicleLog::where('vehicle_id', $vehicleId)
        ->orderByDesc('id')
        ->value('kmcurrent') ?? 0;

    // Validação
    $request->validate([
        'kminit' => ['required', 'numeric', 'gte:' . $lastKm], // gte = greater than or equal
        // outros campos...
    ], [
        'kminit.gte' => 'A quilometragem não pode ser menor que a última registrada (' . $lastKm . ' km).'
    ]);

// Impede que o mesmo usuário saia com outro veículo sem ter retornado
$userHasVehicleOut = VehicleLog::where('user_id', $request->user_id)
    ->where('status', 1)
    ->exists();



     return redirect()->route('concierge.index')->with('success', 'Saída de Veículo registrada com sucesso.');

}




    public function show($id)
    {
        $concierge = Concierge::with(['vehicle', 'user'])->findOrFail($id);
        return view('concierge.show', compact('concierge'));
    }

public function edit($id)
{
    $concierge = Concierge::with('vehicle')->findOrFail($id);

    $vehiclelog = Vehiclelog::where('concierge_id', $concierge->id)->with('vehicle')->first();

    return view('concierge.edit', compact('concierge', 'vehiclelog'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'kmcurrent' => 'required|integer|min:0',
    ]);

    $concierge = Concierge::findOrFail($id);
    $vehicle = $concierge->vehicle;

    // Obtém o log da viagem atual
    $log = Vehiclelog::where('concierge_id', $concierge->id)->first();

    // Verifica se o km atual é menor que o km inicial
    if ($log && $request->kmcurrent < $log->kminit) {
        return redirect()->route('concierge.index')->with('error', 'O KM não pode ser menor que (' . $log->kminit . ' km).');
    }

    if ($log) {
        $log->kmcurrent = $request->kmcurrent;
        $log->status = 0; // marca como encerrado
        $log->save();
    }

    $concierge->update(['status' => 0]);

    return redirect()->route('concierge.index')->with('success', 'Retorno registrado com sucesso!');
}



    public function destroy($id)
    {
        $concierge = Concierge::findOrFail($id);
        $concierge->delete();

        return redirect()->back()->with('success', 'Registro excluído com sucesso!');
    }

    public function index2(Request $request)
    {

        $query = Concierge::with(['vehicle', 'user']);


        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('destination', 'like', "%$search%")
                  ->orWhere('motive', 'like', "%$search%");
        }

        $concierges = $query->orderByDesc('id')->paginate(10);
        $vehicles = Vehicle::all();
        $users = User::all();

        return view('concierge.index2', compact('concierges', 'vehicles', 'users'));
    }
}
