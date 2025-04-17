<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submenu;
use App\Models\Menu;

class SubmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pega todos os submenus
        $submenus = Submenu::with('menus')->get();  // Relacionando menus aos submenus
        return view('submenus.index', compact('submenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pega todos os menus para relacionar com o submenu
        $menus = Menu::all();
        return view('submenus.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida os dados recebidos do formulário
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'rota' => 'required|string',
            'ativo' => 'boolean',
            'menus' => 'required|array', // Relacionamento com menus
        ]);

        // Cria o submenu
        $submenu = Submenu::create([
            'nome' => $data['nome'],
            'rota' => $data['rota'],
            'ativo' => $data['ativo'] ?? true, // Definir se está ativo
        ]);

        // Relaciona o submenu aos menus
        $submenu->menus()->attach($data['menus']);

        // Redireciona para a página de listagem de submenus
        return redirect()->route('submenus.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submenu $submenu)
    {
        // Pega todos os menus para editar a relação
        $menus = Menu::all();
        return view('submenus.edit', compact('submenu', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submenu $submenu)
    {
        // Valida os dados recebidos do formulário
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'rota' => 'required|string',
            'ativo' => 'boolean',
            'menus' => 'required|array', // Relacionamento com menus
        ]);

        // Atualiza o submenu
        $submenu->update([
            'nome' => $data['nome'],
            'rota' => $data['rota'],
            'ativo' => $data['ativo'] ?? true, // Definir se está ativo
        ]);

        // Atualiza a relação com os menus
        $submenu->menus()->sync($data['menus']); // Substitui a relação de menus

        // Redireciona para a página de listagem de submenus
        return redirect()->route('submenus.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submenu $submenu)
    {
        // Deleta o submenu e a relação com os menus
        $submenu->menus()->detach(); // Remove a relação
        $submenu->delete();

        // Redireciona de volta para a página de listagem
        return back();
    }
}
