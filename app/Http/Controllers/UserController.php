<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sector;
use App\Models\Company;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {

        Gate::authorize('view', Menu::find(1)); 
        
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
        $roles = Role::all();  // Carregando todos os papéis
        return view('users.create', compact('sector', 'roles'));
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'roles' => 'nullable|array',  // Validando os papéis
        ]);

        if ($request->hasFile('avatar')) {
            $input['avatar'] = $request->file('avatar')->store('images/profiles', 'public');
        }

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        // Sincronizando os papéis
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        return redirect()->route('users.index')->with('status', 'Usuário adicionado com sucesso.');
    }

    public function edit(User $user)
    {

        Gate::authorize('edit', User::class); // Só admins
        

        $user->load('menus', 'roles'); // Carregando menus e papéis

        $company = Company::where('status', 1)->get();
        $sector = Sector::where('status', 1)->get();
        $menus = Menu::all();  // Carregando menus
        $roles = Role::all();  // Carregando papéis

        return view('users.edit', compact('user', 'sector', 'company', 'menus', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        
        $input = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|boolean',
            'roles' => 'nullable|array',  // Validando os papéis
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

        // Sincronizando os papéis
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

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
        $user = User::findOrFail($id);

        $request->validate([
            'status' => 'required|in:0,1',
        ]);

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
        
        $validated = $request->validate([
            'menus' => 'nullable|array',
            'menus.*' => 'exists:menus,id',
        ]);

        $user->menus()->sync($validated['menus'] ?? []);

        return redirect()->route('users.index')->with('status', 'Menus atualizados com sucesso.');
    }

    public function updateRoles(Request $request, User $user)
    {
        
        $input = $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',  // Validando os IDs de papéis
        ]);

        // Sincronizando os papéis
        $user->roles()->sync($input['roles'] ?? []);

        return redirect()->route('users.index')->with('status', 'Funções atualizadas com sucesso.');
    }
}
