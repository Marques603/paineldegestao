<x-app-layout>
  <!-- Page Title Starts -->
  <x-page-title page="Documentos" header="Lista de Documentos" />
  <!-- Page Title Ends -->

  @if(session('success'))
      <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded shadow-lg z-50" role="alert">
          <p>{{ session('success') }}</p>
      </div>
  @endif

  <!-- Document List Starts -->
  <div class="space-y-4">
      <!-- Header Starts -->
      <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
          <!-- Search Starts -->
          <form method="GET" action="{{ route('documents.index') }}" class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:bg-slate-800 md:w-72">
              <div class="flex h-full items-center px-2">
                  <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
              </div>
              <input
                  name="search"
                  class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
                  type="text"
                  value="{{ request()->input('search') }}"
                  placeholder="Buscar..."
                  
              />
          </form>
          <!-- Search Ends -->

          <!-- Botão de novo documento -->
          <a href="{{ route('documents.create') }}" class="btn btn-primary flex items-center gap-2">
              <i data-feather="plus" class="w-4 h-4"></i>
              <span class="hidden sm:inline-block">Novo Documento</span>
          </a>
      </div>
      <!-- Header Ends -->

      <!-- Tabela de Documentos -->
      <div class="table-responsive whitespace-nowrap rounded-primary">
          <table class="table">
              <thead>
                  <tr>
                      <th>Nome</th>
                      <th>Revisão</th>
                      <th>Status</th>
                      <th class="!text-right">Ações</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse($documents as $document)
                      <tr>
                          <td>{{ $document->name }}</td>
                          <td>{{ $document->revision }}</td>
                          <td>
                              @if($document->status)
                                  <div class="badge badge-soft-success">Ativo</div>
                              @else
                                  <div class="badge badge-soft-danger">Inativo</div>
                              @endif
                          </td>
                          <td class="text-right">
                              <div class="flex justify-end">
                                  <div class="dropdown" data-placement="bottom-start">
                                      <div class="dropdown-toggle">
                                          <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                                      </div>
                                      <div class="dropdown-content">
                                          <ul class="dropdown-list">
                                              <li class="dropdown-list-item">
                                                  <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="dropdown-link">
                                                      <i class="h-5 text-slate-400" data-feather="eye"></i>
                                                      <span>Ver</span>
                                                  </a>
                                              </li>
                                              <li class="dropdown-list-item">
                                                  <a href="{{ route('documents.edit', $document->id) }}" class="dropdown-link">
                                                      <i class="h-5 text-slate-400" data-feather="edit"></i>
                                                      <span>Editar</span>
                                                  </a>
                                              </li>
                                              <li class="dropdown-list-item">
                                                  <a href="javascript:void(0)" class="dropdown-link" data-toggle="modal" data-target="#deleteModal-{{ $document->id }}">
                                                      <i class="h-5 text-slate-400" data-feather="trash"></i>
                                                      <span>Excluir</span>
                                                  </a>
                                              </li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>

                              <!-- Modal de Confirmação -->
                              <div class="modal modal-centered" id="deleteModal-{{ $document->id }}">
                                  <div class="modal-dialog modal-dialog-centered">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <div class="flex items-center justify-between">
                                                  <h6>Confirmação</h6>
                                                  <button type="button" class="btn btn-plain-secondary" data-dismiss="modal">
                                                      <i data-feather="x" width="1.5rem" height="1.5rem"></i>
                                                  </button>
                                              </div>
                                          </div>
                                          <div class="modal-body">
                                              <p class="text-sm text-slate-500 dark:text-slate-300">
                                                  Tem certeza que deseja excluir <strong>{{ $document->name }}</strong>?
                                              </p>
                                          </div>
                                          <div class="modal-footer flex justify-center">
                                              <form method="POST" action="{{ route('documents.destroy', $document->id) }}">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                  <button type="submit" class="btn btn-danger">Sim, excluir</button>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="4" class="text-center text-slate-500 py-4">Nenhum documento encontrado.</td>
                      </tr>
                  @endforelse
              </tbody>
          </table>
      </div>
      <!-- Tabela Fim -->

      <!-- Paginação -->
      <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
          <p class="text-xs font-normal text-slate-400">
              Mostrando {{ $documents->firstItem() }} a {{ $documents->lastItem() }} de {{ $documents->total() }} resultados
          </p>
          {{ $documents->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
  </div>
  <!-- Document List Ends -->
</x-app-layout>
