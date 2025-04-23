<x-app-layout>
    <x-page-title page="Lista de Menus" pageUrl="{{ route('menus.index') }}" header="Editar Submenu" />

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Coluna Esquerda -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                        <i id="menuPreviewIcon" data-feather="{{ $submenu->icone ?? 'menu' }}" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Ícone do Submenu</h2>
                </div>
            </div>
        </section>

        <!-- Coluna Direita -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">

            <!-- Formulário: Editar Submenu -->
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Editar Submenu</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Atualize as informações do submenu</p>

                    <form method="POST" action="{{ route('submenus.update', $submenu) }}" class="flex flex-col gap-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <label class="label">
                                <span class="block mb-1">Nome do Submenu</span>
                                <input type="text" name="nome" class="input @error('nome') border-red-500 @enderror"
                                    value="{{ old('nome', $submenu->nome) }}" />
                                @error('nome')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>

                            <label class="label">
                                <span class="block mb-1">Descrição</span>
                                <input type="text" name="descricao" class="input @error('descricao') border-red-500 @enderror"
                                    value="{{ old('descricao', $submenu->descricao) }}" />
                                @error('descricao')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                            <label class="label">
                                <span class="block mb-1">Rota</span>
                                <input type="text" name="rota" class="input @error('rota') border-red-500 @enderror"
                                    value="{{ old('rota', $submenu->rota) }}" />
                                @error('rota')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <!-- Enviar os menus e ativo como hidden -->
                        @foreach($submenu->menus as $menu)
                            <input type="hidden" name="menus[]" value="{{ $menu->id }}">
                        @endforeach
                        <input type="hidden" name="ativo" value="{{ $submenu->ativo }}">

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('submenus.index') }}" class="btn border text-slate-500 dark:border-slate-700 dark:text-slate-300">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar Submenu</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulário: Ativar Submenu -->
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Ativar Submenu</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Defina se este submenu estará ativo no sistema.</p>

                    <form method="POST" action="{{ route('submenus.update', $submenu) }}" class="flex flex-col gap-6">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="nome" value="{{ old('nome', $submenu->nome) }}">
                        <input type="hidden" name="descricao" value="{{ old('descricao', $submenu->descricao) }}">
                        <input type="hidden" name="rota" value="{{ old('rota', $submenu->rota) }}">
                        @foreach($submenu->menus as $menu)
                            <input type="hidden" name="menus[]" value="{{ $menu->id }}">
                        @endforeach

                        <label for="ativo" class="toggle my-2 flex items-center justify-between">
                            <div class="label">
                                <p class="text-sm font-normal text-slate-400">Ativar este submenu</p>
                            </div>
                            <div class="relative">
                                <input
                                    class="toggle-input peer sr-only"
                                    id="ativo"
                                    type="checkbox"
                                    name="ativo"
                                    value="1"
                                    {{ old('ativo', $submenu->ativo ?? 1) == 1 ? 'checked' : '' }}
                                >
                                <div class="toggle-body"></div>
                            </div>
                        </label>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('submenus.index') }}" class="btn border text-slate-500 dark:border-slate-700 dark:text-slate-300">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar Submenu</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulário: Ativar Menus -->
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Ativar Menus</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Defina quais menus estarão ativos nesse submenu.</p>

                    <form method="POST" action="{{ route('submenus.update', $submenu) }}" class="flex flex-col gap-6">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="nome" value="{{ old('nome', $submenu->nome) }}">
                        <input type="hidden" name="descricao" value="{{ old('descricao', $submenu->descricao) }}">
                        <input type="hidden" name="rota" value="{{ old('rota', $submenu->rota) }}">
                        <input type="hidden" name="ativo" value="{{ $submenu->ativo }}">

                        <div class="flex flex-wrap gap-4">
                            @foreach($menus as $menu)
                                @php
                                    $id = 'menu_' . $menu->id;
                                    $isChecked = $submenu->menus->contains($menu->id);
                                @endphp

                                <div class="flex items-center gap-1.5">
                                    <input
                                        id="{{ $id }}"
                                        class="checkbox"
                                        type="checkbox"
                                        name="menus[]"
                                        value="{{ $menu->id }}"
                                        {{ $isChecked ? 'checked' : '' }}
                                    >
                                    <label for="{{ $id }}" class="label">{{ $menu->nome }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('submenus.index') }}" class="btn border text-slate-500 dark:border-slate-700 dark:text-slate-300">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar Submenu</button>
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </div>
</x-app-layout>
