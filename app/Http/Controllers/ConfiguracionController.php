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
use App\Models\Informacion;
use App\Models\Perfil;
use App\Models\Rol;
use App\Models\User;
use App\Models\Usuario_Rol;
use App\Models\Usuario_Tipo;
use Illuminate\Contracts\Cache\Store;

//HELPER DE NOTIFICACION

//MAILABLE

class ConfiguracionController extends Controller
{
    //Cambio de idioma y activación de plugin
    public function setlocale($locale){
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }

    //VALIDACIONES
    public $validations = [
        "nombre" => "required|string|min:3|max:255|unique:rol,nombre",
    ];

    //MENSAJES DE ERROR
    public $error_messages = [
        "required" => "El dato es requerido",
        "string" => "El dato debe poseer caracteres alfanúmericos",
        "email" => "El dato debe ser enviado en formato corre (ejemplo@correo.com)",
        "numeric" => "El dato solo debe poseer datos númericos",
        "nullable" => "El dato puede viajar vacio",
        "unique" => "El nombre enviado ya se encuentra registrado",
        "max" => "El dato debe poseer menos de 255 caracteres",
        "nombre.min" => "El nombre debe poseer al menos 3 caracteres",
        "titulo.min" => "El nombre debe poseer al menos 3 caracteres",
        "nombre_update.min" => "El nombre debe poseer al menos 3 caracteres",
        "ruta_imagen.max" => "La Imagen no debe pesar más de 2 Mb",
        "file" => "El dato debe ser enviado como un archivo",
        "mime" => "El archivo debe llegar en formato png, jpg y jpeg",
        "required" => "El dato es requerido",
        "ruta_archivo.max" => "Los Documentos no deben pesar más de 10 Mb",
        "ruta_archivo.mimes" => "Los Documentos deben ser en formato png, jpg, jpeg, o pdf",
    ];

    //VISUALES DEL SISTEMA REDIRECCIONAMIENTO
    
    //Visual de los Roles
    public function roles(){
        $roles = Rol::all();
        $urols = Usuario_Rol::where('FK_id_rol', '<>', '1')->get();
        $usuarios = User::all();

        return view('panel_admin.configuracion.roles', compact('roles', 'usuarios', 'urols'));
    }

    //Visual de Tipos de Usuarios
    public function tipos(){
        $tipos = Usuario_Tipo::all();
        $perfiles = Perfil::all();

        return view('panel_admin.configuracion.tipos', compact('tipos', 'perfiles'));
    }
    
    //Visual de Información en Acerca de...
    public function informaciones(){
        $informaciones = Informacion::paginate(10);
        
        return view('panel_admin.configuracion.informaciones', compact('informaciones'));
    }

    //APARTADO DEL RUD DEL CONTROLADOR

    ///////ROLES
        //Store de un Nuevo Rol
        public function storeRol(Request $request){
            
            DB::beginTransaction();
            try{
                
                //Validando datos
                $validate = Validator::make($request->all(), $this->validations, $this->error_messages);
                if($validate->fails()){
                    return Redirect::back()->withErrors($validate)->withInput();
                }

                //Siguio, entonces almacenamos el rol
                $datos = $request->all();
                $rol = Rol::create($datos);
                
                //Aceptamos la creación de todo y redireccionamos
                DB::commit();
                return redirect()->route('configuracion.roles')->with('success', 'El Rol fue almacenado de manera exitosa ya puedes verla entre los registros');

            }catch(QueryException $e){
                DB::rollBack();
                return Redirect::back()->with('bderror', 'El Rol no pudo ser creado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
            }
        }

        //Update de un Rol
        public function updateRol(Request $request){
            
            DB::beginTransaction();
            try{

                $validaciones = [
                    "nombre_update" => "required|string|min:3|max:255|unique:rol,nombre,".$request->id_update.",id_rol",
                    "id_update" => "required",
                ];
                //Validando datos
                $validate = Validator::make($request->all(), $validaciones, $this->error_messages);
                if($validate->fails()){
                    return Redirect::back()->withErrors($validate, 'update')->withInput();
                }

                //Siguio, entonces almacenamos la edición
                $datos = $request->all();
                $rol = Rol::find($request->id_update);

                if(!$rol){
                    return redirect()->route('configuracion.roles')->with('warnning', 'El Rol a editar no pudo ser encontrado dentro de los registros');
                }
                
                $rol->nombre = $request->nombre_update;
                $rol->update($datos);

                //Envio de la Notificación
                
                //Aceptamos la creación de todo y redireccionamos
                DB::commit();
                return redirect()->route('configuracion.roles')->with('success', 'El Rol fue editado de manera exitosa ya puedes ver sus cambios entre los registros');

            }catch(QueryException $e){
                DB::rollBack();
                return Redirect::back()->with('bderror', 'El Rol no pudo ser actualizado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
            }
        }

        //Destroy de un Rol
        public function destroyRol($id_rol){
            
            DB::beginTransaction();
            try{

                $rol = Rol::find($id_rol);

                if(!$rol)
                return redirect()->route('configuracion.roles')->with('warning', 'El rol no pudo ser eliminado debido a que no pudo ser encontrado');

                //Elimino los Usuario_Rol bajo ese FK_id_rol
                Usuario_Rol::where('FK_id_rol', $id_rol)->count();
                
                //Eliminamos finalmente el rol
                $rol->delete();

                //Aceptamos la eliminación de todo y redireccionamos
                DB::commit();
                return redirect()->route('configuracion.roles')->with('success', 'El rol fue eliminado de manera exitosa');

            }catch(QueryException $e){
                DB::rollBack();
                return Redirect::back()->with('bderror', 'El rol no pudo ser eliminado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
            }
        }

    ///////TIPOS DE USUARIOS
        //Store de un Nuevo Tipo
        public function storeTipo(Request $request){
            
            DB::beginTransaction();
            try{
                
                //Validando datos
                $validate = Validator::make($request->all(), $this->validations, $this->error_messages);
                if($validate->fails()){
                    return Redirect::back()->withErrors($validate)->withInput();
                }

                //Siguio, entonces almacenamos el tipo de usuario
                $datos = $request->all();
                $tipo = Usuario_Tipo::create($datos);
                
                //Aceptamos la creación de todo y redireccionamos
                DB::commit();
                return redirect()->route('configuracion.tipos')->with('success', 'El Tipo de Usuario fue almacenado de manera exitosa ya puedes verla entre los registros');

            }catch(QueryException $e){
                DB::rollBack();
                return Redirect::back()->with('bderror', 'El Tipo de Usuario no pudo ser creado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
            }
        }

        //Update de un Tipo
        public function updateTipo(Request $request){
            
            DB::beginTransaction();
            try{

                $validaciones = [
                    "nombre_update" => "required|string|min:3|max:255|unique:usuario_tipo,nombre,".$request->id_update.",id_tipo",
                    "id_update" => "required",
                ];
                //Validando datos
                $validate = Validator::make($request->all(), $validaciones, $this->error_messages);
                if($validate->fails()){
                    return Redirect::back()->withErrors($validate, 'update')->withInput();
                }

                //Siguio, entonces almacenamos la edición
                $datos = $request->all();
                $tipo = Usuario_Tipo::find($request->id_update);

                if(!$tipo){
                    return redirect()->route('configuracion.tipos')->with('warnning', 'El Tipo de Usuario a editar no pudo ser encontrado dentro de los registros');
                }
                
                $tipo->nombre = $request->nombre_update;
                $tipo->update($datos);

                //Envio de la Notificación
                
                //Aceptamos la creación de todo y redireccionamos
                DB::commit();
                return redirect()->route('configuracion.tipos')->with('success', 'El Tipo de Usuario fue editado de manera exitosa ya puedes ver sus cambios entre los registros');

            }catch(QueryException $e){
                DB::rollBack();
                return Redirect::back()->with('bderror', 'El Tipo de Usuario no pudo ser actualizado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
            }
        }

        //Destroy de un Tipo
        public function destroyTipo($id_tipo){
            
            DB::beginTransaction();
            try{

                $tipo = Usuario_Tipo::find($id_tipo);

                if(!$tipo)
                    return redirect()->route('configuracion.tipos')->with('warning', 'El tipo de usuario no pudo ser eliminado debido a que no pudo ser encontrado');

                //Hacemos update de los perfiles que tienen este tipo de usuario
                Perfil::where('FK_id_tipo', $id_tipo)->update(['FK_id_tipo' => null]);
                
                //Eliminamos finalmente el rol
                $tipo->delete();

                //Aceptamos la eliminación de todo y redireccionamos
                DB::commit();
                return redirect()->route('configuracion.tipos')->with('success', 'El tipo de usuario fue eliminado de manera exitosa');

            }catch(QueryException $e){
                DB::rollBack();
                return Redirect::back()->with('bderror', 'El tipo de usuario no pudo ser eliminado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
            }
        }

    ////////INFORMACIONES
        //Retorno del Archivo del Storage
        public function getArchive($filename = null){

            if($filename){
                $extension = pathinfo($filename)['extension'];

                $exist = Storage::disk('public')->exists('informacion/'.$filename);

                if(!$exist){
                    $extension = null;
                    $file = storage_path('app/public/crash.png');
                }
                else
                    $file = storage_path('app/public/informacion/'.$filename);
            }
            else
                $file = storage_path('app/public/crash.png');
            
            $extension == "pdf" ? $extension = "application/pdf" : $extension = "image"; 

            return Response(file_get_contents($file), 200, [
                'Content-Type' => $extension,
                'Content-Disposition' => 'inline; filename="'.$file.'"'
            ]);
        }

        //Visual de Creación
        public function create(){
            $informacion = null;
            return view('panel_admin.configuracion.info_create_edit', compact('informacion'));
        }

        //Visual de Editar Información
        public function edit($id_informacion){
            $informacion = Informacion::find($id_informacion);

            if(!$informacion)
                return redirect()->route('configuracion.informaciones')->with('warning', 'La información seleccionada no pudo ser encontrada, por favor intentalo nuevamente');

            return view('panel_admin.configuracion.info_create_edit', compact('informacion'));
        }

        //Store de una Nueva Información
        public function storeInfo(Request $request){
            
            DB::beginTransaction();
            try{
                            
                //VALIDACIONES
                $validations = [
                    "titulo" => "required|string|min:3|max:255",
                    "contenido" => "required|string",
                    "ruta_archivo" => "file|mimes:jpg,jpeg,png,pdf|max:10240|",
                ];

                //Validando datos
                $validate = Validator::make($request->all(), $validations, $this->error_messages);
                if($validate->fails()){
                    return Redirect::back()->withErrors($validate)->withInput();
                }
                
                //Siguio, entonces almacenamos la edición
                $datos = $request->all();

                //Almacenamiento del archivo
                if($request->hasFile('ruta_archivo')){
                    $datos["ruta_archivo"] = $request->file('ruta_archivo')->store('informacion', 'public');
                }
                
                $informacion = Informacion::create($datos);

                //Envio de la Notificación

                //Aceptamos la creación de todo y redireccionamos
                DB::commit();
                return redirect()->route('configuracion.informaciones')->with('success', 'La Información fue almacenada de manera exitosa ya puedes verla entre los registros');

            }catch(QueryException $e){
                DB::rollBack();
                return Redirect::back()->with('bderror', 'La Información no pudo ser creada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
            }
        }
        
        //Update de una Información
        public function updateInfo(Request $request, $id_informacion){
            
            DB::beginTransaction();
            try{

                //VALIDACIONES
                $validations = [
                    "titulo" => "required|string|min:3|max:255",
                    "contenido" => "required|string",
                    "ruta_archivo" => "file|mimes:jpg,jpeg,png,pdf|max:10240|",
                ];

                //Validando datos
                $validate = Validator::make($request->all(), $validations, $this->error_messages);
                if($validate->fails()){
                    return Redirect::back()->withErrors($validate)->withInput();
                }

                //Siguio, entonces almacenamos la información
                $datos = $request->all();
                $informacion = Informacion::find($id_informacion);

                //Almacenamiento del Archivo
                if($request->hasFile('ruta_archivo') && $request->editArchive){
                    Storage::delete(['public/'.$informacion->ruta_archivo]);
                    $datos["ruta_archivo"] = $request->file('ruta_archivo')->store('informacion', 'public');
                }
                elseif($request->editArchive && !$request->has('loaded')){
                    Storage::delete(['public/'.$informacion->ruta_archivo]);
                    $datos["ruta_archivo"] = null;
                }
                elseif($request->hasFile('ruta_archivo') && !$request->has('editArchive')){
                    $datos["ruta_archivo"] = $request->file('ruta_archivo')->store('informacion', 'public');
                }
                else{
                    unset($datos['ruta_archivo']);
                }
                
                $informacion->update($datos);
                
                //Envio de la Notificación

                //Aceptamos la creación de todo y redireccionamos
                DB::commit();
                return Redirect::back()->with('success', 'La Información fue editada de manera exitosa ya puedes ver sus cambios entre los registros');

            }catch(QueryException $e){
                DB::rollBack();
                return Redirect::back()->with('bderror', 'La Información no pudo ser actualizada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
            }
        }

        //Destroy de una Información
        public function destroyInfo($id_informacion){
            
            DB::beginTransaction();
            try{

                $informacion = Informacion::find($id_informacion);

                if(!$informacion)
                return redirect()->route('configuracion.informaciones')->with('warning', 'La información no pudo ser eliminada debido a que no pudo ser encontrado');

                //elimino el archivo anclado
                Storage::delete(['public/'.$informacion->ruta_archivo]);
                $informacion->delete();

                //Aceptamos la eliminación de todo y redireccionamos
                DB::commit();
                return redirect()->route('configuracion.informaciones')->with('success', 'La información fue eliminada de manera exitosa');

            }catch(QueryException $e){
                DB::rollBack();
                return Redirect::back()->with('bderror', 'La información no pudo ser eliminada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
            }
        }
}
