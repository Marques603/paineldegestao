<x-app-layout>
    <x-page-title page="Compras" header="Novo Cadastro" />

    <div class="max-w-5xl mx-auto p-4 space-y-6">
       
        {{-- Formulário de Requisição --}}
    <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <section class="rounded-lg bg-white p-6 shadow-sm dark:bg-slate-800 space-y-4">
                <h4 class="text-lg font-semibold text-slate-700 dark:text-slate-200">Cadastro de Item</h4>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    {{-- Tipo de Material --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="tipo_material">* Tipo de Material</label>
                        <select name="tipo_material" id="tipo_material" class="select" required>
                            <option value="">Escolha uma opção</option>
                            <option value="epi_epc">EPI/EPC</option>
                            <option value="maquinario">Maquinário</option>
                            <option value="material_escritorio">Material de Escritório</option>
                            <option value="material_informatica">Material de Informática</option>
                            <option value="material_limpeza">Material de Limpeza</option>
                            <option value="material_eletrico">Material Elétrico</option>
                            <option value="material_producao">Material Produção</option>
                            <option value="outro">Outro</option>
                            <option value="prestacao_servico">Prestação de Serviço</option>
                        </select>
                    </div>

                    {{-- Tipo de Utilização --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="tipo_utilizacao">Tipo de Utilização</label>
                        <select name="tipo_utilizacao" id="tipo_utilizacao" class="select" required>
                         <option value="">Escolha uma opção</option>
                            <option value="industrializacao">INDUSTRIALIZAÇÃO</option>
                            <option value="uso_consumo">USO E CONSUMO</option>
                            <option value="imobilizado">IMOBILIZADO</option>
                        </select>
                    </div>

                {{-- Marca(s) --}}
                <div class="flex flex-col">
                    <label class="label font-medium" for="descricao">Item</label>
                    <input type="text" name="descricao" id="descricao" class="input" placeholder="Nome do Item..." required>
                </div>

                {{-- Marca(s) --}}
                <div class="flex flex-col">
                    <label class="label font-medium" for="marcas">Marca(s)</label>
                    <input type="text" name="marcas" id="marcas" class="input" placeholder="Digite aqui..." required>
                </div>
    
                {{-- Descrição Detalhada do Item --}}
                <div class="flex flex-col">
                    <label class="label label-required font-medium" for="descricao_detalhada">Descrição Detalhada do Item</label>
                   <input type="text" name="descricao_detalhada" id="descricao_detalhada" class="input" placeholder="Digite aqui..." required>
                </div>

                {{-- Link do site para compra/exemplo --}}
                <div class="flex flex-col">
                    <label class="label font-medium" for="link_exemplo">* Link do site para compra/exemplo</label>
                    <input type="url" name="link_exemplo" id="link_exemplo" class="input" placeholder="Digite aqui..." required>
                </div>

                {{-- Imagem do Item --}}
                <div class="flex flex-col">
                    <label class="label font-medium" for="imagem">Imagem do Item</label>
                    <input type="file" name="imagem" id="imagem" class="input" accept="image/*">
                </div>
            </section>


            {{-- Botão de Submit alinhado à direita --}}
            </div>
                <div class="flex justify-center">
                <button type="submit" class="btn btn-primary">
                Adicionar
                </button>
        </form>
    </div>
</x-app-layout>