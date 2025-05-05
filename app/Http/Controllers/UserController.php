<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sector;
use App\Models\Company;
use App\Models\Menu;
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
        $sector = Sector::all();
        return view('users.create', compact('sector'));
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

        $user->load('menus'); 
        
        $company = Company::where('status', 1)->get();
        $sector = Sector::where('status', 1)->get();
        $menus = Menu::all();  // Carregando menus
        return view('users.edit', compact('user', 'sector', 'company', 'menus'));
    }

    public function update(Request $request, User $user)
    {
        $input = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|boolean',
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

    public function updatesector(Request $request, User $user)
    {
        $validated = $request->validate([
            'sector' => 'nullable|array',
            'sector.*' => 'exists:sector,id',
        ]);

        $user->sector()->sync($validated['sector'] ?? []);

        return redirect()->route('users.index')
                         ->with('status', 'Setores atualizados com sucesso.');
    }

    public function updatecompany(Request $request, User $user)
    {
        $request->validate([
            'company' => 'array',
            'company.*' => 'exists:company,id',
        ]);

        $user->company()->sync($request->company ?? []);

        return redirect()->route('users.index')
                         ->with('status', 'Empresas atualizadas com sucesso!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $user = User::findOrFail($id);
        $user->status = (int) $request->status;
        $user->save();

        return redirect()->route('users.index')->with('status', 'Status do usuário atualizado com sucesso!');
    }

    public function updateProfile(Request $request, User $user)
    {
        $input = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->filled('password')) {
            $input['password'] = bcrypt($input['password']);
        } else {
            unset($input['password']);
        }

        if ($request->hasFile('avatar')) {
            $input['avatar'] = $request->file('avatar')->store('images/profiles', 'public');
        }

        $user->update($input);

        return redirect()->route('users.index')->with('status', 'Usuário atualizado com sucesso.');
        }

        public function updateMenus(Request $request, User $user)
        {
        // Verifica se o campo menus existe e é um array de IDs de menus válidos
         $validated = $request->validate([
             'menus' => 'nullable|array',
             'menus.*' => 'exists:menus,id', // Garante que os IDs dos menus sejam válidos
         ]);

         // Sincroniza os menus do usuário com os menus passados no request
         $user->menus()->sync($validated['menus'] ?? []);

        return redirect()->route('users.edit', $user->id)->with('success', 'Menus atualizados com sucesso.');
}

}
