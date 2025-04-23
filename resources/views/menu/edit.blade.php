<x-app-layout>
    <!-- Page Title Starts -->
    <x-page-title page="Lista de Menus" pageUrl="{{ route('menus.index') }}" header="Editar Menu" />
    <!-- Page Title Ends -->

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Coluna Esquerda -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <!-- Preview do Ícone -->
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                        <i id="menuPreviewIcon" data-feather="{{ $menu->icone ?? 'menu' }}" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Ícone do Menu</h2>
                </div>
            </div>

            <!-- Modal de Seleção de Ícones -->
            <div id="iconModal" class="mt-2 p-4 border rounded shadow-lg bg-white dark:bg-slate-800 hidden max-h-[300px] overflow-y-auto z-10">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-base font-semibold text-slate-700 dark:text-slate-100">Escolha um ícone</h2>
                    <button type="button" id="closeIconPicker" class="text-sm text-blue-500 hover:underline">Fechar</button>
                </div>
                <div class="grid grid-cols-6 gap-4">
                    @foreach ($featherIcons as $icon)
                        <button type="button" data-icon="{{ $icon }}"
                                class="icon-button flex items-center justify-center p-2 border rounded hover:bg-slate-100 dark:hover:bg-slate-700">
                            <i data-feather="{{ $icon }}"></i>
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Formulário -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Editar Menu</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Atualize as informações do menu</p>

                    <!-- Formulário de Editar Menu -->
                    <form method="POST" action="{{ route('menus.update', $menu) }}" class="flex flex-col gap-6">
                        @csrf
                        @method('PUT')

                        <!-- Linha 1: Nome e Descrição -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <label class="label">
                                <span class="block mb-1">Nome do Menu</span>
                                <input type="text" name="nome" class="input @error('nome') border-red-500 @enderror"
                                    value="{{ old('nome', $menu->nome) }}" />
                                @error('nome')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>

                            <label class="label">
                                <span class="block mb-1">Descrição</span>
                                <input type="text" name="descricao" class="input @error('descricao') border-red-500 @enderror"
                                    value="{{ old('descricao', $menu->descricao) }}" />
                                @error('descricao')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <!-- Linha 2: Ícone e Rota -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                            <label class="label">
                                <span class="block mb-1 text-slate-700 dark:text-slate-300 font-medium">
                                    Ícone do Menu
                                    <span id="openIconPicker" class="ml-1 cursor-pointer text-blue-600 hover:underline">
                                        (Feather Icon)
                                    </span>
                                </span>
                                <input type="text" name="icone" id="iconeInput" readonly
                                    class="input @error('icone') border-red-500 @enderror"
                                    value="{{ old('icone', $menu->icone) }}"
                                    placeholder="Clique no texto acima para escolher..." />
                                @error('icone')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>

                            <label class="label">
                                <span class="block mb-1">Rota</span>
                                <input type="text" name="rota" class="input @error('rota') border-red-500 @enderror"
                                    value="{{ old('rota', $menu->rota) }}" />
                                @error('rota')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <!-- Botões para Editar Menu -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('menus.index') }}"
                                class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Atualizar Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulário de Ativar Menu -->
       <!-- Formulário de Ativar Menu -->
<div class="card">
    <div class="card-body">
        <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Ativar Menu</h2>
        <p class="mb-4 text-sm font-normal text-slate-400">Defina se este menu estará ativo no sistema.</p>

        <form method="POST" action="{{ route('menus.update', $menu) }}" class="flex flex-col gap-6">
            @csrf
            @method('PUT')

            <!-- Campo Nome -->
            <input type="hidden" name="nome" value="{{ old('nome', $menu->nome) }}">

            <!-- Campo Descrição -->
            <input type="hidden" name="descricao" value="{{ old('descricao', $menu->descricao) }}">

            <label for="ativo" class="toggle my-2 flex items-center justify-between">
                <div class="label">
                    <p class="text-sm font-normal text-slate-400">Ativar este menu</p>
                </div>
                <div class="relative">
                    <input
                        class="toggle-input peer sr-only"
                        id="ativo"
                        type="checkbox"
                        name="ativo"
                        value="1"
                        {{ old('ativo', $menu->ativo ?? 1) == 1 ? 'checked' : '' }}
                    >
                    <div class="toggle-body"></div>
                </div>
            </label>
            <!-- Botões para Ativar Menu -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('menus.index') }}"
                    class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Atualizar Menu
                </button>
            </div>
        </form>
    </div>
</div>

        </section>
    </div>
</x-app-layout>
