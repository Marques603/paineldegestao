<x-app-layout>
    <x-page-title page="Documentos" pageUrl="{{ route('document.index') }}" header="Lista de Documentos" />
  
    <div class="card">
      <div class="card-body">
        <div class="flex justify-end mb-4">
          <a href="{{ route('document.create') }}" class="btn btn-primary">Novo Documento</a>
        </div>
  
        <table class="table-auto w-full">
          <thead>
            <tr>
              <th class="text-left p-2">Nome</th>
              <th class="text-left p-2">Revisão</th>
              <th class="text-left p-2">Status</th>
              <th class="text-left p-2">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach($documents as $document)
              <tr class="border-t">
                <td class="p-2">{{ $document->name }}</td>
                <td class="p-2">{{ $document->revision }}</td>
                <td class="p-2">{{ $document->status ? 'Ativo' : 'Inativo' }}</td>
                <td class="p-2">
                  <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-blue-500 hover:underline">Ver</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
  
        <div class="mt-4">
          {{ $documents->links() }}
        </div>
      </div>
    </div>
  </x-app-layout>
  