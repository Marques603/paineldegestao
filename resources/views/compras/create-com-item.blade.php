<x-app-layout>
    <x-page-title page="Nova Compra com Item" pageUrl="{{ route('compras.index') }}" header="Nova Compra + Item" />

    <form method="POST" action="{{ route('compras.store.com.item') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="card">
            <div class="card-body">
                <h2 class="text-lg font-semibold">Dados da Compra</h2>

                <!-- Campos da Compra -->
                <label class="label">Data de Necessidade
                    <input type="date" name="data_necessidade" class="input" required>
                </label>

                <label class="label">Realizar Orçamento
                    <select name="realizar_orcamento" class="select" required>
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select>
                </label>

                <label class="label">Valor Previsto
                    <input type="number" name="valor_previsto" step="0.01" class="input" required>
                </label>

                <label class="label">Quantidade
                    <input type="number" name="quantidade" class="input" required>
                </label>

                <label class="label">Justificativa
                    <textarea name="justificativa" class="input" required></textarea>
                </label>


                <label>Item</label>
<select name="item_id" id="item_id" class="input">
    <option value="">-- Selecione um item --</option>
    @foreach ($items as $item)
        <option value="{{ $item->id }}" {{ old('item_id', $selectedItemId ?? '') == $item->id ? 'selected' : '' }}>
            {{ $item->descricao }}
        </option>
    @endforeach
    <option value="new">+ Criar novo item</option>
</select>

<div id="new-item-fields" style="display: none;">
    <label>Descrição</label>
    <input type="text" name="descricao" value="{{ old('descricao') }}" />
    <!-- Outros campos do item aqui -->
</div>
</label>


                <label class="label">Sugestão de Fornecedor
                    <input type="text" name="sugestao_fornecedor" class="input">
                </label>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="text-lg font-semibold">Dados do Item</h2>

                <!-- Campos do Item -->
                <label class="label">Tipo de Material
                    <select name="tipo_material" class="select" required>
                        <option value="maquinario">Maquinário</option>
                        <!-- outras opções -->
                    </select>
                </label>

                <label class="label">Tipo de Utilização
                    <select name="tipo_utilizacao" class="select" required>
                        <option value="uso_consumo">Uso e Consumo</option>
                        <!-- outras opções -->
                    </select>
                </label>

                <label class="label">Descrição
                    <input type="text" name="descricao" class="input" required>
                </label>

                <label class="label">Descrição Detalhada
                    <input type="text" name="descricao_detalhada" class="input" required>
                </label>

                <label class="label">Marcas
                    <input type="text" name="marcas" class="input">
                </label>

                <label class="label">Link de Exemplo
                    <input type="url" name="link_exemplo" class="input">
                </label>

                <label class="label">Imagem
                    <input type="file" name="imagem" class="input">
                </label>

                <!-- Usuários (opcional) -->
                <label class="label">Usuários Responsáveis
                    <select name="users[]" multiple class="select">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Criar Compra + Item</button>
        </div>
    </form>
</x-app-layout>
