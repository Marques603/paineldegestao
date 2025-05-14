<?php

namespace App\Http\Controllers;

use App\Models\Macro;
use App\Models\User;
use Illuminate\Http\Request;

class MacroController extends Controller
{
    public function index(Request $request)
    {

        
        $macros = Macro::withTrashed()
            ->with('responsibleUsers')
            ->paginate(10);

        return view('macro.index', compact('macros'));
    }

    public function create()
    {
        $users = User::all();
        return view('macro.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'responsible_users' => 'array|nullable',
            'responsible_users.*' => 'exists:users,id',
        ]);

        $macro = Macro::create($request->only(['name', 'description', 'status']));

        if ($request->has('responsible_users')) {
            $macro->responsibleUsers()->sync($request->responsible_users);
        }

        return redirect()->route('macro.index')->with('success', 'Macro criada com sucesso.');
    }

    public function edit(Macro $macro)
    {
        $users = User::all();
        $macro->load('responsibleUsers');

        return view('macro.edit', compact('macro', 'users'));
    }

    public function update(Request $request, Macro $macro)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'responsible_users' => 'array|nullable',
            'responsible_users.*' => 'exists:users,id',
        ]);

        $macro->update($request->only(['name', 'description', 'status']));

        if ($request->has('responsible_users')) {
            $macro->responsibleUsers()->sync($request->responsible_users);
        }

        return redirect()->route('macro.index')->with('success', 'Macro atualizada com sucesso.');
    }

    public function destroy(Macro $macro)
    {
        $macro->delete();
        return redirect()->route('macro.index')->with('success', 'Macro removida (soft delete).');
    }

    public function restore($id)
    {
        $macro = Macro::withTrashed()->findOrFail($id);
        $macro->restore();
        return redirect()->route('macro.index')->with('success', 'Macro restaurada.');
    }
}
