<x-app-layout>
    <x-page-title page="Fluxo de entradas e saídas" header="Fluxo de entradas e saídas" />

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">

        <!-- Toast de sucesso -->
        @if(session('success'))
            <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded shadow-lg z-50" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- <!-- Alerta se não há veículos disponíveis -->
        @if ($noVehiclesAvailable)
            <div class="fixed top-4 right-4 z-50">
                <div class="flex items-center bg-yellow-200 border border-yellow-400 text-yellow-800 px-3 py-1.5 rounded text-sm max-w-xs shadow-lg" role="alert">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <strong>Atenção!</strong> Não há veículos disponíveis.
                </div>
            </div>
        @endif --}}

        <!-- Preview fixo à esquerda -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                        <i data-feather="truck" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">
                        Fluxo da Portaria
                    </h2>
                </div>
            </div>
        </section>

        <!-- Formulário -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">
                        Informações de entrada e saída
                    </h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">
                        Preencha as informações
                    </p>

                    <form action="{{ route('concierge.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <section class="rounded-lg bg-white p-6 shadow-sm dark:bg-slate-800 space-y-4">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                {{-- Veículo --}}
                                <div class="flex flex-col">
                                    <label for="vehicle_id" class="label label-required font-medium">Veículo</label>
                                    <select name="vehicle_id" id="vehicle_id" class="select" required>
                                        <option value=""> Escolha uma opção </option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Destino --}}
                                <div class="flex flex-col">
                                    <label for="destination" class="label label-required font-medium">Destino</label>
                                    <input type="text" name="destination" id="destination" class="input" placeholder="Digite aqui..." required>
                                </div>

                                {{-- Motivo --}}
                                <div class="flex flex-col">
                                    <label for="motive" class="label label-required font-medium">Motivo</label>
                                    <input type="text" name="motive" id="motive" class="input" placeholder="Digite aqui..." required>
                                </div>

                                <div class="flex flex-col">
                                    <label class="label label-required font-medium" for="user_id">* Motorista</label>
                                    <select name="user_id" id="user_id" class="select" required>
                                        <option value=""> Escolha uma opção </option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                {{-- Quilometragem Inicial --}}
                                <div class="flex flex-col">
                                    <label for="kminit" class="label label-required font-medium">Quilometragem Atual</label>
                                    <input type="number" name="kminit" id="kminit" class="input" placeholder="KM do Veículo" required readonly>
                                </div>
                            </div>
                        </section>

                        {{-- Botões --}}
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('concierge.index') }}"
                               class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Adicionar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>

{{-- Script para preencher o KM inicial dinamicamente --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const vehicleSelect = document.getElementById('vehicle_id');
        const kmInput = document.getElementById('kminit');

        vehicleSelect.addEventListener('change', function () {
            const vehicleId = this.value;

            if (!vehicleId) return;

            fetch(`/vehicles/${vehicleId}/last-km`)
                .then(response => response.json())
                .then(data => {
                    kmInput.value = data.kminit || 0;
                    kmInput.min = data.kminit || 0;
                })
                .catch(() => {
                    alert('Erro ao buscar quilometragem do veículo');
                });
        });
    });
</script>
