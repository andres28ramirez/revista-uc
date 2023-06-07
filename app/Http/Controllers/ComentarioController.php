<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
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
use App\Models\Comentario;
use App\Models\Notificacion;
use App\Models\Respuesta;
use App\Models\User;
use App\Models\Usuario_Notificacion;

//NOTIFICACION Y MAILABLE
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;
use App\Helpers\AdminNotificacion;

class ComentarioController extends Controller
{
    //VALIDACIONES
    public $validations = [
        "nombre" => "required|string|min:3|max:255",
        "email" => "nullable|email|unique:autor,email",
        "grado" => "required|string|min:3|max:255",
        "sintesis" => "required|string",
        "ruta_imagen" => "file|mimes:jpg,jpeg,png|max:2100|",
    ];

    //MENSAJES DE ERROR
    public $error_messages = [
        "required" => "El dato es requerido",
        "string" => "El dato debe poseer caracteres alfanúmericos",
        "email" => "El dato debe ser enviado en formato corre (ejemplo@correo.com)",
        "numeric" => "El dato solo debe poseer datos númericos",
        "nullable" => "El dato puede viajar vacio",
        "unique" => "El email ya se encuentro registrado en otro Autor",
        "max" => "El dato debe poseer menos de 255 caracteres",
        "min" => "El dato debe poseer al menos 3 caracteres",
        "ruta_imagen.max" => "La Imagen no debe pesar más de 2 Mb",
        "file" => "El dato debe ser enviado como un archivo",
        "mimes" => "El archivo debe llegar en formato png, jpg y jpeg",
    ];

    //VISUALES DEL SISTEMA REDIRECCIONAMIENTO
    
    //Visual primer Index
    public function index(){
        $comentarios = Comentario::orderBy('created_at', 'desc')->get();
        
        if($comentarios->count() > 0){
            //Articulo con más Comentarios
            $articulo = Comentario::select('FK_id_articulo', DB::raw('count(*) as total'))
                        ->groupBy('FK_id_articulo')->orderBy('total', 'desc')->first();
            $articulo = $articulo->articulo;

            //Top Usuarios con más comentarios
            $usuarios = Comentario::select('FK_id_usuario', DB::raw('count(*) as total'))
                        ->groupBy('FK_id_usuario')->orderBy('total', 'desc')->paginate(10);
        }
        else{
            $comentarios = [];
            $articulo = [];
            $usuarios = [];
        }
        
        return view('panel_admin.comentarios.index', compact('comentarios', 'articulo', 'usuarios'));
    }

    //Visual de Creación
    public function create(){
        $autor = null;
        return view('panel_admin.autores.create_edit', compact('autor'));
    }

    //Visual de Editar Comentario
    public function coEdit($id_comentario){
        $info = Comentario::find($id_comentario);

        if(!$info)
            return redirect()->route('comentario.index')->with('warning', 'El comentario no pudo ser editado debido a que no pudo ser encontrado');

        $info->tipo = "comentario";
        $info->autor = $info->autor;
        $info->id = $info->id_comentario;

        $articulo = $info->articulo;

        return view('panel_admin.comentarios.edit', compact('info', 'articulo'));
    }

    //Visual de Editar Respuesta
    public function reEdit($id_respuesta){
        $info = Respuesta::findOrFail($id_respuesta);

        if(!$info)
            return redirect()->route('comentario.index')->with('warning', 'La respuesta no pudo ser editada debido a que no pudo ser encontrada');

        $info->tipo = "respuesta";
        $info->autor = $info->nombre;
        $info->id = $info->id_respuesta;

        $articulo = $info->comentario->articulo;

        return view('panel_admin.comentarios.edit', compact('info', 'articulo'));
    }

    //Visual de ver todos los comentarios con paginación y filtrado
    public function all_comments($id_usuario = null, $id_articulo = null, $id_estado = null){
        $usuarios = User::all();
        $articulos = Articulo::all();
        $filtrado = null;

        //Filtros de Busqueda
        if($id_usuario || $id_articulo || $id_estado) $filtrado = true;
        
        
        $query = Comentario::query();

        //Autor
        $query->when($id_usuario, function ($q, $id_usuario) {
            return $q->where('FK_id_usuario', $id_usuario);
        });

        //Conocimiento
        $query->when($id_articulo, function ($q, $id_articulo) {
            return $q->where('FK_id_articulo', $id_articulo);
        });

        //Edición
        $query->when($id_estado, function ($q, $id_estado) {
            return $q->where('estado', $id_estado);
        });

        $comentarios = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('panel_admin.comentarios.all', compact('comentarios', 'usuarios', 'articulos', 'filtrado', 'id_usuario', 'id_articulo', 'id_estado'));
    }

    //APARTADO DEL RUD DEL CONTROLADOR

    //Retorno de la Imagen del Storage
    public function getImage($filename = null){

        if($filename){
            $exist = Storage::disk('public')->exists('autores/'.$filename);

            if(!$exist)
                $file = Storage::disk('public')->get('crash.png');
            else
                $file = Storage::disk('public')->get('autores/'.$filename);
        }
        else
            $file = Storage::disk('public')->get('crash.png');

        return new Response($file, 200);
    }

    //Update de un Comentario
    public function coUpdate(Request $request, $id_comentario){
        
        DB::beginTransaction();
        try{

            $validaciones = [
                "estado" => "required",
            ];

            //Validando datos
            $validate = Validator::make($request->all(), $validaciones, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos la edición
            $datos = $request->all();
            $comentario = Comentario::find($id_comentario);
            
            if(!$comentario)
                return redirect()->route('comentario.index')->with('warning', 'El comentario no pudo ser editado debido a que no pudo ser encontrado');

            //Envio de la Notificación
            $user = $comentario->usuario;
            $ruta = route('user.articulo', $comentario->articulo->id_articulo);
            $titulo = "Tu comentario ya fue evaluado por un moderador en la plataforma";
            $contenido = "Tu comentario quedo en estado ".$request->estado.", dandole click al boton seras redireccionado al artículo de tu comentario";
            AdminNotificacion::UserNotifica($user, $ruta, $titulo, $contenido, $comentario);

            //Hacemos el Update
            $comentario->update($datos);
            
            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return Redirect::back()->with('success', 'El comentario fue editado de manera exitosa ya puedes ver sus cambios entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El comentario no pudo ser actualizado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Destroy de un Comentario
    public function coDestroy($id_comentario){
        
        DB::beginTransaction();
        try{

            $comentario = Comentario::find($id_comentario);

            if(!$comentario)
            return redirect()->route('comentario.index')->with('warning', 'El comentario no pudo ser eliminado debido a que no pudo ser encontrado');

            Respuesta::where('FK_id_comentario', $comentario->id_comentario)->delete();
            $comentario->delete();

            //Aceptamos la eliminación de todo y redireccionamos
            DB::commit();
            return redirect()->route('comentario.index')->with('success', 'El comentario fue eliminado de manera exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El comentario no pudo ser eliminado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Update de una Respuesta
    public function reUpdate(Request $request, $id_respuesta){
        
        DB::beginTransaction();
        try{

            $validaciones = [
                "estado" => "required",
            ];

            //Validando datos
            $validate = Validator::make($request->all(), $validaciones, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos la edición
            $datos = $request->all();
            $respuesta = Respuesta::find($id_respuesta);
            
            if(!$respuesta)
                return redirect()->route('comentario.index')->with('warning', 'La respuesta no pudo ser editada debido a que no pudo ser encontrado');

            //Envio de la Notificación
            $user = $respuesta->usuario;
            $ruta = route('user.articulo', $respuesta->comentario->articulo->id_articulo);
            $titulo = "Tu repuesta ya fue evaluado por un moderador en la plataforma";
            $contenido = "Tu respuesta quedo en estado ".$respuesta->estado.", dandole click al boton seras redireccionado al artículo de tu respuesta";
            AdminNotificacion::UserNotifica($user, $ruta, $titulo, $contenido, $respuesta);
            
            //Hacemos el Update
            $respuesta->update($datos);
            
            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return Redirect::back()->with('success', 'La respuesta fue editada de manera exitosa ya puedes ver sus cambios entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'La respuesta no pudo ser actualizada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Destroy de una Respuesta
    public function reDestroy($id_respuesta){
        
        DB::beginTransaction();
        try{

            $respuesta = Respuesta::find($id_respuesta);

            if(!$respuesta)
            return redirect()->route('comentario.index')->with('warning', 'La respuesta no pudo ser eliminada debido a que no pudo ser encontrada');

            $respuesta->delete();

            //Aceptamos la eliminación de todo y redireccionamos
            DB::commit();
            return redirect()->route('comentario.index')->with('success', 'La respuesta fue eliminada de manera exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'La respuesta no pudo ser eliminada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //OPCIONES DE USUARIOS
    
    //Store de un Nuevo Comentario
    public function storeCo(Request $request){
        
        DB::beginTransaction();
        try{
            
            $validations = [
                "contenido" => "required|string|min:3",
                "FK_id_articulo" => "required",
            ];

            //Validando datos
            $validate = Validator::make($request->all(), $validations, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate, 'comentario')->withInput();
            }

            //Siguio, entonces almacenamos el autor
            $datos = $request->all();
            $datos["autor"] = Auth::user()->name;
            $datos["FK_id_usuario"] = Auth::user()->id;
            $comentario = Comentario::create($datos);
            
            //Generamos la Notificación
            $notificacion = new Notificacion();
            
            //Información General de la Notificación
            $notificacion->titulo = "Creación de nuevo comentario, por usuario de nombre ".Auth::user()->name;
            $notificacion->descripcion = "En espera de hacerse update del estado del comentario";
            $notificacion->ruta = route('comentario.edit', $comentario->id_comentario);
            $notificacion->icono = "fa-comment";
            $notificacion->save();

            //Enviamos el Helper que asigna la notificación a los usuarios Admin y Editor
            $titulo = "Nuevo evento sobre la revista por comentario cargado en Artículo: ".$comentario->articulo->titulo;
            $contenido = "Dale click sobre el link entregado para redireccionarte al evento a través del Panel Administrativo";
            AdminNotificacion::Notifica($notificacion, $titulo, $contenido);

            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return Redirect::back()->with('success', 'Tu comentario fue enviado con exito, estara en evaluación para ser convalidado la visualización del mismo por varios usuarios');
        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'Tu comentario no pudo ser creado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Store de un Nueva Respuesta
    public function storeRe(Request $request){
        
        DB::beginTransaction();
        try{
            
            $validations = [
                "contenido" => "required|string|min:3",
                "FK_id_comentario" => "required",
            ];

            //Validando datos
            $validate = Validator::make($request->all(), $validations, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos el autor
            $datos = $request->all();
            $datos["nombre"] = Auth::user()->name;
            $datos["FK_id_usuario"] = Auth::user()->id;
            $respuesta = Respuesta::create($datos);

            //Generamos la Notificación
            $notificacion = new Notificacion();
            
            //Información General de la Notificación
            $notificacion->titulo = "Creación de nueva respuesta, por usuario de nombre ".Auth::user()->name;
            $notificacion->descripcion = "En espera de hacerse update del estado de la respuesta";
            $notificacion->ruta = route('respuesta.edit', $respuesta->id_respuesta);
            $notificacion->icono = "fa-comment";
            $notificacion->save();

            //Enviamos el Helper que asigna la notificación a los usuarios Admin y Editor
            $titulo = "Nuevo evento sobre la revista por respuesta cargada";
            $contenido = "Dale click sobre el link entregado para redireccionarte al evento a través del Panel Administrativo";
            AdminNotificacion::Notifica($notificacion, $titulo, $contenido);

            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return Redirect::back()->with('success', 'Tu respuesta fue enviada con exito, estara en evaluación para ser convalidada la visualización del mismo por varios usuarios');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'La Respuesta no pudo ser creada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
}
