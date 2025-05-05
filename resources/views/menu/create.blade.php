<x-app-layout>
  <!-- Page Title Starts -->
  <x-page-title page="Lista de Menus" pageUrl="{{ route('menus.index') }}" header="{{ isset($menu) ? 'Editar Menu' : 'Criar Menu' }}" />
  <!-- Page Title Ends -->

  

  <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
      <!-- Ícone de preview à esquerda -->
      <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
          <div class="card">
              <div class="card-body flex flex-col items-center">
                  <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                      <i id="menuPreviewIcon" data-feather="{{ $menu->icone ?? 'menu' }}" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                  </div>
                  <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Ícone do Menu</h2>
              </div>
          </div>


                          <!-- Modal de seleção de ícones -->
      <!-- Modal de seleção de ícones -->
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
                  <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Detalhes do Menu</h2>
                  <p class="mb-4 text-sm font-normal text-slate-400">Preencha as informações do menu</p>

                  <form method="POST" action="{{ isset($menu) ? route('menus.update', $menu) : route('menus.store') }}" class="flex flex-col gap-6">
                      @csrf
                      @if(isset($menu)) @method('PUT') @endif

                      <!-- Primeira linha: name | Ícone -->
<!-- Primeira linha: name | Descrição -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <!-- name -->
    <label class="label">
        <span class="block mb-1">Nome do Menu</span>
        <input type="text" name="name" class="input @error('name') border-red-500 @enderror" 
               value="{{ old('name', $menu->name ?? '') }}" />
        @error('name')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </label>

    <!-- Descrição -->
    <label class="label">
        <span class="block mb-1">Descrição</span>
        <input type="text" name="descricao" class="input @error('descricao') border-red-500 @enderror" 
               value="{{ old('descricao', $menu->descricao ?? '') }}" />
        @error('descricao')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </label>
</div>

<!-- Segunda linha: Ícone | Rota -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
    <!-- Ícone -->
    <label class="label">
        <span class="block mb-1 text-slate-700 dark:text-slate-300 font-medium">
            Ícone do Menu 
            <span id="openIconPicker" class="ml-1 cursor-pointer text-blue-600 hover:underline">
                (Feather Icon)
            </span>
        </span>
        <input type="text" name="icone" id="iconeInput" readonly
               class="input @error('icone') border-red-500 @enderror"
               value="{{ old('icone', $menu->icone ?? '') }}"
               placeholder="Clique no texto acima para escolher..." />
        @error('icone')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </label>

    <!-- Rota -->
    <label class="label">
        <span class="block mb-1">Rota</span>
        <input type="text" name="rota" class="input @error('rota') border-red-500 @enderror" 
               value="{{ old('rota', $menu->rota ?? '') }}" />
        @error('rota')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror

                        </label>
                    </div>
                    
                    

                      <!-- Botões -->
                      <div class="flex items-center justify-end gap-4">
                          <a href="{{ route('menus.index') }}"
                             class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                              Cancelar
                          </a>
                          <button type="submit" class="btn btn-primary">
                              Adicionar
                          </button>
                      </div>
                  
                  
                    </form>

              </div>
          </div>

          
      </section>
  </div>
</x-app-layout>
