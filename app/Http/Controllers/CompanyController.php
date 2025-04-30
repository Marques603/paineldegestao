<?php


namespace App\Http\Controllers;
use App\Models\Company;


use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // Exibe todas as empresas
    public function index()
{
    // Usando paginate para paginar os resultados, por exemplo, 10 empresas por página
    $companies = Company::paginate(10);
    return view('company.index', compact('companies'));
}


    // Exibe o formulário de criação
    public function create()
    {
        return view('company.create');
    }

    // Armazena uma nova empresa
    public function store(Request $request)
{
    // Validando os dados recebidos
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'cnpj' => 'required|string|max:18|unique:company,cnpj',
        'responsavel' => 'nullable|string|max:255',
        'status' => 'required|boolean',
    ]);

    // Definindo o status como inativo (false) ao criar uma nova empresa
    $request->merge(['status' => false]);

    // Criando a empresa com os dados validados
    Company::create($request->all());

    // Redirecionando com uma mensagem de sucesso
    return redirect()->route('company.index')->with('success', 'Empresa cadastrada com sucesso!');
}


    // Exibe o formulário de edição
    public function edit(Company $company)
    {
        return view('company.edit', compact('company'));
    }

    // Atualiza uma empresa existente
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cnpj' => 'required|string|max:18|unique:company,cnpj,' . $company->id,
            'responsavel' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        $company->update($request->all());
        return redirect()->route('company.index')->with('success', 'Empresa Alterada com sucesso!');
    }

    // Exclui uma empresa
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Empresa Deletada com sucesso!');
    }
}