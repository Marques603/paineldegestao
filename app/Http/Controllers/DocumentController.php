<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Macro;
use App\Models\User;
use App\Models\Sector;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    public function index()
    {
        $documents = Document::with(['macro', 'users', 'sectors', 'companies'])->get();
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create', [
            'macros' => Macro::all(),
            'users' => User::all(),
            'sectors' => Sector::all(),
            'companies' => Company::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'revision'    => 'nullable|string|max:50',
            'macro_id'    => 'nullable|exists:macros,id',
            'file'        => 'required|file|max:10240', // 10MB
            'status'      => 'required|in:0,1',
            'users'       => 'array',
            'users.*'     => 'exists:users,id',
            'sectors'     => 'array',
            'sectors.*'   => 'exists:sectors,id',
            'companies'   => 'array',
            'companies.*' => 'exists:companies,id',
        ]);

        // Salvar o arquivo
        $file = $request->file('file');
        $path = $file->store('documents', 'public');
        $type = $file->getClientOriginalExtension();

        // Criar o documento
        $document = Document::create([
            'name'           => $request->name,
            'description'    => $request->description,
            'revision'       => $request->revision,
            'macro_id'       => $request->macro_id,
            'status'         => $request->status,
            'user_upload_id' => Auth::id(),
            'file_path'      => $path,
            'file_type'      => $type,
        ]);

        // Relacionamentos N:N
        $document->users()->sync($request->input('users', []));
        $document->sectors()->sync($request->input('sectors', []));
        $document->companies()->sync($request->input('companies', []));

        return redirect()->route('documents.index')->with('success', 'Documento criado com sucesso!');
    }
}
