<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

//MODELOS
use App\Models\Archivo;
use App\Models\Articulo;
use App\Models\Autor;
use App\Models\Conocimiento;
use App\Models\Edicion;
use App\Models\Modulo;
use App\Models\Perfil;
use App\Models\Respuesta;
use App\Models\Rol;
use App\Models\User;
use App\Models\Usuario_Permiso;
use App\Models\Usuario_Rol;
use App\Models\Usuario_Tipo;
use Illuminate\Contracts\Cache\Store;

//HELPER DE NOTIFICACION

//MAILABLE

class UsuariosController extends Controller
{
    //VALIDACIONES
    public $validations = [
        "nombre" => "required|string|min:3|max:255",
        "apellido" => "required|string|min:3|max:255",
        "email" => "required|string|max:255|email|unique:users,email",
        "direccion" => "nullable|string",
        "telefono" => "nullable|numeric|digits_between:5,15",
        "FK_id_tipo" => "required|numeric",
        "FK_id_rol" => "required|numeric",
        "password" => "required|string|min:5|max:255",
        "password_confirmation" => "required|string|same:password",
    ];

    //MENSAJES DE ERROR
    public $error_messages = [
        "required" => "El dato es requerido",
        "string" => "El dato debe poseer caracteres alfanúmericos",
        "email" => "El dato debe ser enviado en formato corre (ejemplo@correo.com)",
        "numeric" => "El dato solo debe poseer datos númericos",
        "nullable" => "El dato puede viajar vacio",
        "unique" => "El dato enviado ya se encuentra registrado",
        "max" => "El dato debe poseer menos de 255 caracteres",
        "nombre.min" => "El nombre debe poseer al menos 3 caracteres",
        "apellido.min" => "El apellido debe poseer al menos 3 caracteres",
        "telefono.digits_between" => "El teléfono debe tener una longitud entre 5 y 15 caracteres",
        "password.min" => "La contraseña debe poseer al menos 5 caracteres",
        "same" => "La confirmación no coincide con la contraseña",
    ];

    //VISUALES DEL SISTEMA REDIRECCIONAMIENTO

    //Visual primer Index
    public function index($id_rol = 0){
        $roles = Rol::all();
        $filtrado = null;
        
        if(!$id_rol)
            $usuarios = User::paginate(10);
        else{
            $rol = $roles->find($id_rol);
            $filtrado = true;

            if($rol){
                $nombre = $rol->titulo;

                $usuarios = User::whereIn('id', Usuario_Rol::select(['FK_id_usuario'])
                    ->where('FK_id_rol', $id_rol)
                )->paginate(10);
            }
            else
                $usuarios = User::paginate(10);
        }
        
        return view('panel_admin.usuarios.index', compact('usuarios', 'roles', 'filtrado', 'id_rol'));
    }

    //Visual de un solo usuario
    public function view($id_user){
        $usuario = User::find($id_user);

        if(!$usuario)
            return redirect()->route('usuario.index')->with('warning', 'El Usuario para visualizar no pudo ser encontrado, por favor intenta con un nuevo artículo');

        return view('panel_admin.usuarios.view', compact('usuario'));
    }

    //Visual de Creación
    public function create(){
        $usuario = null;
        $tipos = Usuario_Tipo::all();
        $roles = Rol::all();
        $modulos = Modulo::all();

        if($tipos && $roles)
            return view('panel_admin.usuarios.create_edit', compact('usuario', 'tipos', 'roles', 'modulos'));
        else
            return redirect()->route('usuario.index')->with('warning', 'No puedes cargar usuarios hasta que no haya roles o tipos de usuario definidos');
    }

    //Visual de Editar Usuario
    public function edit($id_usuario){
        $usuario = User::find($id_usuario);
        $tipos = Usuario_Tipo::all();
        $roles = Rol::all();
        $modulos = Modulo::all();

        if(!$usuario)
            return redirect()->route('usuario.index')->with('warning', 'El usuario seleccionado no pudo ser encontrado, por favor intentalo nuevamente');

        return view('panel_admin.usuarios.create_edit', compact('usuario', 'tipos', 'roles', 'modulos'));
    }

    //APARTADO DEL RUD DEL CONTROLADOR

    //Store de un Usuario
    public function store(Request $request){
        
        DB::beginTransaction();
        try{
            
            //Validando datos
            $validate = Validator::make($request->all(), $this->validations, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }
            
            //Creamos el usuario primero.
            $user = new User();
            $user->name     = $request->nombre." ".$request->apellido;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            //Geramos los datos del perfil
            $perfil = new Perfil();
            $perfil->nombre = $request->nombre;
            $perfil->apellido = $request->apellido;
            $perfil->direccion = $request->direccion ? $request->direccion : null;
            $perfil->telefono = $request->telefono ? $request->code."".$request->telefono : null;
            $perfil->FK_id_usuario = $user->id;
            $perfil->FK_id_tipo = $request->FK_id_tipo;
            $perfil->save();

            //Generamos sus roles
            $user_rol = new Usuario_Rol();
            $user_rol->FK_id_usuario = $user->id;
            $user_rol->FK_id_rol = $request->FK_id_rol;
            $user_rol->save();

            //Generamos Permisos
            //EN PAUSA POR EL MOMENTO

            //NOTIFICACION DE USUARIO CREADO

            //Aceptamos la creación de todo y redireccionamos
            DB::commit();
            return redirect()->route('usuario.index')->with('success', 'El Usuario fue almacenado de manera exitosa ya puedes verla entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El Usuario no pudo ser creado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
    
    //Update de un Usuario
    public function update(Request $request, $id_usuario){
        
        DB::beginTransaction();
        try{
            $validaciones = $this->validations;
            $validaciones["email"] = "required|string|max:255|email|unique:users,email,".$id_usuario.",id";

            //Dejo o quito las validacion de password y confirm_password
            if(!$request->editPass){
                unset($validaciones["password"]);
                unset($validaciones["password_confirmation"]);
            }
            
            //Validando datos
            $validate = Validator::make($request->all(), $validaciones, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput();
            }

            //Siguio, entonces almacenamos la edición
            $datos = $request->all();

            $usuario = User::find($id_usuario);
            if(!$usuario)
                return redirect()->route('usuario.index')->with('warning', 'El Usuario a editar no pudo ser encontrado, por favor intenta con un nuevo artículo');
            
            //Hacemos Update del Perfil
            $perfil = $usuario->perfil;
            $perfil->nombre = $request->nombre;
            $perfil->apellido = $request->apellido;
            $perfil->direccion = $request->direccion ? $request->direccion : null;
            $perfil->telefono = $request->telefono ? $request->code."".$request->telefono : null;
            $perfil->FK_id_tipo = $request->FK_id_tipo;
            $perfil->update();

            //Generamos sus roles
            $user_rol = $usuario->urol;
            $user_rol->FK_id_rol = $request->FK_id_rol;
            $user_rol->update();
            
            //Creamos el usuario primero.
            $usuario->name     = $request->nombre." ".$request->apellido;
            $usuario->email    = $request->email;
            if($request->editPass){
                $usuario->password = Hash::make($request->password);
            }
            $usuario->update();
            
            //Envio de la Notificación
            
            DB::commit();
            return Redirect::back()->with('success', 'El Usuario fue editado de manera exitosa ya puedes ver sus cambios entre los registros');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El Usuario no pudo ser actualizado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Destroy de un Usuario
    public function destroy($id_user){
        
        DB::beginTransaction();
        try{

            $usuario = User::find($id_user);

            if(!$usuario)
            return redirect()->route('usuario.index')->with('warning', 'El usuario no pudo ser eliminado debido a que no pudo ser encontrado');

            //Elimino el rol y el perfil
            $usuario->perfil->delete();
            $usuario->urol->delete();

            //elimino los permisos y respuestas
            Usuario_Permiso::where('FK_id_usuario', $usuario->id)->delete();
            Respuesta::where('FK_id_usuario', $usuario->id)->delete();

            //Elimino sus notificaciones
            foreach($usuario->notificaciones as $unotificacion){
                $noti = $unotificacion->notificacion;
                $unotificacion->delete();
                $noti->delete();
            }

            //recorro comentarios y consecuentemente sus respuestas y borro
            foreach($usuario->comentarios as $comentario){
                foreach($comentario->respuestas as $respuesta){
                    $respuesta->delete();
                }
                $comentario->delete();
            }

            $usuario->delete();

            //Aceptamos la eliminación de todo y redireccionamos
            DB::commit();
            return redirect()->route('usuario.index')->with('success', 'El usuario fue eliminado de manera exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El usuario no pudo ser eliminado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
}
