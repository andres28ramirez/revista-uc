<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

//MODELOS
use App\Models\Rol;
use App\Models\Usuario_Notificacion;

//NOTIFICACION Y MAILABLE
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;

class AdminNotificacion {

    public static function Notifica($notificacion, $titulo, $contenido) {
        
        $roles = Rol::where('nombre','<>','Usuario')->get();
        
        foreach($roles as $rol){
            foreach($rol->usuarios as $rol_usuario){
                $user = $rol_usuario->usuario;
                if(Auth::user()->id != $user->id ){
                    $user_ncion = new Usuario_Notificacion();

                    $user_ncion->FK_id_user = $user->id;
                    $user_ncion->FK_id_notificacion = $notificacion->id_notificacion;
                    $user_ncion->save();

                    $email = [
                        'greeting' => $titulo,
                        'body' => $contenido,
                        'thanks' => 'Visita el panel de vez en cuando para que puedas ver todas las notificaciones que aun tienes pendiente',
                        'actionText' => 'Ver Notificación',
                        'actionURL' => url($notificacion->ruta),
                        'id' => $notificacion->id_notificacion
                    ];

                    Notification::send($user, new EmailNotification($email));
                }
            }
        }
        
        return;
    }

    public static function UserNotifica($user, $ruta, $titulo, $contenido, $comentario) {

        $email = [
            'greeting' => $titulo,
            'body' => $contenido,
            'thanks' => 'Comentario enviado: '.$comentario->contenido,
            'actionText' => 'Ver Artículo',
            'actionURL' => url($ruta),
            'id' => $user->id
        ];

        Notification::send($user, new EmailNotification($email));
        
        return;
    }
}