<x-app-layout>
    <!-- Page Title Starts -->
    <x-page-title page="Lista de Menus" pageUrl="{{ route('menus.index') }}" header="{{ isset($menu) ? 'Editar Menu' : 'Criar Menu' }}" />
    <!-- Page Title Ends -->

    <!-- Menu Form Start -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Left Section Start -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <!-- Menu Icon -->
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative my-2 h-24 w-24 rounded-full">
                        <i data-feather="{{ isset($menu) ? $menu->icone : 'menu' }}" class="h-full w-full text-4xl"></i>
                    </div>
                    <h2 class="text-[16px] font-medium text-slate-700 dark:text-slate-200">Ícone do Menu</h2>
                </div>
            </div>
        </section>
        <!-- Left Section End -->

        <!-- Right Section Start -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Detalhes do Menu</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Preencha as informações do menu</p>

                    <form method="POST" action="{{ isset($menu) ? route('menus.update', $menu) : route('menus.store') }}" class="flex flex-col gap-5">
                        @csrf
                        @if(isset($menu)) @method('PUT') @endif

                        <!-- Menu Name -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="label">
                                <span class="my-1 block">Nome do Menu</span>
                                <input type="text" name="nome" class="input @error('nome') border-red-500 @enderror" 
                                       value="{{ old('nome', isset($menu) ? $menu->nome : '') }}" />
                                @error('nome')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>

                            <!-- Menu Icon -->
                            <label class="label">
                                <span class="my-1 block">Ícone do Menu (Feather Icon)</span>
                                <input type="text" name="icone" class="input @error('icone') border-red-500 @enderror"
                                       value="{{ old('icone', isset($menu) ? $menu->icone : '') }}" placeholder="ex: users, home, etc." />
                                @error('icone')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <!-- Menu Route -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="label">
                                <span class="my-1 block">Rota do Menu</span>
                                <input type="text" name="rota" class="input @error('rota') border-red-500 @enderror"
                                       value="{{ old('rota', isset($menu) ? $menu->rota : '') }}" placeholder="ex: users.index" />
                                @error('rota')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <!-- Menu Description -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="label">
                                <span class="my-1 block">Descrição do Menu</span>
                                <textarea name="descricao" class="input @error('descricao') border-red-500 @enderror"
                                          placeholder="Descrição do menu...">{{ old('descricao', isset($menu) ? $menu->descricao : '') }}</textarea>
                                @error('descricao')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <!-- Menu Status (Active/Inactive) -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="label">
                                <span class="my-1 block">Status do Menu</span>
                                <select name="status" class="input @error('status') border-red-500 @enderror">
                                    <option value="1" {{ (old('status', isset($menu) ? $menu->status : 1) == 1) ? 'selected' : '' }}>Ativo</option>
                                    <option value="2" {{ (old('status', isset($menu) ? $menu->status : 2) == 2) ? 'selected' : '' }}>Inativo</option>
                                </select>
                                @error('status')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('menus.index') }}"
                               class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">{{ isset($menu) ? 'Atualizar' : 'Criar' }} Menu</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Right Section End -->
    </div>
    <!-- Menu Form End -->

</x-app-layout>
