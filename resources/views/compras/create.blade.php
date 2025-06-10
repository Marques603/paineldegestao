<x-app-layout>
    <x-page-title page="Compras" header="Nova Requisição" />

    <div class="max-w-5xl mx-auto p-4 space-y-6">
        {{-- Instruções de Preenchimento --}}
        <section class="rounded-lg bg-white p-6 shadow-sm dark:bg-slate-800">
            <h3 class="text-xl font-semibold text-slate-700 dark:text-slate-200 mb-4">
                Orientações de Preenchimento
            </h3>

            <div class="prose prose-sm prose-slate dark:prose-invert text-sm">
                <p><strong>O que precisa ser comprado?</strong></p>
                <p>Ser claro e objetivo, com informações que possamos identificar o que precisa ser orçado, exemplo:</p>
                <ul>
                    <li>Código Inusittá (quando existir)</li>
                    <li>Descrição produto com código/cor/padrão (dados que identifique o produto)</li>
                    <li>Necessidade (Prioridade)</li>
                </ul>
                <p><strong>Exemplo:</strong></p>
                <pre class="bg-slate-100 p-2 rounded text-sm dark:bg-slate-700">
                ITEM 994467
                Fresa haste 12x28 H12 Z3
                (ALTA PRIORIDADE)
                </pre>
                <p><strong>Exemplo:</strong></p>
                <pre class="bg-slate-100 p-2 rounded text-sm dark:bg-slate-700">
                ITEM 994580
                Ventilador coluna 40 cm
                (MÉDIA PRIORIDADE)
                </pre>
                <p>
                    Todos os campos devem ser preenchidos, precisam ser tratados de forma que instrua o compras sobre sua necessidade.
                    Sua referência de preço para aprovação da diretoria precisa ser coerente com sua solicitação, evitem pesquisas em sites chineses,
                    calcule o frete quando são produtos de compra on-line.
                </p>
                <p><strong>Especificação técnica do produto ou serviço:</strong> descreva todos os detalhes existentes e necessários para a condução dos orçamentos, exemplos comuns:</p>
                <ul>
                    <li>Códigos e descrições que constam nas peças, código e descrição da máquina que está essa peça.</li>
                    <li>Local onde será utilizado o produto solicitado.</li>
                    <li>Voltagem do produto.</li>
                    <li>Produtos específicos que tenham que ter regulamentação, certificados ou algo do gênero, especifique quais precisa ter.</li>
                    <li>Fotos do produto que mostre suas características.</li>
                    <li>Quando solicitar um serviço especifique o que precisa ser realizado de forma clara.</li>
                </ul>
                <p>
                    Coloque a quantidade correta que pretende, e calcule o valor total desta solicitação.  
                    Acrescente sempre uma segunda opção de produto.
                </p>
                <p>
                    <strong>OBS:</strong> CASO FALTE INFORMAÇÕES PARA A BOA CONDUÇÃO DOS ORÇAMENTOS, AVISAREMOS POR E-MAIL PARA QUE O SOLICITANTE REVISE SUA SOLICITAÇÃO OU REFAÇA A MESMA.
                </p>
            </div>
        </section>

        {{-- Formulário de Requisição --}}
        <form action="{{ route('compras.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf




            
            {{-- Seção de Detalhes da Requisição --}}
            <section class="rounded-lg bg-white p-6 shadow-sm dark:bg-slate-800 space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                        {{-- Tipo de Material --}}
    <div class="flex flex-col">
        <label class="label font-medium" for="tipo_material">* Tipo de Material</label>
        <select name="tipo_material" id="tipo_material" class="select" required>
            <option value="">Escolha uma opção</option>
            <option value="industrializacao">Industrialização</option>
            <option value="uso_consumo">Uso e Consumo</option>
            <option value="imobilizado">Imobilizado</option>
        </select>
    </div>

    {{-- Tipo de Utilização --}}
    <div class="flex flex-col">
        <label class="label font-medium" for="tipo_utilizacao">* Tipo de Utilização</label>
        <select name="tipo_utilizacao" id="tipo_utilizacao" class="select" required>
            <option value="">Escolha uma opção</option>
            <option value="producao">Produção</option>
            <option value="apoio_administrativo">Apoio Administrativo</option>
            <option value="outros">Outros</option>
        </select>
    </div>

    {{-- Descrição --}}
    <div class="flex flex-col">
        <label class="label font-medium" for="descricao">* Descrição do Item</label>
        <input type="text" name="descricao" id="descricao" class="input" required>
    </div>

    {{-- Descrição Detalhada --}}
    <div class="flex flex-col">
        <label class="label font-medium" for="descricao_detalhada">Descrição Detalhada</label>
        <textarea name="descricao_detalhada" id="descricao_detalhada" class="textarea" rows="3"></textarea>
    </div>

    {{-- Link de Exemplo --}}
    <div class="flex flex-col">
        <label class="label font-medium" for="link_exemplo">Link de Exemplo</label>
        <input type="url" name="link_exemplo" id="link_exemplo" class="input">
    </div>

    {{-- Imagem do Item --}}
    <div class="flex flex-col">
        <label class="label font-medium" for="imagem">Imagem (opcional)</label>
        <input type="file" name="imagem" id="imagem" class="input">
    </div>

                    {{-- Data de Necessidade --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="data_necessidade">* Data de Necessidade</label>
                        <input type="date" name="data_necessidade" id="data_necessidade" class="input" required>
                        <p class="help-text mt-1 text-xs text-slate-500">Para qual data você precisa receber o produto? Prazo mínimo de entrega de resposta 2 dias úteis.</p>
                    </div>

                    {{-- Necessário Realizar Orçamento? --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="realizar_orcamento">* Necessário Realizar Orçamento?</label>
                        <select name="realizar_orcamento" id="realizar_orcamento" class="select" required>
                            <option value="">Escolha uma opção</option>
                            <option value="sim">SIM</option>
                            <option value="nao">NÃO</option>
                        </select>
                    </div>
                </div>

                    {{-- Valor Previsto --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="valor_previsto">* Valor Previsto (R$)</label>
                        <input type="text" name="valor_previsto" id="valor_previsto" class="input" placeholder="Digite aqui..." required>
                        <p class="help-text mt-1 text-xs text-slate-500">Informe o valor aproximado para aprovação da diretoria.</p>
                    </div>
                    
                    {{-- Quantidade --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="quantidade">* Quantidade</label>
                        <input type="number" name="quantidade" id="quantidade" class="input" placeholder="Digite aqui..." required>
                    </div>

                    {{-- Justificativa para Aquisição --}}
                    <div class="flex flex-col">
                        <label class="label label-required font-medium" for="justificativa">* Justificativa para Aquisição</label>
                        <textarea name="justificativa" id="justificativa" rows="3" class="textarea" placeholder="Digite aqui..." required></textarea>
                    </div>

                    {{-- Sugestão de Fornecedor --}}
                    <div class="flex flex-col">
                        <label class="label font-medium" for="sugestao_fornecedor">Sugestão de Fornecedor</label>
                        <input type="text" name="sugestao_fornecedor" id="sugestao_fornecedor" class="input" placeholder="Informar nome, e-mail, telefone, etc.">
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