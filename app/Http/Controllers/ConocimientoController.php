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
use Illuminate\Contracts\Cache\Store;

//HELPER DE NOTIFICACION

//MAILABLE

class ConocimientoController extends Controller
{
    //VALIDACIONES
    public $validations = [
        "nombre" => "required|string|min:4|max:255",
    ];

    //MENSAJES DE ERROR
    public $error_messages = [
        "required" => "El dato es requerido",
        "string" => "El dato debe poseer caracteres alfanúmericos",
        "email" => "El dato debe ser enviado en formato corre (ejemplo@correo.com)",
        "numeric" => "El dato solo debe poseer datos númericos",
        "nullable" => "El dato puede viajar vacio",
        "unique" => "El orden enviado ya se encuentra registrado",
        "max" => "El dato debe poseer menos de 255 caracteres",
        "nombre.min" => "El nombre debe poseer al menos 4 caracteres",
        "nombre_update.min" => "El nombre debe poseer al menos 4 caracteres",
        "ruta_imagen.max" => "La Imagen no debe pesar más de 2 Mb",
        "file" => "El dato debe ser enviado como un archivo",
        "mime" => "El archivo debe llegar en formato png, jpg y jpeg",
    ];

    //VISUALES DEL SISTEMA REDIRECCIONAMIENTO

    //Visual primer Index
    public function index(){
        $areas = Conocimiento::all();
        $articulos = Articulo::all();
        $maximo = 0;
        $max_area = null;

        //Calculo de Conocimiento con más artículos
            foreach($areas as $area){
                $cantidad = $area->articulos->count();

                if($cantidad > $maximo )
                    $max_area = $area;
            }

        return view('panel_admin.ediciones.areas', compact('areas', 'articulos', 'max_area'));
    }

    //APARTADO DEL RUD DEL CONTROLADOR

    //Store de una Nueva Edicion
    public function store(Request $request){
        
        DB::beginTransaction();
        try{
            
            //Validando datos
            $validate = Validator::make($request->all(), $this->validations, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            Conocimiento::create($request->all());
            
            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return Redirect::back()->with('success', 'El Conocimiento fue almacenado de manera exitosa ya puedes verlo entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El Conocimiento no pudo ser creado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Update de una Edicion
    public function update(Request $request){
        
        DB::beginTransaction();
        try{

            $validaciones = [
                "nombre_update" => "required|string|min:4|max:255",
                "id_update" => "required",
            ];

            //Validando datos
            $validate = Validator::make($request->all(), $validaciones, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate, 'update')->withInput();
            }

            //Hacemos el Update
            $conocimiento = Conocimiento::findOrFail($request->id_update);
            $conocimiento->nombre = $request->nombre_update;
            $conocimiento->update();
            
            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return Redirect::back()->with('success', 'El Area de Conocimiento fue editado de manera exitosa ya puedes ver sus cambios entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El Area de Conocimiento no pudo ser actualizado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Destroy de una Edicion
    public function destroy($id_area){
        
        DB::beginTransaction();
        try{

            $conocimiento = Conocimiento::find($id_area);

            if(!$conocimiento)
            return Redirect::back()->with('warning', 'La edición no pudo ser eliminada debido a que no pudo ser encontrada');

            //pongo los articulos su conocimiento con el borrado en nulo
                //Recorremos Artículo a Artículo
                foreach($conocimiento->articulos as $articulo){
                    $articulo->FK_id_conocimiento = null;
                    $articulo->update();
                }
            
            //Eliminamos finalmente el area
                $conocimiento->delete();

            //Aceptamos la eliminación de todo y redireccionamos
            DB::commit();
            return Redirect::back()->with('success', 'El Area de Conocimiento fue eliminada de manera exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El Area de Conocimiento no pudo ser eliminada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
}
