<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Macro;
use App\Models\Sector;
use App\Models\DocumentApproval;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    // Listagem de documentos com busca
    public function index(Request $request)
    {
        $documents = Document::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('code', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('documents.index', compact('documents'));
    }

    // Formulário de criação
    public function create()
    {
        $macros = Macro::all();
        $sectors = Sector::all();

        return view('documents.create', compact('macros', 'sectors'));
    }

    // Salvar novo documento
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'file' => 'required|file',
            'macros' => 'required|array',
            'sectors' => 'required|array',
        ]);

        $filePath = $request->file('file')->store('documents');

        $document = Document::create([
            'code' => $request->code,
            'description' => $request->description,
            'user_upload' => auth()->id(),
            'revision' => $request->revision,
            'file_path' => $filePath,
            'file_type' => $request->file('file')->getClientOriginalExtension(),
            'status' => 1,
        ]);

        $document->macros()->sync($request->macros);
        $document->sectors()->sync($request->sectors);

        return redirect()->route('documents.index')->with('success', 'Documento criado com sucesso.');
    }

    // Formulário de edição
    public function edit(Document $document)
    {
        $macros = Macro::all();
        $sectors = Sector::all();

        return view('documents.edit', compact('document', 'macros', 'sectors'));
    }

    // Atualizar documento existente
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'code' => 'required|string',
            'file' => 'nullable|file',
            'macros' => 'required|array',
            'sectors' => 'required|array',
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
            $document->file_path = $filePath;
            $document->file_type = $request->file('file')->getClientOriginalExtension();
        }

        $document->code = $request->code;
        $document->description = $request->description;
        $document->revision = $request->revision;
        $document->save();

        $document->macros()->sync($request->macros);
        $document->sectors()->sync($request->sectors);

        return redirect()->route('document.index')->with('success', 'Documento atualizado com sucesso.');
    }

    // Aprovar documento
    public function approve($documentId)
    {
        $document = Document::findOrFail($documentId);

        DocumentApproval::create([
            'document_id' => $document->id,
            'user_id' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('document.index')->with('success', 'Documento aprovado com sucesso.');
    }
}
