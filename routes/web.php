<?php

use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//RUTA DE LA PÁGINA INICIAL DEL SISTEMA
Route::get('/', function () {
    return view('panel_user.welcome');
})->name('welcome');

//RUTAS DE LA PÁGINA DE USUARIOS | NAVEGACIÓN INTERNA

//RUTAS DE CONTROL Y MODIFICACIONES
Route::get('/lang/{locale}', [ConfiguracionController::class, 'setlocale'])->name('change.lang');

//RUTA DEL PANEL ADMINISTRATIVO
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
