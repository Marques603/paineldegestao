<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\User;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index()
    {

        $sectors = Sector::with('users','responsibleUsers')->paginate(10);
     
        return view('sector.index', compact('sectors'));
    }

    public function create()
    {
        $users = User::all();
        return view('sector.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_center_id' => 'nullable|exists:cost_center,id',
            'status' => 'required|in:0,1',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
            'responsible_users' => 'nullable|array',
            'responsible_users.*' => 'exists:users,id',
        ]);

        $sector = Sector::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'cost_center_id' => $validated['cost_center_id'] ?? null,
            'status' => $validated['status'],
        ]);

        $sector->users()->sync($validated['users'] ?? []);
        $sector->responsibleUsers()->sync($validated['responsible_users'] ?? []);

        return redirect()->route('sector.index')->with('success', 'Setor criado com sucesso!');
    }

    public function edit(Sector $sector)
    {
        $users = User::all();
        $sector->load(['users', 'responsibleUsers']);
        return view('sector.edit', compact('sector', 'users'));
    }

    public function updateDetails(Request $request, Sector $sector)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_center_id' => 'nullable|exists:cost_center,id',
        ]);

        $sector->update($validated);

        return redirect()->back()->with('success', 'Informações do setor atualizadas com sucesso!');
    }

    public function updateStatus(Request $request, Sector $sector)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:1',
        ]);

        $sector->update([
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Status do setor atualizado com sucesso!');
    }

    public function updateUsers(Request $request, Sector $sector)
    {
        $validated = $request->validate([
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $sector->users()->sync($validated['users'] ?? []);

        return redirect()->back()->with('success', 'Usuários vinculados atualizados com sucesso!');
    }

    public function updateResponsibles(Request $request, Sector $sector)
    {
        $validated = $request->validate([
            'responsible_users' => 'nullable|array',
            'responsible_users.*' => 'exists:users,id',
        ]);

        $sector->responsibleUsers()->sync($validated['responsible_users'] ?? []);

        return redirect()->back()->with('success', 'Responsáveis atualizados com sucesso!');
    }

    public function destroy(Sector $sector)
    {
        $sector->delete();
        return redirect()->route('sector.index')->with('success', 'Setor deletado com sucesso!');
    }
}
