<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

//MODELOS
use App\Models\Perfil;
use App\Models\User;
use App\Models\Usuario_Rol;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class RegisteredUserController extends Controller
{
    /* VALIDACIONES */
    public $validations = [
        "name" => "required|string|min:3|max:255",
        "lastname" => "required|string|min:3|max:255",
        "telephone" => "nullable|numeric|digits_between:5,15",
        "address" => "nullable|string",
        "email" => "required|string|max:255|email|unique:users,email",
        "password" => "string|min:5|max:255",
        "password_confirmation" => "string|same:password",
    ];

    /* MENSAJES DE ERROR */
    public $error_messages = [
        "required" => "El dato es requerido",
        "string" => "El dato debe poseer caracteres alfanúmericos",
        "email" => "El dato debe ser enviado en formato corre (ejemplo@correo.com)",
        "numeric" => "El dato solo debe poseer datos númericos",
        "nullable" => "El dato puede viajar vacio",
        "unique" => "El dato enviado ya se encuentra registrado",
        "max" => "El dato debe poseer menos de 255 caracteres",
        "name.min" => "El nombre debe poseer al menos 3 caracteres",
        "lastname.min" => "El apellido debe poseer al menos 3 caracteres",
        "telephone.digits_between" => "El teléfono debe tener una longitud entre 5 y 15 caracteres",
        "password.min" => "La contraseña debe poseer al menos 5 caracteres",
        "same" => "La confirmación no coincide con la contraseña",
    ];

    /* FUNCIONES DEL CONTROLADOR */
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {

        DB::beginTransaction();
        try{
            //Validacón del registro
            $validate = Validator::make($request->all(), $this->validations, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate, 'register')->withInput();
            }
            
            //Todo fue en perfecto orden, así que hacemos el registro
            //Creamos el usuario primero.
            $user = new User();
            $user->name     = $request->name." ".$request->lastname;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            //Geramos los datos del perfil
            $perfil = new Perfil();
            $perfil->nombre = $request->name;
            $perfil->apellido = $request->lastname;
            $perfil->direccion = $request->address ? $request->address : null;
            $perfil->telefono = $request->telephone ? $request->telephone : null;
            $perfil->FK_id_usuario = $user->id;
            $perfil->FK_id_tipo = $request->user_tipo;
            $perfil->save();

            //Generamos sus roles por defecto
            $user_rol = new Usuario_Rol();
            $user_rol->FK_id_usuario = $user->id;
            $user_rol->FK_id_rol = 4;
            $user_rol->save();
            
            event(new Registered($user));

            Auth::login($user);
            DB::commit();

            return redirect(RouteServiceProvider::HOME);
        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'El usuario no pudo ser generado debido a un error interno, por favor intentalo más tarde. Código: '. $e->getCode());
        }
    }
}
