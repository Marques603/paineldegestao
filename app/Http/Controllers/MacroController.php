<?php

// app/Http/Controllers/MacroController.php
namespace App\Http\Controllers;

use App\Models\Macro;
use Illuminate\Http\Request;

class MacroController extends Controller
{
    // Exibir todas as macros
    public function index(Request $request)
{
    // Aqui você usa paginate ao invés de all()
    $macros = Macro::query()
        ->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })
        ->paginate(10); // Isso paginará 10 resultados por página

    return view('macro.index', compact('macros'));
}

    // Exibir o formulário de criação
    public function create()
    {
        return view('macro.create');
    }

    // Armazenar uma nova macro
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'procedure' => 'nullable|string',
            'responsible' => 'nullable|string|max:255',
        ]);

        Macro::create($request->all());

        return redirect()->route('macro.index')->with('success', 'Macro criada com sucesso!');
    }

    // Exibir o formulário de edição
    public function edit(Macro $macro)
    {
        return view('macro.edit', compact('macro'));
    }

    // Atualizar uma macro existente
    public function update(Request $request, Macro $macro)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'procedure' => 'nullable|string',
            'responsible' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $macro->update($request->all());

        return redirect()->route('macro.index')->with('success', 'Macro atualizada com sucesso!');
    }

    // Excluir uma macro
    public function destroy(Macro $macro)
    {
        $macro->delete();
        return redirect()->route('macro.index')->with('success', 'Macro excluída com sucesso!');
    }
    public function updateStatus(Request $request, Macro $macro)
    {
    $validated = $request->validate([
        'status' => 'required|boolean',
    ]);

    $macro->update(['status' => $validated['status']]);

    return redirect()->route('macro.index', $macro->id)->with('success', 'Status atualizado com sucesso!');
    }

}
