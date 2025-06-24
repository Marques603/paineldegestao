<x-app-layout>
    <x-page-title page="Registrar Retorno" header="Registrar Retorno do Veículo" />

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Preview fixo à esquerda -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                        <i data-feather="truck" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
<h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">
    Retorno do Veículo {{ $mileage->vehicle->name }} - {{ $mileage->vehicle->plate }}
</h2>


                </div>
            </div>
        </section>

        <!-- Formulário -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">
                        Dados do Retorno
                    </h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Confira os dados e preencha os dados de retorno</p>

                    <form action="{{ route('concierge.update', $concierge->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <section class="rounded-lg bg-white p-6 shadow-sm dark:bg-slate-800 space-y-4">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">



                                <!-- Quilometragem de Retorno (Liberado) -->
                                <div class="flex flex-col">
                                    <label class="label font-medium" for="kmcurrent">Quilometragem de Retorno</label>
                                    <input type="number" name="kmcurrent" id="kmcurrent" class="input" placeholder="Digite a quilometragem ao retornar" value="{{ old('kmcurrent', $mileage->kmcurrent ?? '') }}" required>
                                </div>

                                <!-- Horário de Retorno (Liberado) -->
                                <div class="flex flex-col">
                                    <label class="label font-medium" for="timeend">Horário de Retorno</label>
                                    <input type="time" name="timeend" id="timeend" class="input" value="{{ old('timeend', $concierge->timeend) }}" required>
                                </div>
                            </div>
                        </section>

                        <div class="flex justify-center">
                            <button type="submit" class="btn btn-primary">
                                Registrar Retorno
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
