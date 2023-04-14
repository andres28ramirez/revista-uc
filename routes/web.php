<?php

use App\Http\Controllers\ConfiguracionController;
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
});

//RUTAS DE AUTENTICACIÓN
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
