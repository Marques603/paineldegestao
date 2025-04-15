<x-app-layout>
    <!-- Page Title Starts -->
  
    <x-page-title page="Lista de Usuários" header="Lista de Usuários" />


  <!-- Page Title Ends -->

    <!-- User List Starts -->
    <div class="space-y-4">
      <!-- User Header Starts -->
      <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
        <!-- User Search Starts -->
        <form method="GET" action="{{ route('users.index') }}" class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72"
        >
          <div class="flex h-full items-center px-2">
            <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
          </div>
          <input
              name="search"
              class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
              type="text"
              value="{{ request()->input('search') }}"
              placeholder="Buscar..."/>
        </form>
        <!-- User Search Ends -->

        <!-- User Action Starts -->
        <div class="flex w-full items-center justify-between gap-x-4 md:w-auto">
          <div class="flex items-center gap-x-4">
            <div class="dropdown" data-placement="bottom-end">
              <div class="dropdown-toggle">
                <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                  <i class="w-4" data-feather="filter"></i>
                  <span class="hidden sm:inline-block">Filtros</span>
                  <i class="w-4" data-feather="chevron-down"></i>
                </button>
              </div>
              <div class="dropdown-content w-72 !overflow-visible">
                <ul class="dropdown-list space-y-4 p-4">
                  <li class="dropdown-list-item">
                    <h2 class="my-1 text-sm font-medium">Setor</h2>
                    <select class="tom-select w-full" autocomplete="off">
                      <option value="">Selecione um setor</option>
                      <option value="1">Tecnologia</option>
                      <option value="2">Qualidade</option>
                      <option value="3">Processos</option>
                    </select>
                  </li>

                  <li class="dropdown-list-item">
                    <h2 class="my-1 text-sm font-medium">Status</h2>
                    <select class="tom-select w-full" autocomplete="off">
                      <option value="">Selecione um status</option>
                      <option value="1">Ativo</option>
                      <option value="2">Inativo</option>
                    </select>
                  </li>
                </ul>
              </div>
            </div>
            <button class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
              <i class="h-4" data-feather="upload"></i>
              <span class="hidden sm:inline-block">Export</span>
            </button>
          </div>

          <a class="btn btn-primary" href="{{ route('users.create') }}" role="button">
            <i data-feather="plus" height="1rem" width="1rem"></i>
            <span class="hidden sm:inline-block">Criar Usuário</span>
          </a>
        </div>
        <!-- User Action Ends -->
      </div>
      <!-- User Header Ends -->

      <!-- User Table Starts -->
      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th class="w-[5%]">
                <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".user-checkbox" />
              </th>
              <th class="w-[30%] uppercase">Nome</th>
              <th class="w-[20%] uppercase">Email</th>
              <th class="w-[15%] uppercase">Setor</td>
              <th class="w-[15%] uppercase">Data de Criação</th>
              <th class="w-[15%] uppercase">Status</th>
              <th class="w-[5%] !text-right uppercase">Acão</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td>
                <input class="checkbox user-checkbox" type="checkbox" />
              </td>
              <td>
                <div class="flex items-center gap-3">
                  <div class="avatar avatar-circle">
                    <img class="avatar-img" src="{{asset('images/avatar1.png')}}" alt="Avatar 1" />
                  </div>
                  <div>
                    <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                      {{ $user->name }}
                    </h6>
                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">alterar depois função</p>
                  </div>
                </div>
              </td>
              <td>{{ $user->email }}</td>
              <td>Setor</td>
              <td>{{ $user->created_at }}</td>
              <td>
                <div class="badge badge-soft-success">Ativo</div>
              </td>
              <td>
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                    </div>
                    <div class="dropdown-content">
  <ul class="dropdown-list">
    <li class="dropdown-list-item">
      <a href="#" class="dropdown-link">
        <i class="h-5 text-slate-400" data-feather="external-link"></i>
        <span>Details</span>
      </a>
    </li>
    <li class="dropdown-list-item">
      <a href="javascript:void(0)" 
         data-modal-target="deleteModal-{{ $user->id }}" 
         data-modal-toggle="deleteModal-{{ $user->id }}" 
         class="dropdown-link">
        <i class="h-5 text-slate-400" data-feather="trash"></i>
        <span>Excluir</span>
      </a>
    </li>
  </ul>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div id="deleteModal-{{ $user->id }}" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 flex justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full max-w-md h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5 text-center">
            <!-- Botão de Fechar -->
            <button type="button" class="absolute top-2.5 right-2.5 text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-lg text-sm p-1.5" data-modal-toggle="deleteModal-{{ $user->id }}">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                <span class="sr-only">Close modal</span>
            </button>
            
            <!-- Ícone do Modal -->
            <svg class="mx-auto mb-4 w-12 h-12 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zm-2 6a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
            
            <p class="mb-4 text-gray-500 dark:text-gray-300">Tem certeza de que deseja excluir <strong>{{ $user->name }}</strong>?</p>
            
            <div class="flex justify-center gap-4">
                <!-- Botão de Cancelar -->
                <button data-modal-toggle="deleteModal-{{ $user->id }}" type="button" class="py-2 px-4 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-primary-300 dark:bg-gray-700 dark:text-white dark:border-gray-500 dark:hover:bg-gray-600">
                    Cancelar
                </button>
                
                <!-- Formulário de Exclusão -->
                <form method="POST" action="{{ route('users.destroy', $user) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="py-2 px-4 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                        Sim, excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
          
        </table>
      </div>
      <!-- User Table Ends -->

      <!-- User Pagination Starts -->
<div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
  <p class="text-xs font-normal text-slate-400">
    Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} resultados
  </p>
  {{ $users->appends(request()->query())->links('vendor.pagination.custom') }}
</div>
<!-- User Pagination Ends -->
    </div>
    <!-- User List Ends -->
</x-app-layout>
