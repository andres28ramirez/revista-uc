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
    public function index(){
        $edicion = Edicion::orderBy('id_edicion', 'desc')->first();
        return view('panel_user.welcome', compact('edicion'));
    }

    public function getArticle($id_articulo){
        $articulo = Articulo::find($id_articulo);

        if(!$articulo)
            return redirect()->route('welcome')->with('warning', 'El artículo seleccionado no pudo ser encontrado, por favor intentalo nuevamente');

        return view('panel_user.article', compact('articulo'));
    }

    public function getArticlesByArea($id_conocimiento = null){
        $conocimiento = Conocimiento::find($id_conocimiento);

        if(!$conocimiento)
            return Redirect::back()->with('warning', 'El conocimiento seleccionado no pudo ser encontrado o no se envio el conocimiento que se desea buscar');

        return view('panel_user.areas', compact('conocimiento'));
    }
}
