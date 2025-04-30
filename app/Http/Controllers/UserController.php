<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sector;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();

        $users->when($request->input('search'), function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        });

        $users = $users->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $sectors = Sector::all();
        return view('users.create', compact('sectors'));
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $input['avatar'] = $request->file('avatar')->store('images/profiles', 'public');
        }

        $input['password'] = bcrypt($input['password']);

        User::create($input);

        return redirect()->route('users.index')->with('status', 'Usuário adicionado com sucesso.');
    }

    public function edit(User $user)
    {
        $companies = Company::where('status', 1)->get();
        $sectors = Sector::where('status', 1)->get();
        return view('users.edit', compact('user', 'sectors','companies'));
    }

    public function update(Request $request, User $user)
    {
        $input = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->filled('password')) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        if ($request->hasFile('avatar')) {
            $input['avatar'] = $request->file('avatar')->store('images/profiles', 'public');
        }

        $user->update($input);

        return redirect()->route('users.index')->with('status', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('status', 'Usuário removido com sucesso.');
    }

    public function updateSectors(Request $request, User $user)
{
    $validated = $request->validate([
        'sectors' => 'nullable|array',
        'sectors.*' => 'exists:sectors,id',
    ]);

    $user->sectors()->sync($validated['sectors'] ?? []);

    return redirect()->route('users.index')
                     ->with('status', 'Setores atualizados com sucesso.');

        
    }
    public function updateCompanies(Request $request, User $user)
{
    $request->validate([
        'companies' => 'array',
        'companies.*' => 'exists:companies,id',
    ]);

    $user->companies()->sync($request->companies ?? []);

    return redirect()->route('users.index')
    ->with('status', 'Empresas atualizadas com sucesso!');


}

}
