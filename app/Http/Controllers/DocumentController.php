<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Macro;
use App\Models\Sector;
use App\Models\DocumentApproval;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    // Construtor para garantir que o usuário esteja autenticado
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Listagem de documentos com busca
    public function index(Request $request)
    {
    $user = auth()->user();

    $sectorIds = $user->sectors->pluck('id');

    $documents = Document::where('status', 1)
        ->whereHas('sectors', function ($query) use ($sectorIds) {
            $query->whereIn('sector_id', $sectorIds);
        })
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

        // Verifica se o usuário está autenticado e pega o ID do usuário logado
        $userId = auth()->id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Você precisa estar autenticado para fazer o upload de documentos.');
        }

        // Faz o upload do arquivo
        $filePath = $request->file('file')->store('documents', 'public');

        // Criação do documento
        $document = Document::create([
            'code' => $request->code,
            'description' => $request->description,
            'user_upload' => $userId, // Atribui o ID do usuário autenticado
            'revision' => $request->revision,
            'file_path' => $filePath,
            'file_type' => $request->file('file')->getClientOriginalExtension(),
            'status' => 1,
        ]);

        // Sincroniza as macros e setores com o documento
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

        // Se o arquivo foi enviado, faz o upload
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
            $document->file_path = $filePath;
            $document->file_type = $request->file('file')->getClientOriginalExtension();
        }

        // Atualiza os outros campos do documento
        $document->code = $request->code;
        $document->description = $request->description;
        $document->revision = $request->revision;
        $document->save();

        // Sincroniza as macros e setores com o documento
        $document->macros()->sync($request->macros);
        $document->sectors()->sync($request->sectors);

        return redirect()->route('documents.index')->with('success', 'Documento atualizado com sucesso.');
    }

    // Formulário para aprovar documento
    public function showApproveForm($documentId)
    {
        $document = Document::with('approvals.user')->findOrFail($documentId);

        return view('documents.approve', compact('document'));
    }

    // Aprovar documento
    public function approve($documentId)
    {
        $document = Document::findOrFail($documentId);

        // Impede que o mesmo usuário aprove duas vezes
        if ($document->approvals()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('documents.index')->with('info', 'Você já aprovou este documento.');
        }

        DocumentApproval::create([
            'document_id' => $document->id,
            'user_id' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Documento aprovado com sucesso.');
    }

    // Aprovar ou reprovar o documento
    public function updateApprovalStatus(Request $request, $documentId)
    {
        // Buscar o documento pelo ID
        $document = Document::findOrFail($documentId);

        // Verifica se a aprovação já existe para o usuário
        $approval = DocumentApproval::where('document_id', $documentId)
                                    ->where('user_id', auth()->id())
                                    ->first();

        // Se a aprovação não existir, cria uma nova
        if (!$approval) {
            $approval = new DocumentApproval();
            $approval->document_id = $documentId;
            $approval->user_id = auth()->id();
        }

        // Atualiza o status de aprovação
        $approval->status = $request->status ?? 0;  // Garantir que status tenha um valor (se não passar no request, assume 0)
        $approval->approved_at = now();

        // Se quiser, pode adicionar comentários ou outros campos de aprovação
        $approval->comments = $request->comments; // Se houver comentários

        // Salva a aprovação
        $approval->save();

        return redirect()->route('documents.approve', $documentId)
                         ->with('success', 'Status de aprovação atualizado.');
    }
}
