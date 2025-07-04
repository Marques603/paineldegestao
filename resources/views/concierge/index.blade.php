<x-app-layout>
    <x-page-title page="Controle da Portária" header="Controle da Portária" />

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

    @if(session('error'))
    <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-danger-500 text-white rounded shadow-lg z-50" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    <script>
        setTimeout(() => {
            const toast = document.querySelector('.fixed.top-0.right-0');
            if (toast) toast.remove();
        }, 8000);
    </script>
    @endif

    <div class="space-y-4">
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
                    placeholder="Buscar..."
                />
            </form>

            <a class="btn btn-primary" href="{{ route('concierge.create') }}">
                <i data-feather="corner-up-right" class="w-4 h-4"></i>
                <span class="hidden sm:inline-block">Registrar Saída</span>
            </a>
        </div>

        {{-- Tabela --}}
        <div class="table-responsive whitespace-nowrap rounded-primary">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-[5%]"><input class="checkbox" type="checkbox" /></th>
                        <th class="w-[20%] uppercase">Data</th>
                        <th class="w-[20%] uppercase">Veículo</th>
                        <th class="w-[20%] uppercase">Motorista</th>
                        <th class="w-[20%] uppercase">Destino</th>
                        <th class="w-[20%] uppercase">Status</th>
                        <th>KM Saída</th>
                        <th>KM Chegada</th>
                        <th class="text-right">Informar chegada</th>
                    </tr>
                </thead>
<tbody>
    @forelse($concierges as $concierge)
        <tr>
            <td><input class="checkbox" type="checkbox" /></td>

            <td>{{ $concierge->created_at->format('d/m/Y') }}</td>
            <td>{{ $concierge->log->vehicle->name ?? 'Sem veículo' }}</td>
            <td>{{ $concierge->log->user->name ?? 'Sem motorista' }}</td>
            <td>{{ ucfirst($concierge->destination) }}</td>
            <td>
                @if($concierge->status)
                    <div class="badge badge-danger badge-rounded">Na estrada</div>
                @else
                    <div class="badge badge-success badge-rounded">Na empresa</div>
                @endif
            </td>
            <td>{{ $concierge->log->kminit ?? 'Sem registro' }}</td>
            <td>{{ $concierge->log->kmcurrent ?? 'Sem registro' }}</td>
            <td class="text-right">
<form action="{{ route('concierge.edit', $concierge->id) }}" method="GET">
    <button type="submit" class="btn btn-outline-warning">
        <i data-feather="corner-up-left" class="h-4 w-4"></i>
        <span>Retorno</span>
    </button>
</form>


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
