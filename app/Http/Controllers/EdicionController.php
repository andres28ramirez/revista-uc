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
use App\Models\Edicion;
use Illuminate\Contracts\Cache\Store;

//HELPER DE NOTIFICACION

//MAILABLE

class EdicionController extends Controller
{
    //VALIDACIONES
    public $validations = [
        "titulo" => "required|string|min:3|max:255",
        "numero" => "required|numeric|min:0|unique:edicion,numero",
        "descripcion" => "required|string",
        "fecha" => "required",
        "ruta_imagen" => "file|mimes:jpg,jpeg,png|max:2100|",
        "ruta_archivo" => "file|mimes:jpg,jpeg,png,pdf|max:10240|",
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
        "titulo.min" => "El título debe poseer al menos 3 caracteres",
        "ruta_imagen.max" => "La Imagen no debe pesar más de 2 Mb",
        "ruta_archivo.max" => "La Imagen no debe pesar más de 10 Mb",
        "file" => "El dato debe ser enviado como un archivo",
        "ruta_imagen.mimes" => "El archivo debe llegar en formato png, jpg y jpeg",
        "ruta_archivo.mimes" => "El archivo debe llegar en formato png, jpg, jpeg o pdf",
    ];

    //VISUALES DEL SISTEMA REDIRECCIONAMIENTO
    
    //Visual primer Index
    public function index(){
        $ediciones = Edicion::all();
        return view('panel_admin.ediciones.index', compact('ediciones'));
    }

    //Visual de Creación
    public function create(){
        $edicion = null;
        return view('panel_admin.ediciones.create_edit', compact('edicion'));
    }

    //Visual de Editar Edición
    public function edit($id_edicion){
        $edicion = Edicion::findOrFail($id_edicion);
        return view('panel_admin.ediciones.create_edit', compact('edicion'));
    }

    //APARTADO DEL RUD DEL CONTROLADOR

    //Retorno de la Imagen del Storage
    public function getImage($filename = null){

        if($filename){
            $exist = Storage::disk('public')->exists('ediciones/'.$filename);

            if(!$exist)
                $file = Storage::disk('public')->get('crash.png');
            else
                $file = Storage::disk('public')->get('ediciones/'.$filename);
        }
        else
            $file = Storage::disk('public')->get('crash.png');

        return new Response($file, 200);
    }

    //Retorno del Archivo del Storage
    public function getArchive($filename = null){

        if($filename){
            $extension = pathinfo($filename)['extension'];

            $exist = Storage::disk('public')->exists('ediciones/'.$filename);

            if(!$exist){
                $extension = null;
                $file = storage_path('app/public/crash.png');
            }
            else
                $file = storage_path('app/public/ediciones/'.$filename);
        }
        else
            $file = storage_path('app/public/crash.png');
        
        $extension == "pdf" ? $extension = "application/pdf" : $extension = "image"; 

        return Response(file_get_contents($file), 200, [
            'Content-Type' => $extension,
            'Content-Disposition' => 'inline; filename="'.$file.'"'
        ]);
    }

    //Store de una Nueva Edicion
    public function store(Request $request){
        
        DB::beginTransaction();
        try{
            
            //Validando datos
            $validate = Validator::make($request->all(), $this->validations, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos la edición
            $datos = $request->all();
            //Envio de la Notificación

            //Almacenamiento de la Imagen
            if($request->hasFile('ruta_imagen')){
                $datos["ruta_imagen"] = $request->file('ruta_imagen')->store('ediciones', 'public');
            }

            //Almacenamiento del Archivo
            if($request->hasFile('ruta_archivo')){
                $datos["ruta_archivo"] = $request->file('ruta_archivo')->store('ediciones', 'public');
            }
            
            $edicion = Edicion::create($datos);
            
            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return redirect()->route('edicion.index')->with('success', 'La edición fue almacenada de manera exitosa ya puedes verla entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'La Edición no pudo ser creada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Update de una Edicion
    public function update(Request $request, $id_edicion){
        
        DB::beginTransaction();
        try{

            $validaciones = $this->validations;
            $validaciones["numero"] = "required|numeric|min:0|unique:edicion,numero,".$id_edicion.",id_edicion";

            //Validando datos
            $validate = Validator::make($request->all(), $validaciones, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos la edición
            $datos = $request->all();
            
            $edicion = Edicion::findOrFail($id_edicion);
            //Envio de la Notificación
            
            //Almacenamiento de la Imagen
            if($request->hasFile('ruta_imagen')){
                Storage::delete(['public/'.$edicion->ruta_imagen]);
                $datos["ruta_imagen"] = $request->file('ruta_imagen')->store('ediciones', 'public');
            }
            else{
                unset($datos['ruta_imagen']);
            }

            //Almacenamiento del Archivo
            if($request->hasFile('ruta_archivo') && $request->editArchive){
                Storage::delete(['public/'.$edicion->ruta_archivo]);
                $datos["ruta_archivo"] = $request->file('ruta_archivo')->store('ediciones', 'public');
            }
            elseif($request->editArchive && !$request->has('loaded')){
                Storage::delete(['public/'.$edicion->ruta_archivo]);
                $datos["ruta_archivo"] = null;
            }
            elseif($request->hasFile('ruta_archivo') && !$request->has('editArchive')){
                $datos["ruta_archivo"] = $request->file('ruta_archivo')->store('ediciones', 'public');
            }
            else{
                unset($datos['ruta_archivo']);
            }
            
            $edicion->update($datos);
            
            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return redirect()->route('edicion.index')->with('success', 'La edición fue editada de manera exitosa ya puedes ver sus cambios entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'La Edición no pudo ser actualizada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Destroy de una Edicion
    public function destroy($id_edicion){
        
        DB::beginTransaction();
        try{

            $edicion = Edicion::find($id_edicion);

            if(!$edicion)
            return redirect()->route('edicion.index')->with('warning', 'La edición no pudo ser eliminada debido a que no pudo ser encontrada');

            //Elimino los Artículos | Primero Archivos, Respuestas y Comentarios
                //Recorremos Artículo a Artículo
                foreach($edicion->articulos as $articulo){
                    //recorro archivo por archivo y borro
                    foreach($articulo->archivos as $archivo){
                        Storage::delete(['public/'.$archivo->ruta_archivo_es]);
                        Storage::delete(['public/'.$archivo->ruta_archivo_en]);
                        $archivo->delete();
                    }

                    //recorro comentarios y consecuentemente sus respuestas y borro
                    foreach($articulo->comentarios as $comentario){
                        foreach($comentario->respuestas as $respuesta){
                            $respuesta->delete();
                        }
                        $comentario->delete();
                    }

                    Storage::delete(['public/'.$articulo->ruta_imagen_es]);
                    $articulo->delete();
                }
            
            //Eliminamos finalmente la edición y su imagen preview como archivo
                Storage::delete(['public/'.$edicion->ruta_imagen]);
                Storage::delete(['public/'.$edicion->ruta_archivo]);
                $edicion->delete();

            //Aceptamos la eliminación de todo y redireccionamos
            DB::commit();
            return redirect()->route('edicion.index')->with('success', 'La edición fue eliminada de manera exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'La Edición no pudo ser eliminada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
}
