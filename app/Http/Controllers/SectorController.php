<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Menu;
use App\Models\User;
use App\Models\CostCenter; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
 

class SectorController extends Controller
{
    public function index(Request $request)
    {

        if (!Gate::allows('view', Menu::find(2))) {
            return redirect()->route('users.index')->with('status', 'Este menu não está liberado para o seu perfil.');
        }
        

        $sector = Sector::query();
    
        if ($request->has('search')) {
            $sector->where('name', 'like', '%' . $request->input('search') . '%');
        }
    
        // Aplica os relacionamentos e pagina a query final
        $sector = $sector->with(['user', 'costCenter'])->paginate(10);
    
        return view('sector.index', compact('sector'));
    }

    public function create()
    {
        $users = User::all();
        $costCenters = CostCenter::all(); // Passa os centros de custo para a view
        return view('sector.create', compact('users', 'costCenters'));
    }

    public function store(Request $request)
    {
        // Validação para o formulário de criação do setor
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'cost_center_id' => 'nullable|exists:cost_center,id', // Validação para o centro de custo
        ]);

        // Definindo status como inativo (0) por padrão
        $validated['status'] = 0;

        // Criando o setor
        Sector::create($validated);

        return redirect()->route('sector.index')->with('success', 'Setor criado como inativo!');
    }

    public function edit(Sector $sector)
    {
        $users = User::orderBy('name')->get();
        $cost_center = CostCenter::orderBy('name')->get(); // singular

        return view('sector.edit', compact('sector', 'users', 'cost_center'));
    }

    public function update(Request $request, Sector $sector)
    {
        // Validação para o formulário de edição do setor (campo status não obrigatório aqui)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'cost_center_id' => 'nullable|exists:cost_center,id', // Validação para o centro de custo
            // Não validamos o status aqui, pois ele está em um formulário separado
        ]);

        // Atualizando apenas os campos validados
        $sector->update($validated);

        return redirect()->route('sector.index')->with('success', 'Setor atualizado com sucesso!');
    }

    public function destroy(Sector $sector)
    {
        // Excluindo o setor
        $sector->delete();
        return redirect()->route('sector.index')->with('success', 'Setor deletado com sucesso!');
    }

    public function updateStatus(Request $request, Sector $sector)
    {
        // Validação para o formulário de atualização do status
        $validated = $request->validate([
            'status' => 'required|boolean',
        ]);

        $sector->update(['status' => $validated['status']]);

        return redirect()->route('sector.index')->with('success', 'Status do setor atualizado com sucesso!');
    }
}
