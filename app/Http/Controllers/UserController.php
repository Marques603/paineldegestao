<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        return view('users.create');
    }

    public function store(Request $request)
{
    $input = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Upload da imagem, se tiver
    if ($request->hasFile('avatar')) {
        $avatarPath = $request->file('avatar')->store('images/profiles', 'public');
        $input['avatar'] = $avatarPath;
    }

    // Criptografar a senha 
    $input['password'] = bcrypt($input['password']);

    User::create($input);

    return redirect()->route('users.index')->with('status', 'Usuário adicionado com sucesso.');
}


    public function edit(User $user)
    {
        
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        

        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'exclude_if:password,null|min:8',
        ]);

        $user->update($input);

        return redirect()->route('users.index')->with('status', 'Usuario atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        

        $user->delete();
        return redirect()->route('users.index')->with('status', 'Usuario removido com sucesso.');
    }
}
