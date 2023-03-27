<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class RegisteredUserController extends Controller
{
    /* VALIDACIONES */
    public $validations = [
        "name" => "required|string|min:3|max:255",
        "lastname" => "required|string|min:3|max:255",
        "telephone" => "nullable|string|max:15",
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
        "number" => "El dato solo debe poseer datos númericos",
        "nullable" => "El dato puede viajar vacio",
        "unique" => "El dato enviado ya se encuentra registrado",
        "max" => "El dato debe poseer menos de 255 caracteres",
        "name.min" => "El nombre debe poseer al menos 3 caracteres",
        "lastname.min" => "El apellido debe poseer al menos 3 caracteres",
        "password.min" => "La contraseña debe poseer al menos 5 caracteres",
    ];

    /* FUNCIONES DEL CONTROLADOR */
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try{
            //Validacón del registro
            $validate = Validator::make($request->all(), $this->validations, $this->error_messages);
            if($validate->fails()){
                return Redirect::back()->withErrors($validate, 'register')->withInput();
            }
            return "perfecto";
            //Todo fue en perfecto orden, así que hacemos el registro
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        }catch(QueryException $e){
            DB::rollBack();
        }
    }
}
