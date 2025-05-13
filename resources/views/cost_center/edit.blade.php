<x-app-layout>
    <!-- Título da Página -->
    <x-page-title 
        page="Editar Centro de Custo" 
        pageUrl="{{ route('cost_center.index') }}" 
        header="Editar Centro de Custo" 
    />

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Preview fixo à esquerda -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                        <i data-feather="briefcase" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Centro de Custo</h2>
                </div>
            </div>
        </section>

        <!-- Formulário -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Detalhes do Centro de Custo</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Atualize as informações do centro de custo</p>

                    <form method="POST" action="{{ route('cost_center.update', $costCenter) }}" class="flex flex-col gap-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nome do Centro de Custo -->
                            <label class="label">
                                <span class="block mb-1">Nome do Centro de Custo</span>
                                <input type="text" name="name" class="input @error('name') border-red-500 @enderror"
                                    value="{{ old('name', $costCenter->name) }}" />
                                @error('name')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>

                            <!-- Código -->
                            <label class="label">
                                <span class="block mb-1">Código do Centro de Custo</span>
                                <input type="text" name="code" class="input @error('code') border-red-500 @enderror"
                                    value="{{ old('code', $costCenter->code) }}" />
                                @error('code')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Status -->
                            <label class="label">
                                <span class="block mb-1">Status</span>
                                <select name="status" class="input @error('status') border-red-500 @enderror">
                                    <option value="1" {{ old('status', $costCenter->status) == 1 ? 'selected' : '' }}>Ativo</option>
                                    <option value="0" {{ old('status', $costCenter->status) == 0 ? 'selected' : '' }}>Inativo</option>
                                </select>
                                @error('status')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <!-- Setores Vinculados -->
                        <div>
                            <label class="label">
                                <span class="block mb-1">Setores Vinculados</span>
                                <select name="sectors[]" multiple class="input @error('sectors') border-red-500 @enderror">
                                    @foreach($sectors as $sector)
                                        <option value="{{ $sector->id }}"
                                            {{ $costCenter->sectors->contains($sector->id) ? 'selected' : '' }}>
                                            {{ $sector->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sectors')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <!-- Botões -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('cost_center.index') }}"
                                class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
