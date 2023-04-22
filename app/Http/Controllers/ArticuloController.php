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
use App\Models\Autor;
use App\Models\Conocimiento;
use App\Models\Edicion;
use Illuminate\Contracts\Cache\Store;

//HELPER DE NOTIFICACION

//MAILABLE

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
        "archivos.*" => "file|mimes:jpg,jpeg,png,pdf|max:10240|",
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
        "ruta_imagen_es.max" => "La Imagen no debe pesar más de 2 Mb",
        "ruta_imagen_es.mimes" => "El archivo debe ser en formato png, jpg y jpeg",
        "archivos.*.max" => "Los Documentos no deben pesar más de 10 Mb",
        "archivos.*.mimes" => "Los Documentos deben ser en formato png, jpg, jpeg, o pdf",
        "file" => "El dato debe ser enviado como un archivo",
    ];

    //VISUALES DEL SISTEMA REDIRECCIONAMIENTO

    //Visual primer Index
    public function index($id_edicion = 0){
        $ediciones = Edicion::all();
        $nombre = "";

        if(!$id_edicion)
            $articulos = Articulo::paginate(6);
        else{
            $edicion = $ediciones->find($id_edicion);

            if($edicion){
                $nombre = $edicion->titulo;
                $articulos = Articulo::where('FK_id_edicion', $id_edicion)->get();
            }
            else
                $articulos = Articulo::paginate(6);
        }
        
        return view('panel_admin.articulos.index', compact('ediciones', 'articulos', 'nombre'));
    }

    //Visual Tabla con todos los artículos
    public function all_articles(){
        $articulos = Articulo::all();
        return view('panel_admin.articulos.all', compact('articulos'));
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

            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return redirect()->route('articulo.index')->with('success', 'El Artículo fue almacenado de manera exitosa ya puedes verla entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El Artículo no pudo ser creado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
}
