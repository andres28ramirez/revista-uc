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
use App\Models\Archivo;
use App\Models\Articulo;

class ArchivosController extends Controller
{
    //Visual de ver todos los comentarios con paginación y filtrado
    public function index($id_articulo = null){
        $articulos = Articulo::all();
        $filtrado = null;
        $name_articulo = null;

        //Filtros de Busqueda
        if($id_articulo){ 
            $filtrado = true;
            $name_articulo = $articulos->find($id_articulo);
            $name_articulo = $name_articulo->titulo;
        };
        
        
        $query = Archivo::query();

        //Articulo
        $query->when($id_articulo, function ($q, $id_articulo) {
            return $q->where('FK_id_articulo', $id_articulo);
        });

        $archivos = $query->paginate(10);
        
        return view('panel_admin.archivos.index', compact('archivos', 'articulos', 'filtrado', 'id_articulo', 'name_articulo'));
    }

    //Destroy de un Archivo
    public function destroy($id_archivo){
        
        DB::beginTransaction();
        try{

            $archivo = Archivo::find($id_archivo);

            if(!$archivo)
            return redirect()->route('archivo.index')->with('warning', 'El archivo no pudo ser eliminado debido a que no pudo ser encontrado');

            //elimino el documento y posterior a ello su registro
            Storage::delete(['public/'.$archivo->ruta_archivo_es]);
            Storage::delete(['public/'.$archivo->ruta_archivo_en]);
            $archivo->delete();

            //Aceptamos la eliminación de todo y redireccionamos
            DB::commit();
            return redirect()->route('archivo.index')->with('success', 'El Archivo fue eliminado de manera exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El Archivo no pudo ser eliminado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
}
