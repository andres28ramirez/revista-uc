<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Articulo_Descarga;
use App\Models\Articulo_Visita;
use App\Models\Autor;
use App\Models\Edicion;
use App\Models\Edicion_Descarga;
use App\Models\Edicion_Visita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

//MODELOS
use App\Models\User;

class PanelController extends Controller
{
    //VISUAL INICIAL DEL PANEL ADMINISTRATIVO
    public function index(){

        //Totales
            $usuarios = User::all()->count();
            $autores = Autor::all()->count();
            $ediciones = Edicion::all()->count();
            $articulos = Articulo::all()->count();

            $totales = array(
                "usuarios" => $usuarios,
                "autores" => $autores,
                "ediciones" => $ediciones,
                "articulos" => $articulos,
            );

        //descargas y visitas
            $edi_descargas = Edicion_Descarga::all()->sum('total');
            $edi_visitas = Edicion_Visita::all()->sum('total');
            $art_descargas = Articulo_Descarga::all()->sum('total');
            $art_visitas = Articulo_Visita::all()->sum('total');

            $relacion = array(
                "global" => $edi_descargas + $edi_visitas + $art_descargas + $art_visitas,
                "e_des" => $edi_descargas,
                "e_vis" => $edi_visitas,
                "a_des" => $art_descargas,
                "a_vis" => $art_visitas,
            );
            
        return view('dashboard', compact('totales', 'relacion'));
    }
}
