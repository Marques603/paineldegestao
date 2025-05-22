<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Gate;


class SectorController extends Controller
{
    public function index(Request $request)
{
    if (!Gate::allows('view', Menu::find(1))) {
        return redirect()->route('dashboard')->with('status', 'Este menu não está liberado para o seu perfil.');
    }

    $query = Sector::with(['users', 'responsibleUsers', 'costCenters']);

    // Filtro de busca
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('acronym', 'like', "%{$search}%");
        });
    }

    // Filtro por status
    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    // Ordenação alfabética por nome
    $sectors = $query->orderBy('name', 'asc')->paginate(10);

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
        'acronym' => 'nullable|string',
        // Remover 'status' da validação porque será sempre 0 ao criar
        // 'users' => 'array|nullable',
        // 'users.*' => 'exists:users,id',
        // 'responsible_users' => 'array|nullable',
        // 'responsible_users.*' => 'exists:users,id',
    ]);

    // Força status como 0 (inativo) sempre que criar um setor
    $validated['status'] = 0;

    $sector = Sector::create($validated);
    $sector->users()->sync($request->users ?? []);
    $sector->responsibleUsers()->sync($request->responsible_users ?? []);

    return redirect()->route('sector.index')->with('success', 'Setor criado com sucesso.');
}


    public function edit(Sector $sector)
    {
        $users = User::all();
        $sector->load(['users', 'responsibleUsers']);
        return view('sector.edit', compact('sector', 'users'));
    }

    public function update(Request $request, Sector $sector)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'nullable|string',
            'status' => 'required|boolean',
            'users' => 'array|nullable',
            'users.*' => 'exists:users,id',
            'responsible_users' => 'array|nullable',
            'responsible_users.*' => 'exists:users,id',
        ]);

        $sector->update($validated);
        $sector->users()->sync($request->users ?? []);
        $sector->responsibleUsers()->sync($request->responsible_users ?? []);

        return redirect()->route('sector.index')->with('success', 'Setor atualizado com sucesso.');
    }

    public function destroy(Sector $sector)
    {
        $sector->users()->detach();
        $sector->responsibleUsers()->detach();
        $sector->delete();

        return redirect()->route('sector.index')->with('success', 'Setor excluído com sucesso.');
    }
    public function updateDetails(Request $request, Sector $sector)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'acronym' => 'nullable|string',
    ]);

    $sector->update($validated);

    return redirect()->back()->with('success', 'Detalhes do setor atualizados!');
}

public function updateStatus(Request $request, Sector $sector)
{
    $validated = $request->validate([
        'status' => 'nullable|boolean',
    ]);

    // Checkbox envia valor só se marcado, então:
    $sector->status = $request->has('status') ? 1 : 0;
    $sector->save();

    return redirect()->back()->with('success', 'Status atualizado!');
}

public function updateUsers(Request $request, Sector $sector)
{
    $validated = $request->validate([
        'responsible_users' => 'nullable|array',
        'responsible_users.*' => 'exists:users,id',
        'users' => 'nullable|array',
        'users.*' => 'exists:users,id',
    ]);

    // Sincroniza relacionamentos (ou desanexa se vazio)
    $sector->responsibleUsers()->sync($validated['responsible_users'] ?? []);
    $sector->users()->sync($validated['users'] ?? []);

    return redirect()->back()->with('success', 'Usuários vinculados atualizados!');
}
public function updateResponsibles(Request $request, Sector $sector)
{
    $validated = $request->validate([
        'responsible_users' => 'array|nullable',
        'responsible_users.*' => 'exists:users,id',
    ]);

    $sector->responsibleUsers()->sync($validated['responsible_users'] ?? []);

    return redirect()->back()->with('success', 'Responsáveis atualizados com sucesso.');
}


}
