<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Macro;
use App\Models\Sector;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Document::with(['macro', 'user', 'sector', 'company']);
    
        if ($request->filled('search')) {
            $search = $request->input('search');
    
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('file_path', 'like', "%{$search}%");
                  // adicione aqui outros campos se quiser (ex: description)
            });
        }
    
        $documents = $query->paginate(8)->appends($request->only('search'));
    
        return view('documents.index', compact('documents'));
    }
    

    public function create()
    {
        return view('documents.create', [
            'macro' => Macro::all(),
            'sector' => Sector::all(),
            'company' => Company::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'macro_id' => 'required|exists:macro,id',
            'sector' => 'nullable|array',
            'sector.*' => 'exists:sector,id',
            'company' => 'nullable|array',
            'company.*' => 'exists:company,id',
        ]);

        DB::beginTransaction();

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $fileName, 'public');

            $document = Document::create([
                'name' => $validatedData['name'],
                'file_path' => $path,
                'macro_id' => $validatedData['macro_id'],
                'revision' => 1,
                'user_id' => auth()->id(),
                'locked' => false
            ]);

            $document->sector()->attach($validatedData['sector'] ?? []);
            $document->company()->attach($validatedData['company'] ?? []);

            DB::commit();
            return redirect()->route('documents.index')->with('success', 'Documento enviado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao salvar documento: ' . $e->getMessage());
            Storage::disk('public')->delete($path ?? '');
            return redirect()->route('documents.create')->with('error', 'Erro ao salvar documento.');
        }
    }

    public function edit(Document $document)
    {
        return view('documents.edit', [
            'document' => $document,
            'macro' => Macro::all(),
            'sector' => Sector::all(),
            'company' => Company::all()
        ]);
    }

    public function update(Request $request, Document $document)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'macro_id' => 'required|exists:macro,id',
            'sector' => 'nullable|array',
            'sector.*' => 'exists:sector,id',
            'company' => 'nullable|array',
            'company.*' => 'exists:company,id',
        ]);

        DB::beginTransaction();

        try {
            $document->name = $validatedData['name'];
            $document->macro_id = $validatedData['macro_id'];

            if ($request->hasFile('file')) {
                // Salva a versão atual ANTES de sobrescrever qualquer coisa
                $document->versions()->create([
                    'file_path' => $document->file_path,
                    'revision' => $document->revision,
                ]);

                // Armazena o novo arquivo
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documents', $fileName, 'public');

                // Atualiza o documento com o novo path
                $document->file_path = $path;
            }

            // Incrementa automaticamente a revisão
            $document->revision += 1;

            $document->save();

            $document->sector()->sync($validatedData['sector'] ?? []);
            $document->company()->sync($validatedData['company'] ?? []);

            DB::commit();
            return redirect()->route('documents.index')->with('success', 'Documento atualizado com sucesso! Nova versão salva.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar documento: ' . $e->getMessage());
            return redirect()->route('documents.edit', $document->id)->with('error', 'Erro ao atualizar documento.');
        }
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        try {
            $document->delete();
            return redirect()->route('documents.index')->with('success', 'Documento movido para a lixeira.');
        } catch (\Exception $e) {
            Log::error('Erro ao mover documento para a lixeira: ' . $e->getMessage());
            return redirect()->route('documents.index')->with('error', 'Erro ao mover documento.');
        }
    }

    public function toggleLock(Document $document)
    {
        try {
            $this->authorize('update', $document);

            $document->locked = !$document->locked;
            $document->save();

            return response()->json([
                'success' => true,
                'locked' => $document->locked,
                'status' => $document->locked ? 'Inativo' : 'Ativo'
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao alternar bloqueio: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    public function trash()
    {
        $documents = Document::onlyTrashed()->with(['macro', 'user', 'sector', 'company'])->paginate(10);
        return view('documents.trash', compact('documents'));
    }

    public function restore($id)
    {
        $document = Document::onlyTrashed()->findOrFail($id);
        $document->restore();

        return redirect()->route('documents.trash')->with('success', 'Documento restaurado com sucesso!');
    }
    
    public function editsector(Document $document)
    {
        $sector = Sector::all();
        return view('documents.edit-sector', compact('document', 'sector'));
    }

    public function updatesector(Request $request, Document $document)
    {
        $validated = $request->validate([
            'sector' => 'nullable|array',
            'sector.*' => 'exists:sector,id',
        ]);

        $document->sector()->sync($validated['sector'] ?? []);

        return redirect()->route('documents.index')->with('success', 'Setores atualizados com sucesso!');
    }
}
