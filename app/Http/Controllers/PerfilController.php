<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

//MODELOS
use App\Models\Modulo;
use App\Models\Perfil;
use App\Models\Rol;
use App\Models\User;
use App\Models\Usuario_Permiso;
use App\Models\Usuario_Rol;
use App\Models\Usuario_Tipo;

//HELPER DE NOTIFICACION

//MAILABLE

class PerfilController extends Controller
{
    //VALIDACIONES
    public $validations = [
        "nombre" => "required|string|min:3|max:255",
        "apellido" => "required|string|min:3|max:255",
        "email" => "required|string|max:255|email|unique:users,email",
        "direccion" => "nullable|string",
        "telefono" => "nullable|numeric|digits_between:5,15",
        "last_password" => "required|string|min:5|max:255",
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
        "last_password.min" => "La contraseña debe poseer al menos 5 caracteres",
        "password.min" => "La contraseña debe poseer al menos 5 caracteres",
        "same" => "La confirmación no coincide con la contraseña",
    ];

    //VISUALES DEL SISTEMA REDIRECCIONAMIENTO

    //Visual de Editar Usuario
    public function edit(){
        $usuario = Auth::user();
        $tipos = Usuario_Tipo::all();
        $roles = Rol::all();
        $modulos = Modulo::all();

        if(!$usuario)
            return redirect()->route('dashboard')->with('warning', 'El perfil no pudo ser encontrado, por favor intentalo nuevamente');

        return view('panel_admin.perfil.edit', compact('usuario', 'tipos', 'roles', 'modulos'));
    }

    //APARTADO DEL RUD DEL CONTROLADOR

    //Update de un Usuario
    public function update(Request $request){
        
        DB::beginTransaction();
        try{
            $usuario = Auth::user();
            if(!$usuario)
                return redirect()->route('usuario.index')->with('warning', 'El Usuario a editar no pudo ser encontrado, por favor intenta con un nuevo artículo');

            $validaciones = $this->validations;
            $validaciones["email"] = "required|string|max:255|email|unique:users,email,".$usuario->id.",id";

            //Dejo o quito las validacion de last passsword, password y confirm_password
            if(!$request->editPass){
                unset($validaciones["password"]);
                unset($validaciones["password_confirmation"]);
            }
            
            //Validando datos
            $validate = Validator::make($request->all(), $validaciones, $this->error_messages);
            if($validate->fails()){
                return redirect()->route('perfil.edit')->withErrors($validate)->withInput();
            }
            
            if (!Hash::check($request->last_password, $usuario->password)) {
                return redirect()->route('perfil.edit')->with('bderror', 'La contraseña antigua no coincide con los registros para validar la actualización de los datos.');
            }
            
            //Hacemos Update del Perfil
            $perfil = $usuario->perfil;
            $perfil->nombre = $request->nombre;
            $perfil->apellido = $request->apellido;
            $perfil->direccion = $request->direccion ? $request->direccion : null;
            $perfil->telefono = $request->telefono ? $request->code."".$request->telefono : null;
            $perfil->update();
            
            //Creamos el usuario primero.
            $usuario->name     = $request->nombre." ".$request->apellido;
            $usuario->email    = $request->email;
            if($request->editPass){
                $usuario->password = Hash::make($request->password);
            }
            $usuario->update();
        
            //Envio de la Notificación
            
            DB::commit();
            return redirect()->route('perfil.edit')->with('success', 'El Perfil fue actualizado de manera exitosa ya puedes ver sus cambios!!');

        }catch(QueryException $e){
            DB::rollBack();
            return redirect()->route('perfil.edit')->with('bderror', 'El Perfil no pudo ser actualizado debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
}
