<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submenu;
use App\Models\Menu; // Certifique-se de importar o modelo Menu

class SubmenuController extends Controller
{
    public function index()
    {
        $submenus = Submenu::orderBy('id', 'asc')->paginate(10);
        return view('menu.submenu.index', compact('submenus'));
    }

    public function create()
    {
        return view('menu.submenu.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados recebidos sem a validação de 'rota'
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'ativo' => 'nullable|boolean', // Ativo pode ser nulo
        ]);

        // Criação do submenu
        Submenu::create([
            'name' => $data['name'],
            'descricao' => $data['descricao'],
            'rota' => $request->input('rota', ''), // Usando o valor de 'rota', ou vazio caso não enviado
            'ativo' => $request->has('ativo') ? 1 : 0, // Se "ativo" não for informado, usa "false" (0)
        ]);

        // Redireciona com mensagem de sucesso
        return redirect()->route('submenus.index')->with('success', 'Submenu criado com sucesso!');
    }

    public function edit(Submenu $submenu)
    {
        $menus = Menu::all(); // Carregue todos os menus
        return view('menu.submenu.edit', compact('submenu', 'menus'));
    }

    public function update(Request $request, Submenu $submenu)
    {
        $formulario = $request->input('formulario');
    
        switch ($formulario) {
            case 'editar_informacoes':
                $data = $request->validate([
                    'name' => 'required|string|max:255',
                    'descricao' => 'nullable|string|max:255',
                ]);
    
                $submenu->update([
                    'name' => $data['name'],
                    'descricao' => $data['descricao'],
                    'rota' => $request->input('rota', $submenu->rota),
                ]);
                break;
    
            case 'ativar_submenu':
                $submenu->update([
                    'ativo' => $request->has('ativo') ? 1 : 0,
                ]);
                break;
    
            case 'ativar_menus':
                $menus = $request->input('menus', []);
                $submenu->menus()->sync($menus);
                break;
        }
    
        return redirect()->route('submenus.index')->with('success', 'Submenu atualizado com sucesso!');
    }
    

    public function destroy(Submenu $submenu)
    {
        // Desassociar os menus do submenu
        $submenu->menus()->detach(); // Ou use sync([]) para desassociar todos os menus

        // Excluir o submenu
        $submenu->delete();

        // Redireciona com mensagem de sucesso
        return redirect()->route('submenus.index')->with('success', 'Submenu removido com sucesso!');
    }
}
