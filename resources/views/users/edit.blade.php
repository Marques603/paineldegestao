<x-app-layout>
    <x-page-title page="Lista de Usuários" pageUrl="{{ route('users.index') }}" header="Editar Usuário" />

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Coluna Esquerda - Avatar -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
            <div class="card">
                <div class="card-body flex flex-col items-center">
                    <div class="relative my-2 h-24 w-24 rounded-full">
                        <img src="{{ asset('images/avatar11.png') }}"
                             alt="avatar-img" id="user-image-preview"
                             class="h-full w-full rounded-full object-cover" />
                        <label for="upload-avatar"
                               class="absolute bottom-0 right-0 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-slate-50 p-2 dark:bg-slate-900">
                            <span class="text-slate-600 dark:text-slate-300">
                                <i class="w-full" data-feather="camera"></i>
                            </span>
                            <input type="file" name="avatar" accept="image/*"
                                   class="hidden" id="upload-avatar" />
                        </label>
                    </div>
                    <h2 class="text-[16px] font-medium text-slate-700 dark:text-slate-200">Upload Imagem</h2>
                </div>
            </div>
        </section>

        <!-- Coluna Direita - Formulários -->
        <section class="col-span-1 flex w-full flex-1 flex-col gap-6 lg:col-span-3 lg:w-auto">
            <!-- Detalhes Pessoais -->
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Detalhes Pessoais</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Atualize as informações do usuário</p>

                    <form method="POST"
                          action="{{ route('users.update.profile', $user->id) }}"
                          enctype="multipart/form-data"
                          class="flex flex-col gap-5">
                        @csrf
                        @method('PUT')

                        <!-- Nome e Email -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="label">
                                <span class="my-1 block">Nome</span>
                                <input type="text" name="name" class="input @error('name') border-red-500 @enderror"
                                       value="{{ old('name', $user->name) }}" />
                                @error('name')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>

                            <label class="label">
                                <span class="my-1 block">Email</span>
                                <input type="email" name="email" class="input @error('email') border-red-500 @enderror"
                                       value="{{ old('email', $user->email) }}" />
                                @error('email')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <!-- Senha -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="label">
                                <span class="my-1 block">Senha</span>
                                <input type="password" name="password" class="input @error('password') border-red-500 @enderror" />
                                @error('password')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </label>

                            <label class="label">
                                <span class="my-1 block">Confirmar Senha</span>
                                <input type="password" name="password_confirmation" class="input" />
                            </label>
                        </div>

                        <!-- Botões -->
                        <div class="flex items-center justify-end gap-4 mt-4">
                            <a href="{{ route('users.index') }}"
                               class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulário para editar o status -->
<div class="card">
    <div class="card-body">
        <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Editar Status do Usuário</h2>
        <p class="mb-4 text-sm font-normal text-slate-400">Atualize o status do usuário.</p>

        <form method="POST" action="{{ route('users.update.status', $user->id) }}">
            @csrf
            @method('PUT')

            <!-- Status -->
<!-- Status -->
<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <label class="label">
        <span class="my-1 block">Status</span>
        <select name="status" class="input @error('status') border-red-500 @enderror">
            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Ativo</option>
            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inativo</option>
        </select>
        @error('status')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </label>
</div>

            <!-- Botões -->
            <div class="flex items-center justify-end gap-4 mt-4">
                <a href="{{ route('users.index') }}"
                   class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
</div>




            <!-- Vincular Setores -->
            <div class="card">
                <div class="card-body">
                    <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Vincular Setores</h2>
                    <p class="mb-4 text-sm font-normal text-slate-400">Selecione os setores ao qual o usuário pertence</p>

                    <form method="POST" action="{{ route('users.update.sector', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Setores -->
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach ($sector as $sector)
                                <div class="flex items-center gap-1.5">
                                    <input id="checkbox-{{ $sector->id }}" 
                                           class="checkbox checkbox-primary" 
                                           type="checkbox" 
                                           name="sector[]" 
                                           value="{{ $sector->id }}"
                                           {{ $user->sector->contains($sector->id) ? 'checked' : '' }} />
                                    <label for="checkbox-{{ $sector->id }}" class="label">
                                        {{ $sector->nome }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Botões -->
                        <div class="flex items-center justify-end gap-4 mt-4">
                            <a href="{{ route('users.index') }}"
                               class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulário para vincular empresas -->
<div class="card">
    <div class="card-body">
        <h2 class="text-[16px] font-semibold text-slate-700 dark:text-slate-300">Vincular Empresas</h2>
        <p class="mb-4 text-sm font-normal text-slate-400">Selecione as empresas ao qual o usuário pertence</p>

        <form method="POST" action="{{ route('users.update.company', $user->id) }}">
            @csrf
            @method('PUT')

            <!-- Exibição das empresas com checkboxes -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach ($company as $company)
                    <div class="flex items-center gap-1.5">
                        <input id="company-{{ $company->id }}" 
                               class="checkbox checkbox-primary" 
                               type="checkbox" 
                               name="company[]" 
                               value="{{ $company->id }}"
                               {{ $user->company->contains($company->id) ? 'checked' : '' }} />
                        <label for="company-{{ $company->id }}" class="label">
                            {{ $company->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            <!-- Botões de ação -->
            <div class="flex items-center justify-end gap-4 mt-4">
                <a href="{{ route('users.index') }}"
                   class="btn border border-slate-300 text-slate-500 dark:border-slate-700 dark:text-slate-300">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
</div>

        </section>
    </div>
</x-app-layout>
