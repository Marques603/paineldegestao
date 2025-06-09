<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Item;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    // Listar todas as compras
    public function index()
    {
        $compras = Compra::latest()->paginate(10);
        return view('compras.index', compact('compras'));
    }

    // Mostrar formulário para criar uma nova compra
    public function create()
    {
        return view('compras.create');
    }

    // Armazenar nova compra no banco de dados
    public function store(Request $request)
    {
        $validatedCompra = $request->validate([
            'data_necessidade' => 'required|date',
            'realizar_orcamento' => 'required|in:sim,nao',
            'valor_previsto' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:1',
            'justificativa' => 'required|string',
            'sugestao_fornecedor' => 'nullable|string|max:255',
        ]);

        Compra::create($validatedCompra);
       
       
        // Associar itens à compra, se houver
        if ($request->has('item')) {
            $item = Item::find($request->input('item'));
            $compra = Compra::latest()->first();
            $compra->items()->sync($item);
        }
        // Redirecionar com mensagem de sucesso 
        return redirect()->route('compras.index')->with('success', 'Compra cadastrada com sucesso!');
    }

    // Mostrar formulário para editar uma compra
    public function edit(Compra $compra)
    {
        return view('compras.edit', compact('compra'));
    }

    // Atualizar uma compra existente
    public function update(Request $request, Compra $compra)
    {
        $validated = $request->validate([
            'data_necessidade' => 'required|date',
            'realizar_orcamento' => 'required|in:sim,nao',
            'valor_previsto' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:1',
            'justificativa' => 'required|string',
            'sugestao_fornecedor' => 'nullable|string|max:255',
        ]);

        $compra->update($validated);
        return redirect()->route('compras.index')->with('success', 'Compra atualizada com sucesso!');
    }

    // Excluir (soft delete) uma compra
    public function destroy(Compra $compra)
    {
        $compra->delete();

        return redirect()->route('compras.index')->with('success', 'Compra excluída com sucesso!');
    }

// Exibir detalhes de uma compra específica
    public function show(Compra $compra)
    {
        return view('compras.show', compact('compra'));
    }
    public function delete(Compra $compra)
    {
        $compra->delete();
        return redirect()->route('compras.index')->with('success', 'Compra excluída com sucesso!');
    }
}