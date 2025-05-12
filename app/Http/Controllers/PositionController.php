<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $positions = Position::with('users')->paginate(10);
        return view('position.index', compact('positions'));
    }

    public function create()
    {
        $users = User::all();
        return view('position.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $position = Position::create($request->only(['name', 'status']));

        // Relacionar usuários (se houver)
        if ($request->has('users')) {
            $position->users()->sync($request->users);
        }

        return redirect()->route('position.index')->with('success', 'Cargo criado com sucesso!');
    }

    public function edit(Position $position)
    {
        $users = User::all();
        $position->load('users');
        return view('position.create', compact('position', 'users'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $position->update($request->only(['name', 'status']));

        // Atualizar relacionamento com usuários
        $position->users()->sync($request->users ?? []);

        return redirect()->route('position.index')->with('success', 'Cargo atualizado com sucesso!');
    }

    public function destroy(Position $position)
    {
        $position->delete();

        return redirect()->route('position.index')->with('success', 'Cargo excluído com sucesso!');
    }
}
