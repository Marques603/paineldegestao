<x-app-layout>
    <x-page-title page="Editar Requisição" pageUrl="{{ route('item.index') }}" header="Editar Requisição" />

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
                        <i data-feather="clipboard" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Requisição #{{ $item->id }}</h2>
                    <p class="text-sm text-slate-400 mt-2 text-center">Data de Criação: {{ $item->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </section>

        <!-- Formulários -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <!-- Detalhes da Requisição -->
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('item.update', $item->id) }}">
                        @csrf
                        @method('PUT')

                        <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Detalhes da Requisição</h2>
                        <p class="mb-4 text-sm text-slate-400">Atualize os dados principais da compra.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <label class="label">
                        <span class="block mb-1">Tipo de Material</span>
                        <select name="tipo_material" id="tipo_material" class="select" required>
                            <option value="">Escolha uma opção</option>
                            <option value="epi_epc" @selected($item->tipo_material == 'epi_epc')>EPI/EPC</option>
                            <option value="maquinario" @selected($item->tipo_material == 'maquinario')>Maquinário</option>
                            <option value="material_escritorio" @selected($item->tipo_material == 'material_escritorio')>Material de Escritório</option>
                            <option value="material_informatica" @selected($item->tipo_material == 'material_informatica')>Material de Informática</option>
                            <option value="material_limpeza" @selected($item->tipo_material == 'material_limpeza')>Material de Limpeza</option>
                            <option value="material_eletrico" @selected($item->tipo_material == 'material_eletrico')>Material Elétrico</option>
                            <option value="material_producao" @selected($item->tipo_material == 'material_producao')>Material Produção</option>
                            <option value="outro" @selected($item->tipo_material == 'outro')>Outro</option>
                            <option value="prestacao_servico" @selected($item->tipo_material == 'prestacao_servico')>Prestação de Serviço</option>
                        </select>
                            </label>

                        <label class="label">
                        <span class="block mb-1">Tipo de Utilização</span>
                        <select name="tipo_utilizacao" id="tipo_utilizacao" class="select" required>
                            <option value="">Escolha uma opção</option>
                            <option value="industrializacao" @selected($item->tipo_utilizacao == 'industrializacao')>INDUSTRIALIZAÇÃO</option>
                            <option value="uso_consumo" @selected($item->tipo_utilizacao == 'uso_consumo')>USO E CONSUMO</option>
                            <option value="imobilizado" @selected($item->tipo_utilizacao == 'imobilizado')>IMOBILIZADO</option>
                        </select>
                            </label>

                        <label class="label">
                        <span class="block mb-1">Item</span>                            
                        <input type="text" name="descricao" id="descricao" class="input" placeholder="Nome do Item..." value="{{ old('descricao', $item->descricao) }}" required>
                        </label>

                        <label class="label">
                        <span class="block mb-1">Descrição detalhada do item</span>
                        <input type="text" name="descricao_detalhada" id="descricao_detalhada" class="input" placeholder="Descrição Detalhada..." value="{{ old('descricao_detalhada', $item->descricao_detalhada) }}" required>                            
                        </label>

                        <label class="label">
                        <span class="block mb-1">Marcas</span>
                        <input type="text" name="marcas" id="marcas" class="input" placeholder="Marcas do Item..." value="{{ old('marcas', $item->marcas) }}">
                        </label>

                        <label class="label">
                        <span class="block mb-1">Link de Exemplo</span>         
                        <input type="url" name="link_exemplo" id="link_exemplo" class="input" placeholder="https://exemplo.com" value="{{ old('link_exemplo', $item->link_exemplo) }}">
                        </label>



                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('item.index') }}" class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Outros Formulários (Ex: Setores, Aprovações, etc) podem ser adicionados aqui -->
        </section>
    </div>
</x-app-layout>
