<x-app-layout>
    <x-page-title page="Nova Compra com Item" pageUrl="{{ route('compras.index') }}" header="Nova Compra + Item" />

    <form method="POST" action="{{ route('compras.store.com.item') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

 <!-- Seção: Dados do Item -->
        <div class="card">
            <div class="card-body space-y-4">
                <h2 class="text-lg font-semibold">Dados do Item</h2>

                <div>
                   <label class="label" for="tipo_material">Tipo de Material</label>
                    <select name="tipo_material" id="tipo_material" class="select w-full" required>
                        <option value="">-- Selecione --</option>
                        <option value="epi_epc">EPI / EPC</option>
                        <option value="maquinario">Maquinário</option>
                        <option value="material_escritorio">Material de Escritório</option>
                        <option value="material_informatica">Material de Informática</option>
                        <option value="material_limpeza">Material de Limpeza</option>
                        <option value="material_eletrico">Material Elétrico</option>
                        <option value="material_producao">Material de Produção</option>
                        <option value="outro">Outro</option>
                        <option value="prestacao_servico">Prestação de Serviço</option>
                    </select>

                        <!-- outras opções -->
                    </select>
                </div>

                <div>
                    <label class="label" for="tipo_utilizacao">Tipo de Utilização</label>
                    <select name="tipo_utilizacao" class="select w-full" required>
                        <option value="">-- Selecione --</option>
                        <option value="industrializacao" {{ old('tipo_utilizacao') == 'industrializacao' ? 'selected' : '' }}>Industrialização</option>
                        <option value="uso_consumo" {{ old('tipo_utilizacao') == 'uso_consumo' ? 'selected' : '' }}>Uso e Consumo</option>
                        <option value="imobilizado" {{ old('tipo_utilizacao') == 'imobilizado' ? 'selected' : '' }}>Imobilizado</option>
                    </select>
                </div>

                <div>
                    <label class="label" for="descricao">Item</label>
                    <input type="text" id="descricao" name="descricao" class="input w-full" required>
                </div>

                <div>
                    <label class="label" for="descricao_detalhada">Descrição Detalhada</label>
                    <input type="text" id="descricao_detalhada" name="descricao_detalhada" class="input w-full" required>
                </div>

                <div>
                    <label class="label" for="marcas">Marcas</label>
                    <input type="text" id="marcas" name="marcas" class="input w-full">
                </div>

                <div>
                    <label class="label" for="link_exemplo">Link de Exemplo</label>
                    <input type="url" id="link_exemplo" name="link_exemplo" class="input w-full">
                </div>

                <div>
                    <label class="label" for="imagem">Imagem</label>
                    <input type="file" id="imagem" name="imagem" class="input w-full">
                </div>

                <div>
                    <label class="label" for="users">Usuários Responsáveis</label>
                <select name="user_id" id="user_id" class="select w-full" required>
                    <option value="">-- Selecione um usuário --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>

                </div>
            </div>
        </div>

        <!-- Seção: Dados da Compra -->
        <div class="card">
            <div class="card-body space-y-4">
                <h2 class="text-lg font-semibold">Dados da Compra</h2>

                <div>
                    <label class="label" for="data_necessidade">Data de Necessidade</label>
                    <input type="date" id="data_necessidade" name="data_necessidade" class="input w-full" required>
                </div>

                <div>
                    <label class="label" for="realizar_orcamento">Realizar Orçamento</label>
                    <select name="realizar_orcamento" id="realizar_orcamento" class="select w-full" required>
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select>
                </div>

                <div>
                    <label class="label" for="valor_previsto">Valor Previsto</label>
                    <input type="number" id="valor_previsto" name="valor_previsto" step="0.01" class="input w-full" required>
                </div>

                <div>
                    <label class="label" for="quantidade">Quantidade</label>
                    <input type="number" id="quantidade" name="quantidade" class="input w-full" required>
                </div>

                <div>
                    <label class="label" for="justificativa">Justificativa</label>
                    <textarea id="justificativa" name="justificativa" class="input w-full" required></textarea>
                </div>

                <div>
                    <label class="label" for="item_id">Item</label>
                    <select name="item_id" id="item_id" class="input w-full">
                        <option value="">-- Selecione um item --</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id', $selectedItemId ?? '') == $item->id ? 'selected' : '' }}>
                                {{ $item->descricao }}
                            </option>
                        @endforeach
                        <option value="new">+ Criar novo item</option>
                    </select>
                </div>

                <div id="new-item-fields" class="hidden space-y-2">
                    <label class="label" for="descricao_novo">Descrição</label>
                    <input type="text" id="descricao_novo" name="descricao" value="{{ old('descricao') }}" class="input w-full" />
                    <!-- Você pode adicionar mais campos do item aqui -->
                </div>

                <div>
                    <label class="label" for="sugestao_fornecedor">Sugestão de Fornecedor</label>
                    <input type="text" id="sugestao_fornecedor" name="sugestao_fornecedor" class="input w-full">
                </div>
            </div>
        </div>

       

        <!-- Botão -->
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Criar Compra + Item</button>
        </div>
    </form>

    <!-- JS para alternar campos de novo item -->
    <script>
        document.getElementById('item_id').addEventListener('change', function () {
            const newItemFields = document.getElementById('new-item-fields');
            if (this.value === 'new') {
                newItemFields.classList.remove('hidden');
            } else {
                newItemFields.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
