<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Compra;

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
        $items = Item::all();
        return view('item.create', compact('users', 'items' ));
    }

    public function store(Request $request)
{
    // Validação dos dados da compra
    $validatedCompra = $request->validate([
        'data_necessidade' => 'required|date',
        'realizar_orcamento' => 'required|in:sim,nao',
        'valor_previsto' => 'required|numeric|min:0',
        'quantidade' => 'required|integer|min:1',
        'justificativa' => 'required|string',
        'sugestao_fornecedor' => 'nullable|string|max:255',
    ]);

    // Validação dos dados do item
    $validatedItem = $request->validate([
        'tipo_material' => 'required|in:epi_epc,maquinario,material_escritorio,material_informatica,material_limpeza,material_eletrico,material_producao,outro,prestacao_servico',
        'tipo_utilizacao' => 'required|in:industrializacao,uso_consumo,imobilizado',
        'descricao' => 'required|string|max:255',
        'descricao_detalhada' => 'required|string|max:255',
        'marcas' => 'nullable|string|max:255',
        'link_exemplo' => 'nullable|url',
        'imagem' => 'nullable|image|max:2048',
    ]);

    // Criar o item
    $item = Item::create([
        'tipo_material' => $validatedItem['tipo_material'],
        'tipo_utilizacao' => $validatedItem['tipo_utilizacao'],
        'descricao' => $validatedItem['descricao'],
        'descricao_detalhada' => $validatedItem['descricao_detalhada'],
        'marcas' => $validatedItem['marcas'] ?? null,
        'link_exemplo' => $validatedItem['link_exemplo'] ?? null,
        'imagem' => $request->hasFile('imagem')
            ? $request->file('imagem')->store('compras/imagens', 'public')
            : null,
    ]);

    // Associar usuários ao item, se enviados
    if ($request->has('users')) {
        $item->users()->sync($request->users);
    }

    // Criar a compra
    $compra = Compra::create($validatedCompra);

    // Associar o item criado à compra
    $compra->items()->attach($item->id);

    return redirect()->route('compras.index')->with('success', 'Compra e item criados com sucesso!');
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
