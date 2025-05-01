<x-app-layout>
    <x-page-title page="Lista de Cargos" header="Lista de Cargos" />

    @if(session('success'))
        <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded shadow-lg z-50" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="space-y-4">
        <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
            <!-- Busca -->
            <form method="GET" action="{{ route('position.index') }}" class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
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

            <!-- Ações -->
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
                                    <h2 class="my-1 text-sm font-medium">Status</h2>
                                    <select class="tom-select w-full" name="status" onchange="this.form.submit()">
                                        <option value="">Todos</option>
                                        <option value="1" {{ request()->input('status') == '1' ? 'selected' : '' }}>Ativo</option>
                                        <option value="0" {{ request()->input('status') == '0' ? 'selected' : '' }}>Inativo</option>
                                        <option value="3" {{ request()->input('status') == '3' ? 'selected' : '' }}>Ausente</option>
                                        <option value="4" {{ request()->input('status') == '4' ? 'selected' : '' }}>Ocupado</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <button class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                        <i class="h-4" data-feather="upload"></i>
                        <span class="hidden sm:inline-block">Exportar</span>
                    </button>
                </div>

                <a class="btn btn-primary" href="{{ route('position.create') }}">
                    <i data-feather="plus" height="1rem" width="1rem"></i>
                    <span class="hidden sm:inline-block">Criar</span>
                </a>
            </div>
        </div>

        <!-- Tabela -->
        <div class="table-responsive whitespace-nowrap rounded-primary">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-[5%]">
                            <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".position-checkbox" />
                        </th>
                        <th class="w-[20%] uppercase">Nome</th>
                        <th class="w-[20%] uppercase">Setor</th>
                        <th class="w-[20%] uppercase">Ocupado por</th>
                        <th class="w-[20%] uppercase">Status</th>
                        <th class="w-[5%] !text-right uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($position as $item)
                        <tr>
                            <td>
                                <input class="checkbox position-checkbox" type="checkbox" />
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->sector->name ?? '-' }}</td>
                            <td>{{ $item->user?->name ?? '-' }}</td>
                            <td>
                                @php
                                    $statusLabels = [
                                        0 => 'Inativo',
                                        1 => 'Ativo',
                                        3 => 'Ausente',
                                        4 => 'Ocupado',
                                    ];
                                    $statusColors = [
                                        0 => 'badge-soft-danger',
                                        1 => 'badge-soft-success',
                                        3 => 'badge-soft-warning',
                                        4 => 'badge-soft-primary',
                                    ];
                                @endphp
                                <div class="badge {{ $statusColors[$item->status] ?? 'badge-secondary' }}">
                                    {{ $statusLabels[$item->status] ?? 'Desconhecido' }}
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="dropdown" data-placement="bottom-start">
                                    <div class="dropdown-toggle">
                                        <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                                    </div>
                                    <div class="dropdown-content">
                                        <ul class="dropdown-list">
                                            <li class="dropdown-list-item">
                                                <a href="{{ route('position.edit', $item->id) }}" class="dropdown-link">
                                                    <i class="h-5 text-slate-400" data-feather="edit"></i>
                                                    <span>Editar</span>
                                                </a>
                                            </li>
                                            <li class="dropdown-list-item">
                                                <form method="POST" action="{{ route('position.destroy', $item->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-link text-left w-full">
                                                        <i class="h-5 text-slate-400" data-feather="trash"></i>
                                                        <span>Excluir</span>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
            <p class="text-xs font-normal text-slate-400">
                Mostrando {{ $position->firstItem() }} a {{ $position->lastItem() }} de {{ $position->total() }} resultados
            </p>
            {{ $position->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    </div>
</x-app-layout>
