<x-app-layout>
    <!-- Page Title Starts -->
    <x-page-title page="Lista de Menus" header="Lista de Menus" />
    <!-- Page Title Ends -->

    @if(session('success'))
        <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded shadow-lg z-50" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- menu List Starts -->
    <div class="space-y-4">
        <!-- menu Header Starts -->
        <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
            <!-- menu Search Starts -->
            <form method="GET" action="{{ route('menus.index') }}" class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
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
            <!-- menu Search Ends -->

            <!-- menu Action Starts -->
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
                                        <option value="1">status</option>
                                        <option value="2">Instatus</option>
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

                <a class="btn btn-primary" href="{{ route('menus.create') }}" role="button">
                    <i data-feather="plus" height="1rem" width="1rem"></i>
                    <span class="hidden sm:inline-block">Criar</span>
                </a>
            </div>
            <!-- menu Action Ends -->
        </div>
        <!-- menu Header Ends -->

        <!-- menu Table Starts -->
        <div class="table-responsive whitespace-nowrap rounded-primary">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-[5%]">
                            <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".menu-checkbox" />
                        </th>
                        <th class="w-[30%] uppercase">Nome</th>
                        <th class="w-[20%] uppercase">Submenus Associados</th>
                        <th class="w-[15%] uppercase">Rota</th>
                        <th class="w-[15%] uppercase">Data de Criação</th>
                        <th class="w-[15%] uppercase">Status</th>
                        <th class="w-[5%] !text-right uppercase">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $menu)
                        <tr>
                            <td>
                                <input class="checkbox menu-checkbox" type="checkbox" />
                            </td>
                            <td>
                            <div class="flex items-center gap-3">
    <div class="h-12 w-12 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
        <i data-feather="{{ $menu->icone ?? 'menu' }}" class="w-6 h-6 text-slate-600 dark:text-slate-200"></i>
    </div>




                                    <div>
                                        <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                                            {{ $menu->name }}
                                        </h6>
                                        <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $menu->description ?? 'Sem descrição' }}</p>
                                    </div>
                                </div>
                            </td>

                            @php
                            $submenuCount = $menu->submenus->count();
                            $submenuNames = $menu->submenus->pluck('name')->join(', ');
                            @endphp
                            <td>
                                <a
                                    href="{{ route('menus.edit', $menu->id) }}"
                                    class="btn btn-sm btn-ghost text-slate-600 dark:text-slate-300"
                                    data-tooltip="tippy"
                                    data-tippy-content="{{ $submenuNames }}"
                                >
                                    {{ $submenuCount }} {{ Str::plural('submenu', $submenuCount) }}
                                </a>
                            </td>
                            <td>{{ $menu->rota }}</td>
                            <td>{{ $menu->created_at }}</td>
                            <td>
                                @if($menu->status)
                                    <div class="badge badge-soft-success">status</div>
                                @else
                                    <div class="badge badge-soft-danger">Instatus</div>
                                @endif
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
                                                    <a href="{{ route('menus.edit', $menu->id) }}" class="dropdown-link">
                                                        <i class="h-5 text-slate-400" data-feather="external-link"></i>
                                                        <span>Editar</span>
                                                    </a>
                                                </li>
                                                <li class="dropdown-list-item">
                                                    <a href="javascript:void(0)"
                                                       class="dropdown-link"
                                                       data-toggle="modal"
                                                       data-target="#deleteModal-{{ $menu->id }}">
                                                        <i class="h-5 text-slate-400" data-feather="trash"></i>
                                                        <span>Excluir</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Modal de Confirmação de Exclusão -->
                                    <div class="modal modal-centered" id="deleteModal-{{ $menu->id }}">
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
                                                        Tem certeza que deseja excluir <strong>{{ $menu->name }}</strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer flex justify-center">
                                                    <div class="flex items-center justify-center gap-4">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <form method="POST" action="{{ route('menus.destroy', $menu) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Sim, excluir</button>
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
        <!-- menu Table Ends -->

        <!-- menu Pagination Starts -->
        <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
            <p class="text-xs font-normal text-slate-400">
                Mostrando {{ $menus->firstItem() }} a {{ $menus->lastItem() }} de {{ $menus->total() }} resultados
            </p>
            {{ $menus->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
        <!-- menu Pagination Ends -->
    </div>
    <!-- menu List Ends -->
</x-app-layout>
