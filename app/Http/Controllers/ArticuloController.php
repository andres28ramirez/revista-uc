<?php

namespace App\Http\Controllers;

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
use App\Models\Archivo;
use App\Models\Articulo;
use App\Models\Articulo_Descarga;
use App\Models\Articulo_Visita;
use App\Models\Autor;
use App\Models\Comentario;
use App\Models\Conocimiento;
use App\Models\Edicion;
use App\Models\User;
use App\Models\Usuario_Notificacion;
use App\Models\Notificacion;

//NOTIFICACION Y MAILABLE
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;
use App\Helpers\AdminNotificacion;

class ArticuloController extends Controller
{
    //VALIDACIONES
    public $validations = [
        "titulo" => "required|string|min:3|max:255",
        "contenido" => "required|string",
        "FK_id_edicion" => "required|numeric",
        "FK_id_autor" => "numeric|nullable",
        "FK_id_conocimiento" => "numeric|nullable",
        "ruta_imagen_es" => "file|mimes:jpg,jpeg,png|max:2100|",
        "archivos.*" => "file|mimes:pdf, html|max:10240|",
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
        "ruta_imagen_es.max" => "La Imagen no debe pesar más de 2 Mb",
        "ruta_imagen_es.mimes" => "El archivo debe ser en formato png, jpg y jpeg",
        "archivos.*.max" => "Los Documentos no deben pesar más de 10 Mb",
        "archivos.*.mimes" => "Los Documentos deben ser en formato pdf o html",
        "file" => "El dato debe ser enviado como un archivo",
    ];

    //VISUALES DEL SISTEMA REDIRECCIONAMIENTO

    //Visual primer Index
    public function index($id_edicion = 0){
        $ediciones = Edicion::all();
        $nombre = "";

        if(!$id_edicion)
            $articulos = Articulo::orderBy('created_at', 'desc')->paginate(6);
        else{
            $edicion = $ediciones->find($id_edicion);

            if($edicion){
                $nombre = $edicion->titulo;
                $articulos = Articulo::where('FK_id_edicion', $id_edicion)->get();
            }
            else
                $articulos = Articulo::orderBy('created_at', 'desc')->paginate(6);
        }
        
        return view('panel_admin.articulos.index', compact('ediciones', 'articulos', 'nombre'));
    }

    //Visual Tabla con todos los artículos
    public function all_articles($id_autor = null, $id_conocimiento = null, $id_edicion = null){
        $ediciones = Edicion::all();
        $areas = Conocimiento::all();
        $autores = Autor::all();
        $filtrado = null;

        //Filtros de Busqueda
        if($id_autor || $id_conocimiento || $id_edicion) $filtrado = true;
        
        
        $query = Articulo::query();

        //Autor
        $query->when($id_autor, function ($q, $id_autor) {
            return $q->where('FK_id_autor', $id_autor);
        });

        //Conocimiento
        $query->when($id_conocimiento, function ($q, $id_conocimiento) {
            return $q->where('FK_id_conocimiento', $id_conocimiento);
        });

        //Edición
        $query->when($id_edicion, function ($q, $id_edicion) {
            return $q->where('FK_id_edicion', $id_edicion);
        });

        $articulos = $query->paginate(10);
        
        return view('panel_admin.articulos.all', compact('articulos', 'autores', 'areas', 'ediciones', 'filtrado', 'id_autor', 'id_conocimiento', 'id_edicion'));
    }

    //Visual Tabla con todos los artículos
    public function one_article($id_articulo){
        $articulo = Articulo::find($id_articulo);

        if(!$articulo)
            return redirect()->route('articulo.index')->with('warning', 'El Artículo para visualizar no pudo ser encontrado, por favor intenta con un nuevo artículo');

        return view('panel_admin.articulos.one', compact('articulo'));
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

    //Visual de Editar Artículo
    public function edit($id_articulo){
        $articulo = Articulo::find($id_articulo);
        $ediciones = Edicion::all();
        $autores = Autor::all();
        $areas = Conocimiento::all();

        if(!$articulo)
            return redirect()->route('articulo.index')->with('warning', 'El artículo seleccionado no pudo ser encontrado, por favor intentalo nuevamente');

        return view('panel_admin.articulos.edit', compact('articulo', 'ediciones', 'autores', 'areas'));
    }

    //Visual de las Estadisticas
    public function estadisticas(Request $request){
        
        $articulos = Articulo::orderBy('created_at', 'asc')->get();
        $descargas = Articulo_Descarga::all();
        $visitas = Articulo_Visita::all();
        $autores = Autor::all();
        $comentarios = Comentario::all();
        $archivos = Archivo::all();
        $ediciones = Edicion::all();
        
        //Visitas por mes de formar general
        $per_visita = $request->visitas_periodo ? $request->visitas_periodo : date('Y');
                                        
        $g_visitas = Articulo_Visita::select('mes', DB::raw('sum(total) as total'))->
                                        where('year', $per_visita)->
                                        orderBy('mes', 'asc')->
                                        groupBy('mes')->get();

        //Descargas del artículo seleccionado mes a mes
        $per_descarga = $request->descargas_periodo ? $request->descargas_periodo : date('Y');
        $id_article = $request->form_article ? $request->form_article : $articulos->first()->id_articulo;
        
        $d_articulo = Articulo_Descarga::select('mes', 'FK_id_articulo', DB::raw('sum(total) as total'))->
                        where('year', $per_descarga)->
                        where('FK_id_articulo', $id_article)->
                        orderBy('mes', 'asc')->
                        groupBy('mes', 'FK_id_articulo')->get();

        //Edicion para el numero de descargas y visitas de sus articulos subidos
        $request->form_edicion ? $edicion = Edicion::find($request->form_edicion) : $edicion = Edicion::first();
        
        return view('panel_admin.articulos.stats', compact('articulos', 'descargas', 'visitas', 'autores', 'g_visitas', 'd_articulo', 'comentarios', 'archivos', 'ediciones', 'edicion' ,'per_visita', 'per_descarga', 'id_article'));
    }

    //APARTADO DEL RUD DEL CONTROLADOR

    //Retorno de la Imagen del Storage
    public function getImage($filename = null){

        if($filename){
            $exist = Storage::disk('public')->exists('articulos/'.$filename);

            if(!$exist)
                $file = Storage::disk('public')->get('crash.png');
            else
                $file = Storage::disk('public')->get('articulos/'.$filename);
        }
        else
            $file = Storage::disk('public')->get('crash.png');

        return new Response($file, 200);
    }

    //Retorno del Archivo del Storage
    public function getArchive($filename = null, $id_articulo = null){

        if($filename){
            $extension = pathinfo($filename)['extension'];

            $exist = Storage::disk('public')->exists('archivos/'.$filename);

            if(!$exist){
                $extension = null;
                $file = storage_path('app/public/crash.png');
            }
            else
                $file = storage_path('app/public/archivos/'.$filename);
        }
        else
            $file = storage_path('app/public/crash.png');
        
        $extension == "pdf" ? $extension = "application/pdf" : $extension = "image"; 

        //Suma de descarga a la edición
        DB::beginTransaction();
        try{
            $user = Auth::user();
            $rol = $user ? $user->urol->rol->nombre : "visitante";
            
            if($rol != "Administrador" && $id_articulo){

                $visita = Articulo_Descarga::where('FK_id_articulo', $id_articulo)->
                                where('mes', date('n'))->
                                where('year', date('Y'))->first();
                
                if($visita){
                    $visita->total += 1;
                    $visita->update();
                }
                else{
                    $visita = new Articulo_Descarga();
                    $visita->mes = date('n');
                    $visita->year = date('Y');
                    $visita->total = 1;
                    $visita->FK_id_articulo = $id_articulo;
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
                $validations["contenido_en"] = "required|string";
            }

            //Validando datos
            $validate = Validator::make($request->all(), $validations, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }
            
            //Siguio, entonces almacenamos la edición
            $datos = $request->all();

            //Almacenamiento de la Imagen
            if($request->hasFile('ruta_imagen_es')){
                $datos["ruta_imagen_es"] = $request->file('ruta_imagen_es')->store('articulos', 'public');
            }
            
            $articulo = Articulo::create($datos);
            
            //Almacenamiento de los Archivos
            foreach($request->archivos as $archivo){
                $save_archive = new Archivo();
                $save_archive->FK_id_articulo  = $articulo->id_articulo;
                $save_archive->nombre = $archivo->getClientOriginalName();
                $save_archive->tipo = $archivo->extension();

                //Guardo el Archivo
                $save_archive->ruta_archivo_es = $archivo->store('archivos', 'public');

                $save_archive->save();
            }

            //Envio de la Notificación
            $notificacion = new Notificacion();
            
            //Información General de la Notificación
            $notificacion->titulo = "Creación de un nuevo artículo!!";
            $notificacion->descripcion = $articulo->titulo;
            $notificacion->ruta = route('articulo.view', $articulo->id_articulo);
            $notificacion->icono = "fa-book";
            $notificacion->save();

            //Enviamos el Helper que asigna la notificación a los usuarios Admin y Editor
            $titulo = "!!Se ha creado un nuevo artículo!!";
            $contenido = $articulo->titulo;
            AdminNotificacion::Notifica($notificacion, $titulo, $contenido);

            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return redirect()->route('articulo.index')->with('success', 'El Artículo fue almacenado de manera exitosa ya puedes verla entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El Artículo no pudo ser creado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
    
    //Update de un Artículo
    public function update(Request $request, $id_articulo){
        
        DB::beginTransaction();
        try{

            $validations = $this->validations;

            if($request->editEnglish){
                $validations["titulo_en"] = "required|string|min:3|max:255";
                $validations["contenido_en"] = "required|string";
            }
            
            //Validando datos
            $validate = Validator::make($request->all(), $this->validations, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos la edición
            $datos = $request->all();
            
            $articulo = Articulo::find($id_articulo);

            //Almacenamiento de la Imagen
            if($request->hasFile('ruta_imagen')){
                Storage::delete(['public/'.$articulo->ruta_imagen_es]);
                $datos["ruta_imagen_es"] = $request->file('ruta_imagen_es')->store('ediciones', 'public');
            }
            else{
                unset($datos['ruta_imagen_es']);
            }
            
            $articulo->update($datos);

            if($request->editArchive){
                //Edición o eliminación de los antiguos archivos
                $archivos = Archivo::whereNotIn('ruta_archivo_es', $request->loaded)->get();
                foreach($archivos as $archivo){
                    Storage::delete(['public/'.$archivo->ruta_archivo_es]);
                    Storage::delete(['public/'.$archivo->ruta_archivo_en]);
                    $archivo->delete();
                }

                //Almacenamiento de los nuevos Archivos
                foreach($request->archivos as $archivo){
                    $save_archive = new Archivo();
                    $save_archive->FK_id_articulo  = $articulo->id_articulo;
                    $save_archive->nombre = $archivo->getClientOriginalName();
                    $save_archive->tipo = $archivo->extension();

                    //Guardo el Archivo
                    $save_archive->ruta_archivo_es = $archivo->store('archivos', 'public');

                    $save_archive->save();
                }
            }
            
            //Envio de la Notificación
            $notificacion = new Notificacion();
            
            //Información General de la Notificación
            $notificacion->titulo = "Edición de un artículo!!";
            $notificacion->descripcion = $articulo->titulo;
            $notificacion->ruta = route('articulo.view', $articulo->id_articulo);
            $notificacion->icono = "fa-book";
            $notificacion->save();

            //Enviamos el Helper que asigna la notificación a los usuarios Admin y Editor
            $titulo = "!!Se ha editado un artículo!!";
            $contenido = $articulo->titulo;
            AdminNotificacion::Notifica($notificacion, $titulo, $contenido);

            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return redirect()->route('articulo.index')->with('success', 'El Artículo fue editado de manera exitosa ya puedes ver sus cambios entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El Artículo no pudo ser actualizado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Destroy de un Artículo
    public function destroy($id_articulo){
        
        DB::beginTransaction();
        try{

            $articulo = Articulo::find($id_articulo);

            if(!$articulo)
            return redirect()->route('articulo.index')->with('warning', 'El artículo no pudo ser eliminado debido a que no pudo ser encontrado');

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

            //Envio de la Notificación
            $notificacion = new Notificacion();
            
            //Información General de la Notificación
            $notificacion->titulo = "Eliminación de un artículo!!";
            $notificacion->descripcion = $articulo->titulo;
            $notificacion->ruta = route('articulo.index');
            $notificacion->icono = "fa-book";
            $notificacion->save();

            //Enviamos el Helper que asigna la notificación a los usuarios Admin y Editor
            $titulo = "!!Se ha eliminado un artículo!!";
            $contenido = $articulo->titulo;
            AdminNotificacion::Notifica($notificacion, $titulo, $contenido);

            //Aceptamos la eliminación de todo y redireccionamos
            DB::commit();
            return redirect()->route('articulo.index')->with('success', 'El Artículo fue eliminado de manera exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El Artículo no pudo ser eliminado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
}
