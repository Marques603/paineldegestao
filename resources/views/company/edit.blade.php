<!-- resources/views/company/edit.blade.php -->
<x-app-layout>
    <x-page-title page="Editar Empresa" pageUrl="{{ route('company.index') }}" header="Editar Empresa" />

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Preview fixo à esquerda -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                        <i data-feather="briefcase" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Empresa</h2>
                </div>
            </div>
        </section>

        <!-- Formulário -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Detalhes da Empresa</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Preencha as informações da empresa</p>

                    <!-- Formulário de Edição -->
                    <form method="POST" action="{{ route('company.update', $company->id) }}" class="flex flex-col gap-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nome -->
                            <label class="label">
                                <span class="block mb-1">Nome</span>
                                <input type="text" name="name" class="input @error('name') border-red-500 @enderror" value="{{ old('name', $company->name) }}" />
                                @error('name')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>

                            <!-- Descrição -->
                            <label class="label">
                                <span class="block mb-1">Descrição</span>
                                <input type="text" name="description" class="input @error('description') border-red-500 @enderror" value="{{ old('description', $company->description) }}" />
                                @error('description')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- CNPJ -->
                            <label class="label">
                                <span class="block mb-1">CNPJ</span>
                                <input type="text" name="cnpj" class="input @error('cnpj') border-red-500 @enderror" value="{{ old('cnpj', $company->cnpj) }}" />
                                @error('cnpj')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>

                            <!-- Responsável -->
                            <label class="label">
                                <span class="block mb-1">Responsável</span>
                                <input type="text" name="responsavel" class="input @error('responsavel') border-red-500 @enderror" value="{{ old('responsavel', $company->responsavel) }}" />
                                @error('responsavel')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <!-- Status -->
                        <label class="label">
                            <span class="block mb-1">Status</span>
                            <select name="status" class="input @error('status') border-red-500 @enderror">
                                <option value="1" {{ old('status', $company->status) == 1 ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ old('status', $company->status) == 0 ? 'selected' : '' }}>Inativo</option>
                            </select>
                            @error('status')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </label>

                        <!-- Botões -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('company.index') }}" class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">Atualizar Empresa</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
