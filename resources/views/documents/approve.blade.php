<x-app-layout>
    <x-page-title page="Aprovar Documento" pageUrl="{{ route('documents.index') }}" header="Aprovar Documento" />

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Preview -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                        <i data-feather="file-check" class="w-10 h-10 text-slate-600 dark:text-slate-200"></i>
                    </div>
                    <h2 class="mt-4 text-[16px] font-medium text-center text-slate-700 dark:text-slate-200">Revisar Documento</h2>
                </div>
            </div>
        </section>

        <!-- Formulário -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Detalhes do Documento</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Revise as informações antes de confirmar a aprovação</p>

                    <form method="POST" action="{{ route('documents.approve', $document->id) }}" class="flex flex-col gap-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block mb-1 text-sm font-medium text-slate-700 dark:text-slate-300">Código</label>
                                <input type="text" class="input bg-slate-100 dark:bg-slate-800" value="{{ $document->code }}" disabled>
                            </div>

                            <div>
                                <label class="block mb-1 text-sm font-medium text-slate-700 dark:text-slate-300">Revisão</label>
                                <input type="text" class="input bg-slate-100 dark:bg-slate-800" value="{{ $document->revision }}" disabled>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-1 text-sm font-medium text-slate-700 dark:text-slate-300">Descrição</label>
                            <textarea class="input bg-slate-100 dark:bg-slate-800" disabled>{{ $document->description }}</textarea>
                        </div>

                        <div>
                            <label class="block mb-1 text-sm font-medium text-slate-700 dark:text-slate-300">Arquivo</label>
                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                               class="text-blue-600 hover:underline dark:text-blue-400">
                                Visualizar Documento
                            </a>
                        </div>

                        <!-- Botões -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('documents.index') }}"
                               class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Aprovar Documento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
