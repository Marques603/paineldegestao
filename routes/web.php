<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui registramos as rotas da aplicação que serão carregadas pelo
| RouteServiceProvider e ficam no grupo "web".
|
*/

/** 
 * Rotas protegidas: somente usuários autenticados podem acessar.
 */
Route::middleware(['auth'])->group(function () {

    // Dashboard principal e demais views internas
    Route::view('/', 'dashboard.index')->name('dashboard');
    
});