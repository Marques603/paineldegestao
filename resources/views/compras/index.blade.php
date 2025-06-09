<x-app-layout>
    <x-page-title page="Lista de Itens" header="Lista de Itens" />

    @if(session('success'))
        <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded shadow-lg z-50" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="space-y-4">
        <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
            <form method="GET" action="{{ route('item.index') }}" class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
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

            <div class="flex w-full items-center justify-between gap-x-4 md:w-auto">
                <div class="flex items-center gap-x-4">
                    <button class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                        <i class="h-4" data-feather="upload"></i>
                        <span class="hidden sm:inline-block">Exportar</span>
                    </button>
                </div>

                <a class="btn btn-primary" href="{{ route('item.create') }}" role="button">
                    <i data-feather="plus" height="1rem" width="1rem"></i>
                    <span class="hidden sm:inline-block">Criar</span>
                </a>
            </div>
        </div>

        <div class="table-responsive whitespace-nowrap rounded-primary">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-[5%]"><input class="checkbox" type="checkbox" /></th>
                        <th class="w-[10%] uppercase">ID</th>
                        <th class="w-[20%] uppercase">Valor Previsto</th>
                        <th class="w-[15%] uppercase">Quantidade</th>
                        <th class="w-[25%] uppercase">Justificativa</th>
                        <th class="w-[10%] uppercase">Fornecedor</th>
                        <th class="w-[15%] uppercase text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $compra)
                        <tr>
                            <td><input class="checkbox" type="checkbox" /></td>
                            <td>{{ $compra->id }}</td>
                            <td>R$ {{ number_format($compra->valor_previsto, 2, ',', '.') }}</td>
                            <td>{{ $compra->quantidade }}</td>
                            <td>{{ Str::limit($compra->justificativa, 50) }}</td>
                            <td>{{ $compra->sugestao_fornecedor ?? '—' }}</td>
                            <td class="text-right">
                                <div class="flex justify-end">
                                    <div class="dropdown">
                                        <div class="dropdown-toggle">
                                            <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                                        </div>
                                        <div class="dropdown-content">
                                            <ul class="dropdown-list">
                                                <li class="dropdown-list-item">
                                                    <a href="{{ route('compras.edit', $compra->id) }}" class="dropdown-link">
                                                        <i class="h-5 text-slate-400" data-feather="edit"></i>
                                                        <span>Editar</span>
                                                    </a>
                                                </li>
                                                <li class="dropdown-list-item">
                                                    <form method="POST" action="{{ route('compras.destroy', $compra->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-link text-red-600">
                                                            <i class="h-5 text-slate-400" data-feather="trash"></i>
                                                            <span>Excluir</span>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
            <p class="text-xs font-normal text-slate-400">
                Mostrando {{ $compras->firstItem() }} a {{ $compras->lastItem() }} de {{ $compras->total() }} resultados
            </p>
            {{ $compras->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    </div>
</x-app-layout>
