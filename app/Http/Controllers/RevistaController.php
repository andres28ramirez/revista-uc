<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

//MODELOS
use App\Models\Articulo;
use App\Models\Autor;
use App\Models\Conocimiento;
use App\Models\Edicion;
use App\Models\Informacion;
use App\Models\Perfil;
use App\Models\Rol;
use App\Models\User;
use App\Models\Usuario_Rol;
use App\Models\Usuario_Tipo;
use Illuminate\Contracts\Cache\Store;

//HELPER DE NOTIFICACION

//MAILABLE

class RevistaController extends Controller
{
    //Pagina Inicial
    public function index(){
        $edicion = Edicion::orderBy('numero', 'desc')->first();
        return view('panel_user.welcome', compact('edicion'));
    }

    //Apartado de articulos
    public function getArticle($id_articulo){
        $articulo = Articulo::find($id_articulo);

        if(!$articulo)
            return redirect()->route('welcome')->with('warning', 'El artículo seleccionado no pudo ser encontrado, por favor intentalo nuevamente');

        return view('panel_user.article', compact('articulo'));
    }

    //Apartado de areas de conocimiento
    public function getArticlesByArea($id_conocimiento = null){
        $conocimiento = Conocimiento::find($id_conocimiento);

        if(!$conocimiento)
            return Redirect::back()->with('warning', 'El conocimiento seleccionado no pudo ser encontrado o no se envio el conocimiento que se desea buscar');

        return view('panel_user.areas', compact('conocimiento'));
    }

    //Apartado de Autores
    public function getAuthors(){
        $autores = Autor::orderBy('nombre', 'asc')->get();
        return view('panel_user.autores', compact('autores'));
    }

    //Apartado de Ediciones
    public function allEditions(){
        $ediciones = Edicion::orderBy('numero', 'desc')->get();
        return view('panel_user.ediciones', compact('ediciones'));
    }

    //Información de edición seleccionada
    public function getEdition($id_edicion){
        $edicion = Edicion::find($id_edicion);

        if(!$edicion)
            return redirect()->route('welcome')->with('warning', 'La edición seleccionada no pudo ser encontrada, por favor intentalo nuevamente');

        return view('panel_user.edition', compact('edicion'));
    }

    //Apartado de Informaciones o Acerca de...
    public function getInformations(){
        $informaciones = Informacion::all();
        return view('panel_user.informaciones', compact('informaciones'));
    }

    //Buscador Global
    public function buscador(Request $request){
        $param = $request->parametro;

        $articulos = Articulo::where(function($query) use ($param) {
            $query->where('titulo', 'like', '%'.$param.'%')
                ->orWhere('contenido', 'like', '%'.$param.'%');
        })->paginate(1);

        return view('panel_user.buscador', compact('articulos', 'param'));
    }

}
