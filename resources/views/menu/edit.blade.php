<x-app-layout>
    <x-page-title page="Lista de Menus" pageUrl="{{ route('menus.index') }}" header="Editar Menu" />
  
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
      <!-- Left Section -->
      <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
        <div class="card">
          <div class="card-body flex flex-col items-center">
            <div class="relative my-2 h-24 w-24 rounded-full">
              <i data-feather="{{ old('icone', $menu->icone) }}" class="h-full w-full text-4xl"></i>
            </div>
            <h2 class="text-[16px] font-medium text-slate-700 dark:text-slate-200">Ícone do Menu</h2>
          </div>
        </div>
      </section>
  
      <!-- Right Section -->
      <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
        <div class="card">
          <div class="card-body">
            <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Editar Menu</h2>
            <p class="mb-4 text-sm font-normal text-slate-400">Atualize as informações do menu</p>
  
            <form method="POST" action="{{ route('menus.update', $menu) }}" class="flex flex-col gap-5">
              @csrf
              @method('PUT')
  
              <!-- Nome -->
              <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <label class="label">
                  <span class="my-1 block">Nome do Menu</span>
                  <input type="text" name="nome" class="input @error('nome') border-red-500 @enderror"
                         value="{{ old('nome', $menu->nome) }}" />
                  @error('nome')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                  @enderror
                </label>
  
                <!-- Ícone -->
                <label class="label">
                  <span class="my-1 block">Ícone (Feather Icon)</span>
                  <input type="text" name="icone" class="input @error('icone') border-red-500 @enderror"
                         value="{{ old('icone', $menu->icone) }}" placeholder="ex: users, home, etc." />
                  @error('icone')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                  @enderror
                </label>
              </div>
  
              <!-- Rota -->
              <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <label class="label">
                  <span class="my-1 block">Rota do Menu</span>
                  <input type="text" name="rota" class="input @error('rota') border-red-500 @enderror"
                         value="{{ old('rota', $menu->rota) }}" placeholder="ex: users.index" />
                  @error('rota')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                  @enderror
                </label>
              </div>
  
              <!-- Descrição -->
              <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <label class="label">
                  <span class="my-1 block">Descrição</span>
                  <textarea name="descricao" class="input @error('descricao') border-red-500 @enderror"
                            placeholder="Descrição do menu...">{{ old('descricao', $menu->descricao) }}</textarea>
                  @error('descricao')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                  @enderror
                </label>
              </div>
  
              <!-- Ativo -->
              <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <label class="flex items-center gap-2">
                  <input type="checkbox" name="ativo" value="1"
                         class="checkbox"
                         {{ old('ativo', $menu->ativo) ? 'checked' : '' }}>
                  <span>Menu Ativo</span>
                </label>
              </div>
  
              <!-- Botões -->
              <div class="flex items-center justify-end gap-4">
                <a href="{{ route('menus.index') }}"
                   class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                  Cancelar
                </a>
                <button type="submit" class="btn btn-primary">Atualizar Menu</button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
  </x-app-layout>
  