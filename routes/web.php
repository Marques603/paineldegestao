<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\SubmenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MacroController;
use App\Http\Controllers\DocumentController;



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

   Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
   // Remove o usuário selecionado do banco de dados

   Route::resource('menus', MenuController::class);
   // Rotas de menus (CRUD)
   Route::resource('submenus', SubmenuController::class);
   // Rotas de submenus (CRUD)
   Route::resource('sector', SectorController::class);
   // Rotas de setores (CRUD)
   Route::resource('company', CompanyController::class);
   // Rotas de empresas (CRUD)
   Route::resource('macro', MacroController::class);
   // Rotas de macro (CRUD)
   Route::resource('documents', DocumentController::class);
   // Rotas de documentos (CRUD)


});