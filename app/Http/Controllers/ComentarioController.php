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
use App\Models\Comentario;
use App\Models\Respuesta;
use Illuminate\Contracts\Cache\Store;

//HELPER DE NOTIFICACION

//MAILABLE

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

        if($comentarios){
            //Articulo con más Comentarios
            $articulo = Comentario::select('FK_id_articulo', DB::raw('count(*) as total'))
                        ->groupBy('FK_id_articulo')->orderBy('total', 'desc')->first();
            $articulo = $articulo->articulo;

            //Top Usuarios con más comentarios
            $usuarios = Comentario::select('FK_id_usuario', DB::raw('count(*) as total'))
                        ->groupBy('FK_id_usuario')->orderBy('total', 'desc')->get();
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

    //Visual de Editar Edición
    public function edit($id_autor){
        $autor = Autor::findOrFail($id_autor);
        return view('panel_admin.autores.create_edit', compact('autor'));
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

    //Store de una Nueva Edicion
    public function store(Request $request){
        
        DB::beginTransaction();
        try{
            
            //Validando datos
            $validate = Validator::make($request->all(), $this->validations, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos el autor
            $datos = $request->all();
            //Envio de la Notificación

            //Almacenamiento de la Imagen
            if($request->hasFile('ruta_imagen')){
                $datos["ruta_imagen"] = $request->file('ruta_imagen')->store('autores', 'public');
            }
            
            $autor = Autor::create($datos);
            
            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return redirect()->route('autor.index')->with('success', 'El Autor fue almacenado de manera exitosa ya puedes verla entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El Autor no pudo ser creado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Update de un Comentario
    public function coUpdate(Request $request, $id_autor){
        
        DB::beginTransaction();
        try{

            $validaciones = $this->validations;
            $validaciones["email"] = "nullable|email|min:0|unique:autor,email,".$id_autor.",id_autor";

            //Validando datos
            $validate = Validator::make($request->all(), $validaciones, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos la edición
            $datos = $request->all();
            
            $autor = Autor::findOrFail($id_autor);
            //Envio de la Notificación
            
            //Almacenamiento de la Imagen
            if($request->hasFile('ruta_imagen')){
                Storage::delete(['public/'.$autor->ruta_imagen]);
                $datos["ruta_imagen"] = $request->file('ruta_imagen')->store('autores', 'public');
            }
            else{
                unset($datos['ruta_imagen']);
            }
            
            $autor->update($datos);
            
            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return redirect()->route('autor.index')->with('success', 'El autor fue editado de manera exitosa ya puedes ver sus cambios entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El autor no pudo ser actualizado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
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

    //Update de un Comentario
    public function reUpdate(Request $request, $id_autor){
        
        DB::beginTransaction();
        try{

            $validaciones = $this->validations;
            $validaciones["email"] = "nullable|email|min:0|unique:autor,email,".$id_autor.",id_autor";

            //Validando datos
            $validate = Validator::make($request->all(), $validaciones, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos la edición
            $datos = $request->all();
            
            $autor = Autor::findOrFail($id_autor);
            //Envio de la Notificación
            
            //Almacenamiento de la Imagen
            if($request->hasFile('ruta_imagen')){
                Storage::delete(['public/'.$autor->ruta_imagen]);
                $datos["ruta_imagen"] = $request->file('ruta_imagen')->store('autores', 'public');
            }
            else{
                unset($datos['ruta_imagen']);
            }
            
            $autor->update($datos);
            
            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return redirect()->route('autor.index')->with('success', 'El autor fue editado de manera exitosa ya puedes ver sus cambios entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El autor no pudo ser actualizado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Destroy de un Comentario
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
}
