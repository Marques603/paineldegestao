<x-app-layout>
    <x-page-title page="Fluxo da Portária" header="Fluxo da Portária" />

    {{-- Toast de sucesso --}}
    @if(session('success'))
        <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded shadow-lg z-50" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast');
                if (toast) toast.remove();
            }, 3000);
        </script>
    @endif

    {{-- Toast de erro --}}
    @if(session('error'))
        <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-red-500 text-white rounded shadow-lg z-50" role="alert">
            <p>{{ session('error') }}</p>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast');
                if (toast) toast.remove();
            }, 8000);
        </script>
    @endif

    <div class="space-y-4">
        {{-- Barra de busca --}}
        <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
            <form method="GET" action="{{ route('concierge.index') }}" class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:bg-slate-800 md:w-72">
                <div class="flex items-center px-2">
                    <i class="h-4 text-slate-400" data-feather="search"></i>
                </div>
                <input
                    name="search"
                    type="text"
                    value="{{ request()->input('search') }}"
                    class="w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 focus:ring-0"
                    placeholder="Buscar destino ou motivo..."
                />
            </form>
        </div>

        {{-- Tabela --}}
        <div class="table-responsive whitespace-nowrap rounded-primary">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-[5%]"><input class="checkbox" type="checkbox" /></th>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Veículo</th>
                        <th>Motorista</th>
                        <th>Destino</th>
                        <th>Status</th>
                        <th>KM Inicial</th>
                        <th>KM Atual</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($concierges as $concierge)
                        <tr>
                            <td><input class="checkbox" type="checkbox" /></td>
                            <td>{{ $concierge->id }}</td>
                            <td>{{ $concierge->created_at->format('d/m/Y') }}</td>
                            <td>{{ $concierge->log->vehicle->name ?? 'Sem veículo' }}</td>
                            <td>{{ $concierge->log->user->name ?? 'Sem motorista' }}</td>
                            <td>{{ ucfirst($concierge->destination) }}</td>
                            <td>
                            @if($concierge->status)
                                <div class="badge badge-outline-danger">Na estrada</div>
                            @else
                                <div class="badge badge-outline-success">Na empresa</div>
                            @endif
                            </td>
                            <td>{{ $concierge->log->kminit ?? 'Sem registro' }}</td>
                            <td>{{ $concierge->log->kmcurrent ?? 'Sem registro' }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">

                                    {{-- Editar --}}
                                    <a href="{{ route('concierge.edit', $concierge->id) }}" class="text-write-600 hover:text-blue-800">
                                        <i class="h-5 w-5" data-feather="edit"></i>
                                    </a>

                                    {{-- Excluir --}}
                                    <form method="POST" action="{{ route('concierge.destroy', $concierge->id) }}" onsubmit="return confirm('Tem certeza que deseja excluir este registro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-write-600 hover:text-red-800">
                                            <i class="h-5 w-5" data-feather="trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-slate-400 py-4">Nenhum registro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginação --}}
        @if($concierges->total() > 0)
            <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
                <p class="text-xs text-slate-400">
                    Mostrando {{ $concierges->firstItem() }} a {{ $concierges->lastItem() }} de {{ $concierges->total() }} resultados
                </p>
                {{ $concierges->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
</x-app-layout>
