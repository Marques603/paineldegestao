<?php

use App\Models\Item;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MacroController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ConciergeController;
use App\Http\Controllers\MileagesCarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rotas da aplicação protegidas por autenticação.
|
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard principal
    Route::view('/', 'dashboard.index')->name('dashboard');

    // Rotas de usuários (CRUD)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/create', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::put('/user/{user}/password', [UserController::class, 'updatePassword'])->name('user.password.update');
    Route::put('/users/{user}/update-profile', [UserController::class, 'updateProfile'])->name('users.update.profile');
    Route::put('/users/{user}/roles', [UserController::class, 'updateRoles'])->name('users.update.roles');
    Route::put('/users/{user}/status', [UserController::class, 'updateStatus'])->name('users.update.status');
    Route::put('/users/{user}/menus', [UserController::class, 'updateMenus'])->name('users.update.menus');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Rotas de cargos (CRUD)
    Route::resource('position', PositionController::class);
    Route::put('position/{position}/details', [PositionController::class, 'updateDetails'])->name('position.update.details');
    Route::put('position/{position}/status', [PositionController::class, 'updateStatus'])->name('position.update.status');
    Route::put('position/{position}/users', [PositionController::class, 'updateUsers'])->name('position.update.users');


    // Rotas de menus (CRUD)
    Route::resource('menus', MenuController::class);

    // Rotas de macro (CRUD)
    Route::resource('macro', MacroController::class);
    Route::put('/macro/{macro}/status', [MacroController::class, 'updateStatus'])->name('macro.update.status');
    Route::get('/macro/{macro}/restore', [MacroController::class, 'restore'])->name('macro.restore');
    Route::put('/macro/{macro}/responsibles', [MacroController::class, 'updateResponsibles'])->name('macro.update.responsibles');


    // Rotas de documentos (CRUD)
    Route::resource('documents', DocumentController::class);
    Route::get('/documents/{document}/approve', [DocumentController::class, 'showApproveForm'])->name('documents.approve.form');
    Route::post('/documents/{document}/approve', [DocumentController::class, 'approve'])->name('documents.approve');
    Route::post('/documents/{document}/approve/status', [DocumentController::class, 'updateApprovalStatus'])->name('documents.updateApprovalStatus');
    Route::put('documents/{document}/code', [DocumentController::class, 'updateCode'])->name('documents.update.code');
    Route::put('documents/{document}/file', [DocumentController::class, 'updateFile'])->name('documents.update.file');
    Route::put('documents/{document}/macros', [DocumentController::class, 'updateMacros'])->name('documents.update.macros');
    Route::put('documents/{document}/sectors', [DocumentController::class, 'updateSectors'])->name('documents.update.sectors');
    Route::put('/documents/{document}/status', [DocumentController::class, 'updateStatus'])->name('documents.update.status');


    // Rotas de empresas (CRUD)
    Route::resource('company', CompanyController::class);
    Route::put('/company/{company}/update-details', [CompanyController::class, 'updateDetails'])->name('company.update.details');
    Route::put('/company/{company}/update-status', [CompanyController::class, 'updateStatus'])->name('company.update.status');
    Route::put('/company/{company}/update-users', [CompanyController::class, 'updateUsers'])->name('company.update.users');
    Route::put('/company/{company}/update-responsibles', [CompanyController::class, 'updateResponsibles'])->name('company.update.responsibles');


    // Rotas de setores (CRUD)
    Route::resource('sector', SectorController::class);
    Route::put('/sector/{sector}/update-details', [SectorController::class, 'updateDetails'])->name('sector.update.details');
    Route::put('/sector/{sector}/update-status', [SectorController::class, 'updateStatus'])->name('sector.update.status');
    Route::put('/sector/{sector}/update-users', [SectorController::class, 'updateUsers'])->name('sector.update.users');
    Route::put('/sector/{sector}/update-responsibles', [SectorController::class, 'updateResponsibles'])->name('sector.update.responsibles');

    // Rotas de centros de custo (CRUD)
    Route::resource('cost_center', CostCenterController::class);
    Route::put('/cost_center/{cost_center}/update-info', [CostCenterController::class, 'updateInfo'])->name('cost_center.update.info');
    Route::put('/cost_center/{cost_center}/update-status', [CostCenterController::class, 'updateStatus'])->name('cost_center.update.status');
    Route::put('/cost_center/{cost_center}/update-sectors', [CostCenterController::class, 'updateSectors'])->name('cost_center.update.sectors');
 
    // Rotas de requisições de compra (CRUD)
    Route::resource('compras', CompraController::class);
    Route::get('/compras', [CompraController::class, 'index'])->name('compras.index');
    Route::get('/compras/create', [CompraController::class, 'create'])->name('compras.create');
    Route::post('/compras', [CompraController::class, 'store'])->name('compras.store');
    Route::get('/compras/{compra}/edit', [CompraController::class, 'edit'])->name('compras.edit');
    Route::put('/compras/{compra}/compras-all', [CompraController::class, 'comprasAll'])->name('compras.update.all');
    // Formulário unificado de criação de Compra + Item
    Route::get('/compras/com-itens/criar', [CompraController::class, 'createComItem'])->name('compras.create.com.item');
    Route::get('/compras/com-itens/{compra}', [CompraController::class, 'editComItem'])->name('compras.edit-com-item');
    Route::post('/compras/com-itens', [CompraController::class, 'storeComItem'])->name('compras.store.com.item');


    Route::delete('/compras/{compra}', [CompraController::class, 'destroy'])->name('compras.destroy');
    Route::put('/compras/{compra}/update-items', [CompraController::class, 'updateItem'])->name('compras.update.items');
    
 
    // Rotas de itens de compra (CRUD)
    Route::resource('item', ItemController::class);
    Route::get('/item', [ItemController::class, 'index'])->name('item.index');
    Route::get('item/create', [ItemController::class, 'create'])->name('item.create');
    Route::post('item', [ItemController::class, 'store'])->name('item.store');
    Route::get('item/{item}', [ItemController::class, 'show'])->name('item.show');
    Route::get('item/{item}/edit', [ItemController::class, 'edit'])->name('item.edit');
    Route::put('/item/{item}/update-all', [ItemController::class, 'updateAll'])->name('item.update.all');
    Route::put('item/{item}', [ItemController::class, 'update'])->name('item.update');
    Route::delete('item/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
    
    // Rotas de Veículos (CRUD)
    Route::resource('vehicles', VehicleController::class);
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');



    //  Rotas de Portária
    Route::resource('concierge', ConciergeController::class);
    Route::get('/concierge',[ConciergeController::class,'index'])->name('concierge.index');
    Route::get('/concierge/create', [ConciergeController::class,'create'])->name('concierge.create');
    Route::post('/concierge', [ConciergeController::class, 'store'])->name('concierge.store');
    Route::get('/concierge/{concierge}/edit', [ConciergeController::class, 'edit'])->name('concierge.edit');
    Route::put('/concierge/{concierge}', [ConciergeController::class, 'update'])->name('concierge.update');
    Route::delete('/concierge/{concierge}', [ConciergeController::class, 'destroy'])->name('concierge.destroy');
    Route::get('/concierge/{concierge}/show', [ConciergeController::class, 'show'])->name('concierge.show');
    Route::get('/concierge2', [ConciergeController::class, 'index2'])->name('concierge2.index');
    Route::get('/concierge/{concierge}/restore', [ConciergeController::class, 'restore'])->name('concierge.restore');
    Route::put('/concierge/{concierge}/update-vehicles', [ConciergeController::class, 'updateVehicles'])->name('concierge.update.vehicles');


    // Rotas de kilometragem de veículos
    Route::resource('mileages', MileagesCarController::class);
    Route::get('/mileages', [MileagesCarController::class, 'index'])->name('mileages.index');
    Route::get('/mileages/create', [MileagesCarController::class, 'create'])->name('mileages.create');
    Route::post('/mileages', [MileagesCarController::class, 'store'])->name('mileages.store');
    Route::get('/mileages/{mileage}/edit', [MileagesCarController::class, 'edit'])->name('mileages.edit');
    Route::put('/mileages/{mileage}', [MileagesCarController::class, 'update'])->name('mileages.update');
    Route::delete('/mileages/{mileage}', [MileagesCarController::class, 'destroy'])->name('mileages.destroy');
    Route::get('/mileages/{mileage}/show', [MileagesCarController::class, 'show'])->name('mileages.show');
    Route::get('/mileages/{mileage}/restore', [MileagesCarController::class, 'restore'])->name('mileages.restore');
    Route::put('/mileages/{mileage}/update-vehicles', [MileagesCarController::class, 'updateVehicles'])->name('mileages.update.vehicles');

    
});
