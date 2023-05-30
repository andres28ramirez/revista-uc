<?php

use App\Http\Controllers\ArchivosController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ConocimientoController;
use App\Http\Controllers\EdicionController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevistaController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

//RUTAS DE CONTROL Y MODIFICACIONES
Route::get('/lang/{locale}', [ConfiguracionController::class, 'setlocale'])->name('change.lang');

//RUTAS DE LA PÁGINA DE USUARIOS | NAVEGACIÓN INTERNA
Route::get('/', [RevistaController::class, 'index'])->name('welcome');

Route::prefix('/revista')->group(function () {
    //Buscador
    Route::get('/buscador/{parametro?}', [RevistaController::class, 'buscador'])->name('user.search');

    //Articulos
    Route::get('/articulo/codigo/{id}', [RevistaController::class, 'getArticle'])->name('user.articulo');
    Route::get('/articulo/getImage/{filename?}', [ArticuloController::class, 'getImage'])->name('user.articulo.imagen');
    Route::get('/articulos/getArchive/{filename?}', [ArticuloController::class, 'getArchive'])->name('user.articulo.archivo');

    //Ediciones
    Route::get('/ediciones', [RevistaController::class, 'allEditions'])->name('user.ediciones');
    Route::get('/edicion/codigo/{id}', [RevistaController::class, 'getEdition'])->name('user.edicion');
    Route::get('/edicion/getImage/{filename?}', [EdicionController::class, 'getImage'])->name('user.edicion.imagen');
    Route::get('/edicion/getArchive/{filename?}', [EdicionController::class, 'getArchive'])->name('user.edicion.archivo');

    //Autores
    Route::get('/autores', [RevistaController::class, 'getAuthors'])->name('user.autores');
    Route::get('/autor/getImage/{filename?}', [AutorController::class, 'getImage'])->name('user.autor.imagen');

    //Comentarios
    Route::post('/usuario/comentario/store', [ComentarioController::class, 'storeCo'])->name('user.comentario.store');
    Route::post('/usuario/respuesta/store', [ComentarioController::class, 'storeRe'])->name('user.respuesta.store');

    //Conocimientos
    Route::get('/conocimiento/articulos/{id?}', [RevistaController::class, 'getArticlesByArea'])->name('user.conocimiento.articulos');
    Route::get('/configuracion/info/getArchive/{filename?}', [ConfiguracionController::class, 'getArchive'])->name('configuracion.info.archivo');

    //Informaciones
    Route::get('/informacion', [RevistaController::class, 'getInformations'])->name('user.informaciones');
});

//RUTAS DEL PANEL ADMINISTRATIVO
Route::prefix('/panel')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [PanelController::class, 'index'])->name('dashboard');

    //EDICIONES
    Route::get('/edicion', [EdicionController::class, 'index'])->name('edicion.index');
    Route::get('/edicion/create', [EdicionController::class, 'create'])->name('edicion.create');
    Route::get('/edicion/stats', [EdicionController::class, 'estadisticas'])->name('edicion.stats');
    Route::post('/edicion/stats', [EdicionController::class, 'estadisticas'])->name('edicion.filter');
    Route::get('/edicion/edit/{id}', [EdicionController::class, 'edit'])->name('edicion.edit');
    Route::get('/edicion/getImage/{filename?}', [EdicionController::class, 'getImage'])->name('edicion.imagen');
    Route::get('/edicion/getArchive/{filename?}', [EdicionController::class, 'getArchive'])->name('edicion.archivo');
    
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
    Route::get('/articulos/stats', [ArticuloController::class, 'estadisticas'])->name('articulo.stats');
    Route::post('/articulos/stats', [ArticuloController::class, 'estadisticas'])->name('articulo.filter');
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

    //PERFIL
    Route::get('/perfil/edit', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::post('/perfil/update', [PerfilController::class, 'update'])->name('perfil.update');

    //CONFIGURACION
    Route::get('/configuracion/roles', [ConfiguracionController::class, 'roles'])->name('configuracion.roles');
    Route::get('/configuracion/tipos', [ConfiguracionController::class, 'tipos'])->name('configuracion.tipos');
    Route::get('/configuracion/modulos', [ConfiguracionController::class, 'modulos'])->name('configuracion.modulos');
    Route::get('/configuracion/informaciones', [ConfiguracionController::class, 'informaciones'])->name('configuracion.informaciones');
    
        //ROLES
        Route::post('/configuracion/rol/store', [ConfiguracionController::class, 'storeRol'])->name('configuración.rol.store');
        Route::post('/configuracion/rol/update', [ConfiguracionController::class, 'updateRol'])->name('configuración.rol.update');
        Route::post('/configuracion/rol/delete/{id}', [ConfiguracionController::class, 'destroyRol'])->name('configuración.rol.delete');

        //TIPOS
        Route::post('/configuracion/tipos/store', [ConfiguracionController::class, 'storeTipo'])->name('configuración.tipo.store');
        Route::post('/configuracion/tipos/update', [ConfiguracionController::class, 'updateTipo'])->name('configuración.tipo.update');
        Route::post('/configuracion/tipos/delete/{id}', [ConfiguracionController::class, 'destroyTipo'])->name('configuración.tipo.delete');

        //INFORMACIONES
        Route::get('/configuracion/info/getArchive/{filename?}', [ConfiguracionController::class, 'getArchive'])->name('configuracion.info.archivo');
        Route::get('/configuracion/info/create', [ConfiguracionController::class, 'create'])->name('configuración.info.create');
        Route::get('/configuracion/info/edit/{id}', [ConfiguracionController::class, 'edit'])->name('configuración.info.edit');
        Route::post('/configuracion/info/store', [ConfiguracionController::class, 'storeInfo'])->name('configuración.info.store');
        Route::post('/configuracion/info/update/{id}', [ConfiguracionController::class, 'updateInfo'])->name('configuración.info.update');
        Route::post('/configuracion/info/delete/{id}', [ConfiguracionController::class, 'destroyInfo'])->name('configuración.info.delete');
});

//RUTAS DE AUTENTICACIÓN
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
