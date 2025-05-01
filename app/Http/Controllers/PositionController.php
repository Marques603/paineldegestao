<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $query = Position::with(['user', 'sector']);
    
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        $position = $query->paginate(10); // Agora suporta firstItem(), lastItem(), links()
    
        return view('position.index', compact('position'));
    }
    

    public function create()
    {
        $sectors = Sector::all();
        $users = User::all();
        return view('position.create', compact('sectors', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sector_id' => 'required|exists:sector,id',
            'status' => 'required|in:0,1,3,4',
        ]);

        Position::create($request->all());

        return redirect()->route('position.index')->with('success', 'Cargo criado com sucesso!');
    }

    public function edit(Position $position)
    {
        $sectors = Sector::all();
        $users = User::all();
        return view('position.edit', compact('position', 'sectors', 'users'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sector_id' => 'required|exists:sector,id',
            'status' => 'required|in:0,1,3,4',
        ]);

        $position->update($request->all());

        return redirect()->route('position.index')->with('success', 'Cargo atualizado com sucesso!');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('position.index')->with('success', 'Cargo excluído com sucesso!');
    }
}
