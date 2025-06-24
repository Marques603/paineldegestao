<x-app-layout>
    <x-page-title page="Fluxo de entradas e saídas" header="Fluxo de entradas e saídas" />
<div class="grid grid-cols-1 gap-6 lg:grid-cols-4">

        @if(session('success'))
        <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded shadow-lg z-50" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
        <!-- Preview fixo à esquerda -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                        <i data-feather="truck" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Fluxo da Portária</h2>
                </div>
            </div>
        </section>

        <!-- Formulário -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">informações de entradas e saídas</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Preencha as informações</p>
        <form action="{{ route('concierge.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            {{-- Seção de Detalhes da Requisição --}}
            <section class="rounded-lg bg-white p-6 shadow-sm dark:bg-slate-800 space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">


                    {{-- Data de saídas --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="date">* Data<Data></Data></label>
                        <input type="date" name="date" id="date" class="input" required>
                    </div>

                    {{-- Motivo --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="motive">* Motivo</label>
                        <input type="text" name="motive" id="motive" class="input" placeholder="Digite aqui..." required>
                    </div>

                    {{-- Destino --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="destination">* Destino</label>
                        <input type="text" name="destination" id="destination" class="input" placeholder="Digite aqui..." required>
                    </div>
           
                    {{-- Horário de saída --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="timeinit">* Horário de Sáida</label>
                        <input type="time" name="timeinit" id="timeinit" class="input" placeholder="Digite aqui..." required>
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="vehicle_id" class="label label-required font-medium">* Veículo</label>
                        <select name="vehicle_id" id="vehicle_id"
                            class="input"
                            required>
                            <option value="">-- Selecione --</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                            @endforeach
                        </select>
                    </div>

                        <div class="flex flex-col">
                        <label for="user_id" class="label label-required font-medium">* Motorista</label>
                        <select name="user_id" id="user_id"
                            class="input"
                            required>
                            <option value="">-- Selecione --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @foreach($mileage as $vehicleId => $km)
    <input type="hidden" id="km-{{ $vehicleId }}" value="{{ $km }}">
@endforeach
                <!-- Quilometragem de Saída -->
                    <div>
                        <label for="kminit" class="label">Quilometragem de Saída</label>
                        <input type="number" name="kminit" id="kminit"
    class="input"
    value="{{ old('kminit') }}"
    required>
                    </div>
                </section>
            <script>
    const selectVehicle = document.getElementById('vehicle_id');
    const inputKm = document.getElementById('kminit');

    selectVehicle.addEventListener('change', function () {
        const vehicleId = this.value;
        const km = document.getElementById('km-' + vehicleId);

        if (km) {
            inputKm.value = km.value;
        } else {
            inputKm.value = '';
        }
    });
</script>

            {{-- Botão de Submit alinhado à direita --}}
    
            <div class="flex justify-center">
                <button type="submit" class="btn btn-primary">
                    Adicionar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>