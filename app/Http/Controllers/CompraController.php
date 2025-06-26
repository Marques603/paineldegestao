<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    // Listar todas as compras
    public function index()
    {
        $compras = Compra::latest()->paginate(10);
        return view('compras.index', compact('compras'));
    }

    // Formulário para criar compra + item junto
    public function createComItem()
    {
        $users = User::all();
        $items = Item::all(); 
        return view('compras.create-com-item', compact('users','items'));
    }

    // Armazenar compra + item
    public function storeComItem(Request $request)
{
    // 1. Validação dos dados da compra + usuário
    $validatedCompra = $request->validate([
        'data_necessidade'      => 'required|date',
        'realizar_orcamento'    => 'required|in:sim,nao',
        'valor_previsto'        => 'required|numeric|min:0',
        'quantidade'            => 'required|integer|min:1',
        'justificativa'         => 'required|string',
        'sugestao_fornecedor'   => 'nullable|string|max:255',
        'user_id'               => 'required|exists:users,id',
    ]);

    // 2. Verifica se o item é novo ou existente
    $item = null;

    if ($request->filled('item_id') && $request->item_id !== 'new') {
        // Item existente
        $item = Item::findOrFail($request->item_id);
    } else {
        // 3. Validação dos dados do novo item
        $validatedItem = $request->validate([
            'tipo_material'        => 'required|in:epi_epc,maquinario,material_escritorio,material_informatica,material_limpeza,material_eletrico,material_producao,outro,prestacao_servico',
            'tipo_utilizacao'      => 'required|in:industrializacao,uso_consumo,imobilizado',
            'descricao'            => 'required|string|max:255',
            'descricao_detalhada'  => 'required|string|max:255',
            'marcas'               => 'nullable|string|max:255',
            'link_exemplo'         => 'nullable|url',
            'imagem'               => 'nullable|image|max:2048',
        ]);

        // 4. Criação do novo item
        $item = new Item();
        $item->tipo_material        = $validatedItem['tipo_material'];
        $item->tipo_utilizacao      = $validatedItem['tipo_utilizacao'];
        $item->descricao            = $validatedItem['descricao'];
        $item->descricao_detalhada  = $validatedItem['descricao_detalhada'];
        $item->marcas               = $validatedItem['marcas'] ?? null;
        $item->link_exemplo         = $validatedItem['link_exemplo'] ?? null;

        if ($request->hasFile('imagem')) {
            $item->imagem = $request->file('imagem')->store('compras/imagens', 'public');
        }

        $item->save();
    }

    // 5. Criação da compra
    $compra = new Compra($validatedCompra);
    $compra->save();

    // 6. Associar compra com item
    $compra->items()->attach($item->id, [
        'quantidade' => $validatedCompra['quantidade'],
    ]);

    // 7. Associar compra com usuário responsável (se for relacionamento N:N)
    $compra->users()->attach($validatedCompra['user_id']);

    return redirect()->route('compras.index')->with('success', 'Compra e item criados com sucesso!');
}


    // Formulário para editar compra + item
    public function editComItem(Compra $compra)
{
    $users = User::all();
    $items = Item::all();  // Definindo a variável $items
    
    $itemSelecionado = $compra->items()->first();
    return view('compras.edit-com-item', compact('compra', 'items', 'users', 'itemSelecionado'));
}



    // Atualizar compra + item
    public function updateComItem(Request $request, Compra $compra)
    {
        // Validação da compra
        $validatedCompra = $request->validate([
            'data_necessidade' => 'required|date',
            'realizar_orcamento' => 'required|in:sim,nao',
            'valor_previsto' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:1',
            'justificativa' => 'required|string',
            'sugestao_fornecedor' => 'nullable|string|max:255',
        ]);

        // Validação do item
        $validatedItem = $request->validate([
            'tipo_material' => 'required|in:epi_epc,maquinario,material_escritorio,material_informatica,material_limpeza,material_eletrico,material_producao,outro,prestacao_servico',
            'tipo_utilizacao' => 'required|in:industrializacao,uso_consumo,imobilizado',
            'descricao' => 'required|string|max:255',
            'descricao_detalhada' => 'required|string|max:255',
            'marcas' => 'nullable|string|max:255',
            'link_exemplo' => 'nullable|url',
            'imagem' => 'nullable|image|max:2048',
        ]);

        // Atualiza compra
        $compra->update($validatedCompra);

        // Pega primeiro item associado
        $item = $compra->items()->first();

        if (!$item) {
            // Se não tiver item associado, cria um novo
            $item = new Item();
        }

        // Atualiza dados do item
        $item->tipo_material = $validatedItem['tipo_material'];
        $item->tipo_utilizacao = $validatedItem['tipo_utilizacao'];
        $item->descricao = $validatedItem['descricao'];
        $item->descricao_detalhada = $validatedItem['descricao_detalhada'];
        $item->marcas = $validatedItem['marcas'] ?? null;
        $item->link_exemplo = $validatedItem['link_exemplo'] ?? null;

        if ($request->hasFile('imagem')) {
            $item->imagem = $request->file('imagem')->store('compras/imagens', 'public');
        }

        $item->save();

        // Associar usuários ao item, se houver
        if ($request->has('users')) {
            $item->users()->sync($request->input('users'));
        }

        // Associar item atualizado/criado à compra (se não estiver associado)
        if (!$compra->items()->where('items.id', $item->id)->exists()) {
            $compra->items()->attach($item->id);
        }

        return redirect()->route('compras.index')->with('success', 'Compra e item atualizados com sucesso!');
    }

    // Outros métodos básicos do CompraController se precisar (show, destroy, etc) ...
}
