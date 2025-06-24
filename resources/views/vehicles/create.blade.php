<x-app-layout>
    <x-page-title page="Veículos" header="Cadastro de novos veículos" />
<div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
    
        <!-- Preview fixo à esquerda -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                        <i data-feather="truck" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Adicionar Veículos</h2>
                </div>
            </div>
        </section>

        <!-- Formulário -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Detalhes dos Veículos</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Preencha as informações do veículo</p>
        <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            {{-- Seção de Detalhes da Requisição --}}
            <section class="rounded-lg bg-white p-6 shadow-sm dark:bg-slate-800 space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">


                    {{-- Nome do Veículo --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="nome_veiculo">* Nome do Veículo</label>
                        <input type="text" name="name" id="name" class="input" placeholder="Ex: Gol G5" required>
                    </div>

                    {{-- Modelo --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="model">* Modelo</label>
                        <select name="model" id="model" class="select" required>
                            <option value="">Escolha uma opção</option>
                            <option value="Hatch">Hatch</option>
                            <option value="Sedan">Sedan</option>
                            <option value="SUV">SUV</option>
                            <option value="Picape">Picape</option>
                            <option value="Caminhonete">Caminhonete</option>
                            <option value="Van">Van</option>
                            <option value="Utilitário">Utilitário</option>
                            <option value="Caminhão">Caminhão</option>
                        </select>
                    </div>

                    {{-- Placa --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="plate">* Placa </label>
                        <input type="text" name="plate" id="plate" class="input" placeholder="Ex: BRA2E19 ou BVZ-3191" required>
                    </div>
                </div>

                    {{-- Marca --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="brand">* Marca</label>
                        <input type="text" name="brand" id="brand" class="input" placeholder="Ex: Volkswagen" required>
                    </div>

                    {{-- KM inicial 
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="kminit">* KM inicial</label>
                        <input type="number" name="kminit" id="kminit" class="input" placeholder="Digite aqui..." required>
                    </div>

                   
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="kmcurrent">* KM atual</label>
                        <input type="number" name="kmcurrent" id="kmcurrent" class="input" placeholder="Digite aqui..." required>
                    </div>
                    {{-- KM final
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="kmend">* KM final</label>
                        <input type="number" name="kmend" id="kmend" class="input" placeholder="Digite aqui..." required>
                    </div> --}}

            </section>

            {{-- Botão de Submit alinhado à direita --}}
    
            <div class="flex justify-center">
                <button type="submit" class="btn btn-primary">
                    Adicionar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>