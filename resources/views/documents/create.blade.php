<x-app-layout>
    <x-page-title page="Criar Documento" pageUrl="{{ route('documents.index') }}" header="Novo Documento" />

    @if(session('success'))
        <div id="toast" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded shadow-lg z-50" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Preview -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                        <i data-feather="file-plus" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Novo Documento</h2>
                    <p class="text-sm text-slate-400 mt-2 text-center">Envie e registre um novo arquivo</p>
                </div>
            </div>
        </section>

        <!-- Formulário de Criação -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <!-- Código -->
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                        @csrf
                        <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Novo Documento</h2>
                        <p class="mb-4 text-sm text-slate-400">Preencha os dados do novo documento</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <label class="label">
                                <span class="block mb-1">Código</span>
                                <input type="text" name="code" class="input" value="{{ old('code') }}" required />
                            </label>
                            <label class="label">
                                <span class="block mb-1">Descrição</span>
                                <input type="text" name="description" class="input" value="{{ old('description') }}" />
                            </label>
                            <label class="label">
                                <span class="block mb-1">Arquivo</span>
                                <input type="file" name="file" class="input" required />
                            </label>
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('documents.index') }}"
                               class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                               Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">Criar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Macros -->
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Macros Vinculados</h2>
                    <p class="mb-4 text-sm text-slate-400">Vincule macros ao documento</p>

                    <form method="POST" action="{{ route('documents.store') }}">
                        @csrf
                        <div class="mb-4">
                            <span class="block mb-1 text-sm text-slate-600 dark:text-slate-300">Macros</span>
                            <select name="macros[]" multiple
                                class="tom-select w-full min-h-[2.5rem] py-2 @error('macros') border-red-500 @enderror">
                                @foreach($macros as $macro)
                                    <option value="{{ $macro->id }}" @selected(in_array($macro->id, old('macros', [])))>
                                        {{ $macro->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('macros')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>

            <!-- Setores -->
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Setores Vinculados</h2>
                    <p class="mb-4 text-sm text-slate-400">Vincule setores ao documento</p>

                    <form method="POST" action="{{ route('documents.store') }}">
                        @csrf
                        <div class="mb-4">
                            <span class="block mb-1 text-sm text-slate-600 dark:text-slate-300">Setores</span>
                            <select name="sectors[]" multiple
                                class="tom-select w-full min-h-[2.5rem] py-2 @error('sectors') border-red-500 @enderror">
                                @foreach($sectors as $sector)
                                    <option value="{{ $sector->id }}" @selected(in_array($sector->id, old('sectors', [])))>
                                        {{ $sector->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sectors')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </div>
</x-app-layout>
