<?php

namespace App\Http\Controllers;

use App\Models\Concierge;
use Illuminate\Http\Request;
use App\Models\Vehicle;
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

    return view('concierge.index', compact('concierges'));
}

    public function create()
    {
        $vehicles = Vehicle::all();
        $users = User::all();
        return view("concierge.create", compact('vehicles','users'));
}
public function store(Request $request)
{
    $request->validate([
       
        'date'        => 'required|date',
        'motive'      => 'required|string',
        'destination' => 'required|string',
        'timeinit'    => 'required|date_format:H:i',
        'timeend'     => 'nullable|date_format:H:i',
        'vehicle_id'  => 'required|exists:vehicles,id',
        'user_id'     => 'required|exists:vehicles,id',
    ]);

    $concierge = Concierge::create([

        'user_upload' => auth()->id(),
        'date'        => $request->date,
        'motive'      => $request->motive,
        'destination' => $request->destination,
        'timeinit'    => $request->timeinit,
        'timeend'     => $request->timeend,

    ]);

    // Relacionamento com tabela pivot
    $concierge->vehicles()->sync([$request->vehicle_id]);

    $concierge->users()->sync([$request->user_id]);

    

    return redirect()->route('concierge.index')->with('success', 'Registro salvo com sucesso!');

}
    public function show($id)
    {
    }   
    public function edit($id)
    {
        return view("concierge.edit");
    }
    public function update(Request $request, $id)
    {
}
  public function destroy($id)
  { 
    $concierge = Concierge::find($id);
    $concierge->delete();
    return redirect()->back()->with("success","
    Registro salvo com sucesso!");
  }
}