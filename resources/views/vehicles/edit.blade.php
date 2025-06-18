<x-app-layout>
    <x-page-title page="Editar Veículo" pageUrl="{{ route('vehicles.index') }}" header="Editar Veículo" />

    @if(session('success'))
        <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded shadow-lg z-50" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Preview -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                        <i data-feather="truck" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Veículo #{{ $vehicle->id }}</h2>
                    <p class="text-sm text-slate-400 mt-2 text-center">Criado em: {{ $vehicle->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </section>

        <!-- Formulário -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('vehicles.update', $vehicle->id) }}">
                        @csrf
                        @method('PUT')

                        <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Detalhes do Veículo</h2>
                        <p class="mb-4 text-sm text-slate-400">Atualize os dados do veículo.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <label class="label">
                                <span class="block mb-1">Nome do Veículo</span>
                                <input type="text" name="name" class="input" placeholder="Ex: Caminhão Pipa" value="{{ old('name', $vehicle->name) }}" required>
                            </label>

                            <label class="label">
                                <span class="block mb-1">Modelo</span>
                                <input type="text" name="model" class="input" placeholder="Ex: Mercedes-Benz Atego" value="{{ old('model', $vehicle->model) }}" required>
                            </label>

                            <label class="label">
                                <span class="block mb-1">Placa</span>
                                <input type="text" name="plate" class="input" placeholder="Ex: ABC-1234" value="{{ old('plate', $vehicle->plate) }}" required>
                            </label>
  

                            <label class="label">
                                <span class="block mb-1">Marca</span>
                                <input type="text" name="brand" class="input" placeholder="Ex: Mercedes-Benz Atego" value="{{ old('brand', $vehicle->brand) }}" required>
                            </label>

                            <label class="label">
                                <span class="block mb-1">KM Final</span>
                                <input type="number" name="kmend" class="input" value="{{ old('kmend', $vehicle->kmend) }}">
                            </label>
                            </div>

                        <div class="flex items-center justify-end gap-4 mt-8">
                            <a href="{{ route('vehicles.index') }}" class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
