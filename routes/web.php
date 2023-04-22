<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ConocimientoController;
use App\Http\Controllers\EdicionController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//RUTA DE LA PÁGINA INICIAL DEL SISTEMA
Route::get('/', function () {
    return view('panel_user.welcome');
})->name('welcome');

//RUTAS DE LA PÁGINA DE USUARIOS | NAVEGACIÓN INTERNA

//RUTAS DE CONTROL Y MODIFICACIONES
Route::get('/lang/{locale}', [ConfiguracionController::class, 'setlocale'])->name('change.lang');

//RUTAS DEL PANEL ADMINISTRATIVO
Route::prefix('/panel')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [PanelController::class, 'index'])->name('dashboard');

    //EDICIONES
    Route::get('/edicion', [EdicionController::class, 'index'])->name('edicion.index');
    Route::get('/edicion/create', [EdicionController::class, 'create'])->name('edicion.create');
    Route::get('/edicion/edit/{id}', [EdicionController::class, 'edit'])->name('edicion.edit');
    Route::get('/edicion/getImage/{filename?}', [EdicionController::class, 'getImage'])->name('edicion.imagen');
    
    Route::post('/edicion/store', [EdicionController::class, 'store'])->name('edicion.store');
    Route::post('/edicion/update/{id}', [EdicionController::class, 'update'])->name('edicion.update');
    Route::post('/edicion/delete/{id}', [EdicionController::class, 'destroy'])->name('edicion.delete');

    //AREA DE CONOCIMIENTO
    Route::get('/edicion/conocimiento', [ConocimientoController::class, 'index'])->name('edicion.conocimiento');
    Route::post('/edicion/conocimiento/store', [ConocimientoController::class, 'store'])->name('edicion.conocimiento.store');
    Route::post('/edicion/conocimiento/update', [ConocimientoController::class, 'update'])->name('edicion.conocimiento.update');
    Route::post('/edicion/conocimiento/delete/{id}', [ConocimientoController::class, 'destroy'])->name('edicion.conocimiento.delete');

    //ARTICULOS
    Route::get('/articulos', [ArticuloController::class, 'index'])->name('articulo.index');
    Route::get('/articulos/todos', [ArticuloController::class, 'all_articles'])->name('articulo.all');
    Route::get('/articulos/view/{id}', [ArticuloController::class, 'one_article'])->name('articulo.view');
    Route::get('/articulos/create', [ArticuloController::class, 'create'])->name('articulo.create');
    Route::get('/articulos/edit/{id}', [ArticuloController::class, 'edit'])->name('articulo.edit');
    Route::get('/articulos/getImage/{filename?}', [ArticuloController::class, 'getImage'])->name('articulo.imagen');
    Route::get('/articulos/{id?}', [ArticuloController::class, 'index'])->name('articulo.index');

    Route::post('/articulos/store', [ArticuloController::class, 'store'])->name('articulo.store');
    Route::post('/articulos/update/{id}', [ArticuloController::class, 'update'])->name('articulo.update');
    Route::post('/articulos/delete/{id}', [ArticuloController::class, 'destroy'])->name('articulo.delete');
});

//RUTAS DE AUTENTICACIÓN
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
