<x-app-layout>
    <x-page-title page="Editar Requisição" pageUrl="{{ route('compras.index') }}" header="Editar Requisição" />

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
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Requisição #{{ $compra->id }}</h2>
                    <p class="text-sm text-slate-400 mt-2 text-center">Data de Criação: {{ $compra->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </section>

        <!-- Formulários -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <!-- Detalhes da Requisição -->
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('compras.update', $compra->id) }}">
                        @csrf
                        @method('PUT')

                        <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Detalhes da Requisição</h2>
                        <p class="mb-4 text-sm text-slate-400">Atualize os dados principais da compra.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <label class="label">
                                <span class="block mb-1">Data de Necessidade</span>
                                <input type="date" name="data_necessidade" class="input" value="{{ old('data_necessidade', $compra->data_necessidade) }}" required />
                            </label>

                            <label class="label">
                                <span class="block mb-1">Valor Previsto</span>
                                <input type="text" name="valor_previsto" class="input" value="{{ old('valor_previsto', $compra->valor_previsto) }}" required />
                            </label>

                            <label class="label">
                                <span class="block mb-1">Quantidade</span>
                                <input type="number" name="quantidade" class="input" value="{{ old('quantidade', $compra->quantidade) }}" required />
                            </label>

                            <label class="label">
                                <span class="block mb-1">Realizar Orçamento?</span>
                                <select name="realizar_orcamento" class="input" required>
                                    <option value="sim" @selected($compra->realizar_orcamento === 'sim')>Sim</option>
                                    <option value="nao" @selected($compra->realizar_orcamento === 'nao')>Não</option>
                                </select>
                            </label>

                            <label class="label md:col-span-2">
                                <span class="block mb-1">Justificativa</span>
                                <textarea name="justificativa" rows="3" class="input">{{ old('justificativa', $compra->justificativa) }}</textarea>
                            </label>

                            <label class="label md:col-span-2">
                                <span class="block mb-1">Sugestão de Fornecedor</span>
                                <input type="text" name="sugestao_fornecedor" class="input" value="{{ old('sugestao_fornecedor', $compra->sugestao_fornecedor) }}" />
                            </label>
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('compras.index') }}" class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Outros Formulários (Ex: Setores, Aprovações, etc) podem ser adicionados aqui -->
        </section>
    </div>
</x-app-layout>
