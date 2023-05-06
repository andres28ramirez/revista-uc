<?php

use App\Http\Controllers\ArchivosController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ConocimientoController;
use App\Http\Controllers\EdicionController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuariosController;
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
    Route::get('/articulos/todos/{id_autor?}/{id_conocimiento?}/{id_edicion?}', [ArticuloController::class, 'all_articles'])->name('articulo.all');
    Route::get('/articulos/view/{id}', [ArticuloController::class, 'one_article'])->name('articulo.view');
    Route::get('/articulos/create', [ArticuloController::class, 'create'])->name('articulo.create');
    Route::get('/articulos/edit/{id}', [ArticuloController::class, 'edit'])->name('articulo.edit');
    Route::get('/articulos/getImage/{filename?}', [ArticuloController::class, 'getImage'])->name('articulo.imagen');
    Route::get('/articulos/getArchive/{filename?}', [ArticuloController::class, 'getArchive'])->name('articulo.archivo');
    Route::get('/articulos/{id?}', [ArticuloController::class, 'index'])->name('articulo.index');

    Route::post('/articulos/store', [ArticuloController::class, 'store'])->name('articulo.store');
    Route::post('/articulos/update/{id}', [ArticuloController::class, 'update'])->name('articulo.update');
    Route::post('/articulos/delete/{id}', [ArticuloController::class, 'destroy'])->name('articulo.delete');

    //AUTORES
    Route::get('/autor', [AutorController::class, 'index'])->name('autor.index');
    Route::get('/autor/create', [AutorController::class, 'create'])->name('autor.create');
    Route::get('/autor/edit/{id}', [AutorController::class, 'edit'])->name('autor.edit');
    Route::get('/autor/getImage/{filename?}', [AutorController::class, 'getImage'])->name('autor.imagen');
    
    Route::post('/autor/store', [AutorController::class, 'store'])->name('autor.store');
    Route::post('/autor/update/{id}', [AutorController::class, 'update'])->name('autor.update');
    Route::post('/autor/delete/{id}', [AutorController::class, 'destroy'])->name('autor.delete');

    //COMENTARIOS
    Route::get('/comentario', [ComentarioController::class, 'index'])->name('comentario.index');
    Route::get('/comentario/view/{id}', [ComentarioController::class, 'one_article'])->name('comentario.view');
    Route::get('/comentario/todos/{id_usuario?}/{id_articulo?}/{id_estado?}', [ComentarioController::class, 'all_comments'])->name('comentario.all');
    Route::get('/comentario/edit/{id}', [ComentarioController::class, 'coEdit'])->name('comentario.edit');
    Route::get('/respuesta/edit/{id}', [ComentarioController::class, 'reEdit'])->name('respuesta.edit');

    Route::post('/comentario/update/{id}', [ComentarioController::class, 'coUpdate'])->name('comentario.update');
    Route::post('/comentario/delete/{id}', [ComentarioController::class, 'coDestroy'])->name('comentario.delete');

    Route::post('/respuesta/update/{id}', [ComentarioController::class, 'reUpdate'])->name('respuesta.update');
    Route::post('/respuesta/delete/{id}', [ComentarioController::class, 'reDestroy'])->name('respuesta.delete');

    //ARCHIVOS
    Route::get('/archivo/{id_articulo?}', [ArchivosController::class, 'index'])->name('archivo.index');
    Route::post('/archivo/delete/{id}', [ArchivosController::class, 'destroy'])->name('archivo.delete');
    
    //USUARIOS
    Route::get('/usuarios/view/{id}', [UsuariosController::class, 'view'])->name('usuario.view');
    Route::get('/usuarios/create', [UsuariosController::class, 'create'])->name('usuario.create');
    Route::get('/usuarios/edit/{id}', [UsuariosController::class, 'edit'])->name('usuario.edit');
    Route::get('/usuarios/{id_usuario?}/{id_articulo?}/{id_estado?}', [UsuariosController::class, 'index'])->name('usuario.index');
    
    Route::post('/usuarios/store', [UsuariosController::class, 'store'])->name('usuario.store');
    Route::post('/usuarios/update/{id}', [UsuariosController::class, 'update'])->name('usuario.update');
    Route::post('/usuarios/delete/{id}', [UsuariosController::class, 'destroy'])->name('usuario.delete');
});

//RUTAS DE AUTENTICACIÓN
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
