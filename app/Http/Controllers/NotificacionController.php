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
use App\Models\Articulo;
use App\Models\Conocimiento;
use App\Models\Edicion;
use App\Models\Edicion_Descarga;
use App\Models\Edicion_Visita;
use App\Models\User;
use App\Models\Usuario_Notificacion;
use App\Models\Notificacion;

//NOTIFICACION Y MAILABLE
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;
use App\Helpers\AdminNotificacion;

class NotificacionController extends Controller
{
    //VALIDACIONES
    public $validations = [
        "titulo" => "required|string|min:3|max:255",
        "numero" => "required|numeric|min:0|unique:edicion,numero",
        "descripcion" => "required|string",
        "fecha" => "required",
        "periodo" => "required|string|min:3|max:255",
        "ruta_imagen" => "file|mimes:jpg,jpeg,png|max:2100|",
        "ruta_archivo" => "file|mimes:pdf,html|max:10240|",
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
        "periodo.min" => "El periodo debe poseer al menos 3 caracteres",
        "ruta_imagen.max" => "La Imagen no debe pesar más de 2 Mb",
        "ruta_archivo.max" => "La Imagen no debe pesar más de 10 Mb",
        "file" => "El dato debe ser enviado como un archivo",
        "ruta_imagen.mimes" => "El archivo debe llegar en formato png, jpg y jpeg",
        "ruta_archivo.mimes" => "El archivo debe llegar en formato pdf o html",
    ];

    //VISUALES DEL SISTEMA REDIRECCIONAMIENTO
    
    //Visual primer Index
    public function index(){
        $notificaciones = Auth::user()->notificaciones;
        return view('panel_admin.notificaciones.index', compact('notificaciones'));
    }

    //Redireccion más read at aplicado
    public function redireccion(Request $request){
        $link = $request->ruta;
        
        //Dejamos ahora la notificación en read
        $id = $request->notificacion;
        $notificacion = Usuario_Notificacion::find($id);

        if(!$notificacion)
            return redirect()->route('home')->with('warning', 'La notificación no pudo ser encontrada');

        $notificacion->read_at = date('Y-m-d h:i:s');
        $notificacion->save();

        return redirect($link);
    }

    //Leer o Desleer Notificación
    public function read($id_notificación){
        
        DB::beginTransaction();
        try{

            $notificacion = Usuario_Notificacion::find($id_notificación);

            if(!$notificacion)
                return redirect()->route('notificacion.index')->with('warning', 'La notificación no pudo ser encontrada, por favor intentalo de nuevo');

            //Actualizo su estado de acuerdo a si esta leido o no
                $notificacion->read_at ? $notificacion->read_at = null : $notificacion->read_at = date('Y-m-d h:i:s');
                $notificacion->save();

            DB::commit();
            return redirect()->route('notificacion.index')->with('success', 'El estado de la notificación fue actualizada de forma exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'La Notificación no pudo modificarse su estado, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Eliminar Notificación
    public function destroy($id_notificación){
        
        DB::beginTransaction();
        try{

            $notificacion = Usuario_Notificacion::find($id_notificación);

            if(!$notificacion)
                return redirect()->route('notificacion.index')->with('warning', 'La notificación no pudo ser encontrada, por favor intentalo de nuevo');

            //Eliminamos la notificación
                $notify = $notificacion->notificacion;
                $notificacion->delete();

            //Revisamos si la notificación en general se queda sin usuarios anclados
            if($notify->usuarios->count() <= 0)
                $notify->delete();

            //Aceptamos la eliminación de todo y redireccionamos
            DB::commit();
            return redirect()->route('notificacion.index')->with('success', 'La Notificación fue eliminada de manera exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'La Notificación no pudo ser eliminada debido a un error interno, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Cambiamos todas las notificaciones del usuario a LEIDO que fueron marcadas
    public function readAll(Request $request, $id_usuario){
        
        DB::beginTransaction();
        try{

            //Revisamos si ponemos todo en leido o no
            if($request->all){
                Usuario_Notificacion::where('FK_id_user', $id_usuario)->update(['read_at' => date('Y-m-d h:i:s')]);
            }
            else{ //en este caso no todos quedan en leidos
                Usuario_Notificacion::whereIn('id_usuario_notificacion', $request->boxes)->update(['read_at' => date('Y-m-d h:i:s')]);
            }

            DB::commit();
            return redirect()->route('notificacion.index')->with('success', 'El estado de las notificaciones seleccionadas fueron actualizadas de forma exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'Las Notificaciones no pudieorn modificarse, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }

    //Eliminamos todas las notificaciones del usuario que fueron marcadas
    public function destroyAll(Request $request, $id_usuario){
        
        DB::beginTransaction();
        try{

            $notificacion = Usuario_Notificacion::find($id_notificación);

            if(!$notificacion)
                return redirect()->route('notificacion.index')->with('warning', 'La notificación no pudo ser encontrada, por favor intentalo de nuevo');

            //Actualizo su estado de acuerdo a si esta leido o no
                $notificacion->read_at ? $notificacion->read_at = null : $notificacion->read_at = date('Y-m-d h:i:s');
                $notificacion->save();

            DB::commit();
            return redirect()->route('notificacion.index')->with('success', 'El estado de la notificación fue actualizada de forma exitosa');

        }catch(QueryException $e){
            DB::rollBack();
            return Redirect::back()->with('bderror', 'La Notificación no pudo modificarse su estado, por favor intentalo más tarde. \nMensaje: '. $e->getMessage());
        }
    }
}
