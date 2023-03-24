<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //colecciones
    public function perfil(){
        return $this->hasOne('App\Models\Perfil', 'FK_id_usuario');
    }

    public function rol(){
        return $this->hasOne('App\Models\Rol', 'FK_id_usuario');
    }
    
    public function permiso(){
        return $this->hasMany('App\Models\Usuario_Permiso', 'FK_id_usuario');
    }

    public function notificaciones(){
        return $this->hasMany('App\Models\Usuario_Notificacion', 'FK_id_usuario');
    }

    public function comentarios(){
        return $this->hasMany('App\Models\Comentario', 'FK_id_usuario');
    }

    public function respuestas(){
        return $this->hasMany('App\Models\Respuesta', 'FK_id_usuario');
    }
}
