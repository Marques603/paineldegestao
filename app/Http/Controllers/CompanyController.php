<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Menu;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {

        if (!Gate::allows('view', Menu::find(2))) {
            return redirect()->route('dashboard')->with('status', 'Este menu não está liberado para o seu perfil.');

        }
        
        

    $companies = Company::with('users')->paginate(10);
    return view('company.index', compact('companies'));
    }


    public function create()
    {
        $users = User::all();
        return view('company.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'corporate_name' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:company,cnpj',
            'status' => 'required|boolean',
            'users' => 'array|nullable',
        ]);

        $company = Company::create($validated);
        if ($request->has('users')) {
            $company->users()->sync($request->users);
        }

        return redirect()->route('company.index')->with('success', 'Empresa criada com sucesso.');
    }

    public function show(Company $company)
    {
        $company->load('users');
        return view('company.show', compact('company'));
    }

    public function edit(Company $company)
    {
        $users = User::all();
        $company->load('users');
        return view('company.edit', compact('company', 'users'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'corporate_name' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:company,cnpj,' . $company->id,
            'status' => 'required|boolean',
            'users' => 'array|nullable',
        ]);

        $company->update($validated);
        $company->users()->sync($request->users ?? []);

        return redirect()->route('company.index')->with('success', 'Empresa atualizada com sucesso.');
    }

    public function destroy(Company $company)
    {
        $company->users()->detach();
        $company->delete();

        return redirect()->route('company.index')->with('success', 'Empresa excluída com sucesso.');
    }
}
