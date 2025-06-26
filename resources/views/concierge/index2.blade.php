<x-app-layout>
    <x-page-title page="Lista de Concierge" header="Lista de Concierge" />

    {{-- Toast de sucesso --}}
    @if(session('success'))
        <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded shadow-lg z-50" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast');
                if (toast) {
                    toast.remove();
                }
            }, 3000);
        </script>
    @endif

    <div class="space-y-4">
        {{-- Barra de busca e botão de criar --}}
        <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
            <form method="GET" action="{{ route('concierge2.index') }}" class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
                <div class="flex h-full items-center px-2">
                    <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
                </div>
                <input
                    name="search"
                    class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
                    type="text"
                    value="{{ request()->input('search') }}"
                    placeholder="Buscar destino ou motivo..."
                />
            </form>

            <a class="btn btn-primary" href="{{ route('concierge.create') }}" role="button">
                <i data-feather="plus" height="1rem" width="1rem"></i>
                <span class="hidden sm:inline-block">Criar</span>
            </a>
        </div>

        {{-- Tabela de concierge --}}
        <div class="table-responsive whitespace-nowrap rounded-primary">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-[5%]"><input class="checkbox" type="checkbox" /></th>
                        <th class="w-[10%] uppercase">ID</th>
                        <th class="w-[15%] uppercase">Data</th>
                        <th class="w-[15%] uppercase">Veículo</th>
                        <th class="w-[15%] uppercase">Motorista</th>
                        <th class="w-[20%] uppercase">Destino</th>
                        <th class="w-[20%] uppercase">Status</th>
                        <th class="w-[10%] text-right uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($concierges as $concierge)
                        <tr>
                            <td><input class="checkbox" type="checkbox" /></td>
                            <td>{{ $concierge->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($concierge->date)->format('d/m/Y') }}</td>
                            <td> @foreach($concierge->vehicles as $vehicle) {{ $vehicle->name }}<br>@endforeach </td>
                            <td>@foreach($concierge->users as $user)
                                        {{ $user->name }}<br>
                                    @endforeach
                                </td>
                            <td>{{ ucfirst($concierge->destination) }}</td>
 <td>
                                @if($concierge->status)
                                    <div class="badge badge-soft-success">Na estrada</div>
                                @else
                                    <div class="badge badge-soft-danger">Na empresa</div>
                                @endif
                            </td>

                            <td class="text-right">
                                <div class="flex justify-end">
                                    <div class="dropdown">
                                        <div class="dropdown-toggle">
                                            <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                                        </div>
                                        <div class="dropdown-content">
                                            <ul class="dropdown-list">
                                                 <li class="dropdown-list-item">
                                                    <a href="{{ route('concierge.show', $concierge->id) }}" class="dropdown-link">
                                                        <i class="h-5 text-slate-400" data-feather="edit"></i>
                                                        <span>Detalhes</span>
                                                    </a>
                                                </li>
                                                <li class="dropdown-list-item">
                                                    <a href="{{ route('concierge.edit', $concierge->id) }}" class="dropdown-link">
                                                        <i class="h-5 text-slate-400" data-feather="edit"></i>
                                                        <span>Editar</span>
                                                    </a>
                                                </li>
                                                <li class="dropdown-list-item">
                                                    <form method="POST" action="{{ route('concierge.destroy', $concierge->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-link text-red-600" onclick="return confirm('Tem certeza que deseja excluir este registro?')">
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

        {{-- Paginação --}}
        <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
            <p class="text-xs font-normal text-slate-400">
                Mostrando {{ $concierges->firstItem() }} a {{ $concierges->lastItem() }} de {{ $concierges->total() }} resultados
            </p>
            {{ $concierges->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    </div>
</x-app-layout>


