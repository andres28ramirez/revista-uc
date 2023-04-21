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
use Illuminate\Contracts\Cache\Store;

//HELPER DE NOTIFICACION

//MAILABLE

class ArticuloController extends Controller
{
    //VISUALES DEL SISTEMA REDIRECCIONAMIENTO

    //Visual primer Index
    public function index(){
        $ediciones = Edicion::all();

        return view('panel_admin.articulos.index', compact('ediciones'));
    }

    //Visual de Creación
    public function create(){
        $ediciones = Edicion::all();
        $autores = Autor::all();
        $areas = Conocimiento::all();

        if($ediciones)
            return view('panel_admin.articulos.create', compact('ediciones', 'autores', 'areas'));
        else
            return redirect()->route('articulo.index')->with('warning', 'No puedes cargar artículos hasta que no haya una edición subida');
    }
}
