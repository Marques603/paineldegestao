<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Macro;
use App\Models\Sector;
use App\Models\DocumentApproval;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Index e outros métodos (create, store, edit) podem ficar iguais
    public function index(Request $request)
{
    if (!Gate::allows('view', Menu::find(2))) {
        return redirect()->route('dashboard')->with('status', 'Este menu não está liberado para o seu perfil.');
    }

    $user = auth()->user();
    $sectorIds = $user->sectors->pluck('id');
    $isQuality = $sectorIds->contains(1); // Verifica se usuário pertence ao setor ID 1

    $documents = Document::query()
        ->when(!$isQuality, function ($query) use ($sectorIds) {
            $query->where('status', 1)
                  ->whereHas('sectors', function ($q) use ($sectorIds) {
                      $q->whereIn('sector_id', $sectorIds);
                  });
        })
        ->when($request->search, function ($query, $search) {
            return $query->where('code', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('documents.index', compact('documents'));
}


    public function create()
    {
        $macros = Macro::all();
        $sectors = Sector::all();
        return view('documents.create', compact('macros', 'sectors'));
    }

    public function store(Request $request)
{
    $request->validate([
        'code' => 'required|string',
        'file' => 'required|file',
        'macros' => 'nullable|array',   // Agora pode ser nulo ou vazio
        'sectors' => 'nullable|array',  // Agora pode ser nulo ou vazio
    ]);

    $userId = auth()->id();

    $filePath = $request->file('file')->store('documents', 'public');

    $document = Document::create([
        'code' => $request->code,
        'description' => $request->description,
        'user_upload' => $userId,
        'revision' => $request->revision,
        'file_path' => $filePath,
        'file_type' => $request->file('file')->getClientOriginalExtension(),
        'status' => 1,
    ]);

    // Se vier vazio ou não vier, sincroniza com array vazio = desvincula tudo
    $document->macros()->sync($request->macros ?? []);
    $document->sectors()->sync($request->sectors ?? []);

    return redirect()->route('documents.index')->with('success', 'Documento criado com sucesso.');
}

    public function edit(Document $document)
    {
        $macros = Macro::all();
        $sectors = Sector::all();

        return view('documents.edit', compact('document', 'macros', 'sectors'));
    }

    // Atualiza apenas o código, descrição e revisão
    public function updateCode(Request $request, Document $document)
    {
        $request->validate([
            'code' => 'required|string',
            'description' => 'nullable|string',
            'revision' => 'nullable|string',
        ]);

        $document->code = $request->code;
        $document->description = $request->description;
        $document->revision = $request->revision;
        $document->save();

        return redirect()->back()->with('success', 'Código do documento atualizado com sucesso.');
    }

    // Atualiza apenas o arquivo
    public function updateFile(Request $request, Document $document)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $filePath = $request->file('file')->store('documents', 'public');
        $document->file_path = $filePath;
        $document->file_type = $request->file('file')->getClientOriginalExtension();
        $document->save();

        return redirect()->back()->with('success', 'Arquivo atualizado com sucesso.');
    }

    // Atualiza as macros vinculadas
    public function updateMacros(Request $request, Document $document)
{
    $request->validate([
        'macros' => 'nullable|array',
    ]);

    $document->macros()->sync($request->macros ?? []);

    return redirect()->back()->with('success', 'Macros vinculadas atualizadas com sucesso.');
}

    // Atualiza os setores vinculados
    public function updateSectors(Request $request, Document $document)
{
    $request->validate([
        'sectors' => 'nullable|array',
    ]);

    $document->sectors()->sync($request->sectors ?? []);

    return redirect()->back()->with('success', 'Setores vinculados atualizados com sucesso.');
}

    // Métodos de aprovação (showApproveForm, approve, updateApprovalStatus) mantém iguais
    public function showApproveForm($documentId)
    {
        $document = Document::with('approvals.user')->findOrFail($documentId);
        return view('documents.approve', compact('document'));
    }

    public function approve($documentId)
    {
        $document = Document::findOrFail($documentId);

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

    public function updateApprovalStatus(Request $request, $documentId)
    {
        $document = Document::findOrFail($documentId);

        $approval = DocumentApproval::where('document_id', $documentId)
                                    ->where('user_id', auth()->id())
                                    ->first();

        if (!$approval) {
            $approval = new DocumentApproval();
            $approval->document_id = $documentId;
            $approval->user_id = auth()->id();
        }

        $approval->status = $request->status ?? 0;
        $approval->approved_at = now();
        $approval->comments = $request->comments ?? null;
        $approval->save();

        return redirect()->route('documents.index')->with('success', 'Status de aprovação atualizado com sucesso.');
    }
    public function updateStatus(Request $request, Document $document)
    {
    $document->status = $request->input('status', 0);
    $document->save();

    return redirect()->back()->with('success', 'Status do documento atualizado com sucesso.');
}

}
