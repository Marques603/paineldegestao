<x-app-layout>
  <!-- Título da Página -->
  <x-page-title page="Lista de Cargos" pageUrl="{{ route('position.index') }}" header="{{ isset($position) ? 'Editar Cargo' : 'Criar Cargo' }}" />

  <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
      <!-- Preview fixo à esquerda -->
      <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
          <div class="card">
              <div class="card-body flex flex-col items-center">
                  <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                      <i data-feather="user-check" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                  </div>
                  <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Cargo</h2>
              </div>
          </div>
      </section>

      <!-- Formulário -->
      <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
          <div class="card">
              <div class="card-body">
                  <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Detalhes do Cargo</h2>
                  <p class="mb-4 text-sm font-normal text-slate-400">Preencha as informações do cargo</p>

                  <form method="POST" action="{{ isset($position) ? route('position.update', $position) : route('position.store') }}" class="flex flex-col gap-6">
                      @csrf
                      @if(isset($position)) @method('PUT') @endif

                      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                          <!-- Nome -->
                          <label class="label">
                              <span class="block mb-1">Nome</span>
                              <input type="text" name="name" class="input @error('name') border-red-500 @enderror"
                                     value="{{ old('name', $position->name ?? '') }}" />
                              @error('name')
                                  <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                              @enderror
                          </label>

                          <!-- Descrição -->
                          <label class="label">
                              <span class="block mb-1">Descrição</span>
                              <input type="text" name="description" class="input @error('description') border-red-500 @enderror"
                                     value="{{ old('description', $position->description ?? '') }}" />
                              @error('description')
                                  <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                              @enderror
                          </label>
                      </div>

                      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                          <!-- Setor -->
                          <label class="label">
                              <span class="block mb-1">Setor</span>
                              <select name="sector_id" class="input @error('sector_id') border-red-500 @enderror">
                                  <option value="">Selecione um setor</option>
                                  @foreach($sectors as $sector)
                                      <option value="{{ $sector->id }}"
                                          {{ old('sector_id', $position->sector_id ?? '') == $sector->id ? 'selected' : '' }}>
                                          {{ $sector->name }}
                                      </option>
                                  @endforeach
                              </select>
                              @error('sector_id')
                                  <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                              @enderror
                          </label>

                          <!-- Usuário Responsável -->
                          <label class="label">
                              <span class="block mb-1">Usuário (se ocupado)</span>
                              <select name="user_id" class="input @error('user_id') border-red-500 @enderror">
                                  <option value="">Nenhum</option>
                                  @foreach($users as $user)
                                      <option value="{{ $user->id }}"
                                          {{ old('user_id', $position->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                          {{ $user->name }}
                                      </option>
                                  @endforeach
                              </select>
                              @error('user_id')
                                  <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                              @enderror
                          </label>
                      </div>

                      <!-- Status -->
                      <label class="label">
                          <span class="block mb-1">Status</span>
                          <select name="status" class="input @error('status') border-red-500 @enderror">
                              <option value="0" {{ old('status', $position->status ?? '') == '0' ? 'selected' : '' }}>Inativa</option>
                              <option value="1" {{ old('status', $position->status ?? '') == '1' ? 'selected' : '' }}>Ativa</option>
                              <option value="3" {{ old('status', $position->status ?? '') == '3' ? 'selected' : '' }}>Ausente</option>
                              <option value="4" {{ old('status', $position->status ?? '') == '4' ? 'selected' : '' }}>Ocupada</option>
                          </select>
                          @error('status')
                              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                          @enderror
                      </label>

                      <!-- Botões -->
                      <div class="flex items-center justify-end gap-4">
                          <a href="{{ route('position.index') }}"
                             class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                              Cancelar
                          </a>
                          <button type="submit" class="btn btn-primary">
                              {{ isset($position) ? 'Atualizar' : 'Adicionar' }}
                          </button>
                      </div>
                  </form>
              </div>
          </div>
      </section>
  </div>
</x-app-layout>
