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
}
