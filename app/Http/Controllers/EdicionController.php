<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Conocimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

//MODELOS
use App\Models\Edicion;
use App\Models\Edicion_Descarga;
use App\Models\Edicion_Visita;
use App\Models\User;
use App\Models\Usuario_Notificacion;
use App\Models\Notificacion;

//NOTIFICACION Y MAILABLE
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;
use App\Helpers\AdminNotificacion;

class EdicionController extends Controller
{
    //VALIDACIONES
    public $validations = [
        "titulo" => "required|string|min:3|max:255",
        "numero" => "required|numeric|min:0|unique:edicion,numero",
        "descripcion" => "required|string",
        "fecha" => "required",
        "periodo" => "required|string|min:3|max:255",
        "ruta_imagen" => "file|mimes:jpg,jpeg,png|max:2100|",
        "ruta_archivo" => "file|mimes:pdf,html|max:10240|",
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
        "titulo_en.min" => "El título debe poseer al menos 3 caracteres",
        "periodo.min" => "El periodo debe poseer al menos 3 caracteres",
        "ruta_imagen.max" => "La Imagen no debe pesar más de 2 Mb",
        "ruta_archivo.max" => "La Imagen no debe pesar más de 10 Mb",
        "file" => "El dato debe ser enviado como un archivo",
        "ruta_imagen.mimes" => "El archivo debe llegar en formato png, jpg y jpeg",
        "ruta_archivo.mimes" => "El archivo debe llegar en formato pdf o html",
    ];

    //VISUALES DEL SISTEMA REDIRECCIONAMIENTO
    
    //Visual primer Index
    public function index(){
        $ediciones = Edicion::paginate(10);
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

    //Visual de las Estadisticas
    public function estadisticas(Request $request){
        $ediciones = Edicion::orderBy('numero', 'desc')->get();
        $descargas = Edicion_Descarga::all();
        $visitas = Edicion_Visita::all();
        $conocimientos = Conocimiento::all();
        $articulos = Articulo::all();
        
        //Visitas por mes de formar general
        $per_visita = $request->visitas_periodo ? $request->visitas_periodo : date('Y');

        $g_visitas = Edicion_Visita::select('mes', DB::raw('sum(total) as total'))->
                                        where('year', $per_visita)->
                                        orderBy('mes', 'asc')->
                                        groupBy('mes')->get();
        
        return view('panel_admin.ediciones.stats', compact('ediciones', 'descargas', 'visitas', 'conocimientos', 'articulos', 'g_visitas', 'per_visita'));
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
    public function getArchive($filename = null, $id_edicion = null){
        
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

        //Suma de descarga a la edición
        DB::beginTransaction();
        try{
            $user = Auth::user();
            $rol = $user ? $user->urol->rol->nombre : "visitante";
            
            if($rol != "Administrador" && $id_edicion){

                $visita = Edicion_Descarga::where('FK_id_edicion', $id_edicion)->
                                where('mes', date('n'))->
                                where('year', date('Y'))->first();
                
                if($visita){
                    $visita->total += 1;
                    $visita->update();
                }
                else{
                    $visita = new Edicion_Descarga();
                    $visita->mes = date('n');
                    $visita->year = date('Y');
                    $visita->total = 1;
                    $visita->FK_id_edicion = $id_edicion;
                    $visita->save();
                }
            }
            DB::commit();
        }catch(QueryException $e){DB::rollBack();}

        return Response(file_get_contents($file), 200, [
            'Content-Type' => $extension,
            'Content-Disposition' => 'inline; filename="'.$file.'"'
        ]);
    }

    //Store de una Nueva Edicion
    public function store(Request $request){
        
        DB::beginTransaction();
        try{
            
            $validations = $this->validations;

            if($request->editEnglish){
                $validations["titulo_en"] = "required|string|min:3|max:255";
                $validations["descripcion_en"] = "required|string";
            }

            //Validando datos
            $validate = Validator::make($request->all(), $validations, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos la edición
            $datos = $request->all();

            //Almacenamiento de la Imagen
            if($request->hasFile('ruta_imagen')){
                $datos["ruta_imagen"] = $request->file('ruta_imagen')->store('ediciones', 'public');
            }

            //Almacenamiento del Archivo
            if($request->hasFile('ruta_archivo')){
                $datos["ruta_archivo"] = $request->file('ruta_archivo')->store('ediciones', 'public');
            }
            
            $edicion = Edicion::create($datos);

            //Envio de la Notificación
            $notificacion = new Notificacion();
            
            //Información General de la Notificación
            $notificacion->titulo = "Creación de nueva edición!!";
            $notificacion->descripcion = $edicion->titulo;
            $notificacion->ruta = route('edicion.edit', $edicion->id_edicion);
            $notificacion->icono = "fa-newspaper";
            $notificacion->save();

            //Enviamos el Helper que asigna la notificación a los usuarios Admin y Editor
            $titulo = "!!Se ha creado una nueva edición!!";
            $contenido = $edicion->titulo;
            AdminNotificacion::Notifica($notificacion, $titulo, $contenido);
            
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

            if($request->editEnglish){
                $validations["titulo_en"] = "required|string|min:3|max:255";
                $validations["contenido_en"] = "required|string";
            }

            //Validando datos
            $validate = Validator::make($request->all(), $validaciones, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos la edición
            $datos = $request->all();
            
            $edicion = Edicion::findOrFail($id_edicion);
            
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
            
            //Envio de la Notificación
            $notificacion = new Notificacion();
            
            //Información General de la Notificación
            $notificacion->titulo = "Se ha actualizado una Edición!!";
            $notificacion->descripcion = $edicion->titulo;
            $notificacion->ruta = route('edicion.edit', $edicion->id_edicion);
            $notificacion->icono = "fa-newspaper";
            $notificacion->save();

            //Enviamos el Helper que asigna la notificación a los usuarios Admin y Editor
            $titulo = "!!Se ha actualizado una edición!!";
            $contenido = $edicion->titulo;
            AdminNotificacion::Notifica($notificacion, $titulo, $contenido);
            
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

            
            //Envio de la Notificación
                $notificacion = new Notificacion();
                
                //Información General de la Notificación
                $notificacion->titulo = "Se ha eliminado una Edición!!";
                $notificacion->descripcion = $edicion->titulo;
                $notificacion->ruta = route('edicion.index');
                $notificacion->icono = "fa-newspaper";
                $notificacion->save();

                //Enviamos el Helper que asigna la notificación a los usuarios Admin y Editor
                $titulo = "!!Se ha eliminado una edición!!";
                $contenido = $edicion->titulo;
                AdminNotificacion::Notifica($notificacion, $titulo, $contenido);

            //Aceptamos la eliminación de todo y redireccionamos
            DB::commit();
            return redirect()->route('edicion.index')->with('success', 'La edición fue eliminada de manera exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'La Edición no pudo ser eliminada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
}
