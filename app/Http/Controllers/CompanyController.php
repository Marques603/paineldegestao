<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // Exibe todas as empresas
    public function index()
    {
        $companies = Company::paginate(10);
        return view('company.index', compact('companies'));
    }

    // Exibe o formulário de criação
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('company.create', compact('users'));
    }

    // Armazena uma nova empresa
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cnpj' => 'required|string|max:18|unique:company,cnpj',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'required|boolean',
        ]);

        $request->merge(['status' => false]);

        Company::create($request->all());

        return redirect()->route('company.index')->with('success', 'Empresa cadastrada com sucesso!');
    }

    // Exibe o formulário de edição
    public function edit(Company $company)
    {
        $users = User::orderBy('name')->get();
        return view('company.edit', compact('company', 'users'));
    }

    // Atualiza uma empresa existente
    // CompanyController.php
    public function update(Request $request, Company $company)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'cnpj' => 'required|string|max:18|unique:company,cnpj,' . $company->id,
        'user_id' => 'nullable|exists:users,id',
        'status' => 'nullable|boolean', // <<< aqui estava "required"
    ]);

    $company->update($request->all());

    return redirect()->route('company.index')->with('success', 'Empresa alterada com sucesso!');
    }


    // Exclui uma empresa
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Empresa deletada com sucesso!');
    }

    // Atualiza apenas o status
    public function updateStatus(Request $request, Company $company)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
        ]);

        $company->update(['status' => $validated['status']]);

        return redirect()->route('company.index')->with('success', 'Status atualizado com sucesso!');
    }
}
