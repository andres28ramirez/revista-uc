<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class NewPasswordController extends Controller
{
    /* VALIDACIONES */
    public $validations = [
        "token" => "required",
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

    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    public function store(Request $request): RedirectResponse
    {
        //Validacón de creación nueva contraseña
        $validate = Validator::make($request->all(), $this->validations, $this->error_messages);
        if($validate->fails()){
            return Redirect::back()->withErrors($validate)->withInput();
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
