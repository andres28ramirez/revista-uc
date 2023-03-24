<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario_Notificacion extends Model
{
    use HasFactory;
    
    protected $table = "usuario_notificacion";
    protected $primaryKey = "id_usuario_notificacion";
    protected $fillable = [
        "id_usuario_notificacion",
        "read_at",
        "FK_id_user",
        "FK_id_notificacion",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "FK_id_user",
        "FK_id_notificacion",
    ];

    //colecciones
    public function usuario(){
        return $this->belongsTo('App\Models\User', 'FK_id_user');
    }

    public function notificacion(){
        return $this->belongsTo('App\Models\Notificacion', 'FK_id_notificacion');
    }
}
