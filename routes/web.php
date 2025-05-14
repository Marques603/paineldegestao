<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MacroController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\CostCenterController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui registramos as rotas da aplicação que serão carregadas pelo
| RouteServiceProvider e ficam no grupo "web".
|
*/

// Rotas protegidas: somente usuários autenticados podem acessar.

   Route::middleware(['auth'])->group(function () {
   // Dashboard principal e demais views internas
   Route::view('/', 'dashboard.index')->name('dashboard'); 
   // Exibe o painel principal após o login (visão geral do sistema)
   // Rotas de usuários (CRUD)
   Route::get('/users', [UserController::class, 'index'])->name('users.index'); 
   // Lista todos os usuários cadastrados no sistema
   Route::get('/users/create', [UserController::class, 'create'])->name('users.create');   
   // Exibe o formulário para cadastrar um novo usuário
   Route::post('/users/create', [UserController::class, 'store'])->name('users.store');   
   // Processa os dados enviados pelo formulário e salva o novo usuário
   Route::get('/users/{user}', [UserController::class, 'edit'])->name('users.edit');
   // Exibe o formulário de edição para um usuário específico
   Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
   // Atualiza os dados de um usuário após edição
   Route::put('/users/{user}/update-profile', [UserController::class, 'updateProfile'])->name('users.update.profile');
   // Atualiza o perfil do usuário autenticado
   Route::put('/users/{user}/roles', [UserController::class, 'updateRoles'])->name('users.update.roles');
   // Atualiza os papéis associados a um usuário específico
   Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
   // Remove o usuário selecionado do banco de dados
   // Atualiza as empresas associadas a um usuário específico
   Route::put('users/{id}/status', [UserController::class, 'updateStatus'])->name('users.update.status');
   // Atualiza o status de um usuário específico (ativo/inativo)
   Route::put('/users/{user}/menus', [UserController::class, 'updateMenus'])->name('users.update.menus');
   // Atualiza os menus associados a um usuário específico
   Route::resource('position', PositionController::class);
   // Rotas de cargos (CRUD)
   Route::resource('menus', MenuController::class);
   // Rotas de menus (CRUD)
    Route::resource('macro', MacroController::class);
   // Rotas de macro (CRUD)
   Route::put('/macros/{macro}/status', [MacroController::class, 'updateStatus'])->name('macro.update.status');
   // Atualiza o status de uma macro específica (ativo/inativo)
   Route::get('macro/{id}/restore', [MacroController::class, 'restore'])->name('macro.restore');
   // Restaura uma macro excluída (soft delete)
   Route::resource('documents', DocumentController::class);
   // Rotas de documentos (CRUD)   
   Route::get('/documents/{document}/approve', [DocumentController::class, 'showApproveForm'])->name('documents.approve.form');
   Route::post('/documents/{document}/approve', [DocumentController::class, 'approve'])->name('documents.approve');

   Route::resource('company', CompanyController::class);
   // Rotas de empresas (CRUD)
   Route::resource('sector', SectorController::class);
   // Rotas de setores (CRUD)
   Route::resource('cost_center', CostCenterController::class);
   // Rotas de centros de custo (CRUD)


});