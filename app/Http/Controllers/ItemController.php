<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $itens = Item::orderBy("created_at","desc")->paginate(10);
        return view('item.index', compact('itens'));
    }

    public function create()
    {
        $users = User::all();
        return view('item.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_material' => 'required|in:epi_epc,maquinario,material_escritorio,material_informatica,material_limpeza,material_eletrico,material_producao,outro,prestacao_servico',
            'tipo_utilizacao' => 'required|in:industrializacao,uso_consumo,imobilizado',
            'descricao' => 'required|string|max:255',
            'descricao_detalhada' => 'required|string|max:255',
            'marcas' => 'nullable|string|max:255',
            'link_exemplo' => 'nullable|url',
            'imagem' => 'nullable|image|max:2048',
        ]);

        $item = Item::create([
            'tipo_material' => $request->tipo_material,
            'tipo_utilizacao' => $request->tipo_utilizacao,
            'descricao' => $request->descricao,
            'descricao_detalhada' => $request->descricao_detalhada,
            'marcas' => $request->marcas,
            'link_exemplo' => $request->link_exemplo,
            'imagem' => $request->hasFile('imagem') 
                ? $request->file('imagem')->store('compras/imagens', 'public') 
                : null,
        ]);

        // Relacionar usuários (se houver)
        if ($request->has('users')) {
            $item->users()->sync($request->users);
        }

        return redirect()->route('item.index')->with('success', 'Cargo criado com sucesso!');
    }

    public function edit(Item $item)
    {
        return view('item.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'tipo_material' => 'required|in:epi_epc,maquinario,material_escritorio,material_informatica,material_limpeza,material_eletrico,material_producao,outro,prestacao_servico',
            'tipo_utilizacao' => 'required|in:industrializacao,uso_consumo,imobilizado',
            'descricao' => 'required|string|max:255',
            'descricao_detalhada' => 'required|string|max:255',
            'marcas' => 'nullable|string|max:255',
            'link_exemplo' => 'nullable|url',
            'imagem' => 'nullable|image|max:2048',
        ]);

        $item->update($request->only([
            'tipo_material',
            'tipo_utilizacao',
            'descricao',
            'descricao_detalhada',
            'marcas'
        ]));


        return redirect()->route('item.index')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('item.index')->with('success', 'Item excluído com sucesso!');
    }
    public function show(Item $item)
    {
          $item->load('users'); // se houver relacionamento
        return view('item.show', compact('item'));
    }
}
