<x-app-layout>
    <x-page-title page="Lista de Menus" pageUrl="{{ route('menus.index') }}" header="Editar Menu" />

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('menus.update', $menu) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nome" class="block text-sm font-medium text-gray-700">Nome do Menu</label>
                    <input type="text" name="nome" id="nome" class="input @error('nome') border-red-500 @enderror" value="{{ old('nome', $menu->nome) }}" required>
                    @error('nome')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="icone" class="block text-sm font-medium text-gray-700">Ícone do Menu (Feather Icon)</label>
                    <input type="text" name="icone" id="icone" class="input @error('icone') border-red-500 @enderror" value="{{ old('icone', $menu->icone) }}" required>
                    @error('icone')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="rota" class="block text-sm font-medium text-gray-700">Rota do Menu</label>
                    <input type="text" name="rota" id="rota" class="input @error('rota') border-red-500 @enderror" value="{{ old('rota', $menu->rota) }}" required>
                    @error('rota')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('menus.index') }}" class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">Atualizar Menu</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
