<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario_Permiso extends Model
{
    use HasFactory;
    
    protected $table = "usuario_permiso";
    protected $primaryKey = "id_articulo";
    protected $fillable = [
        "id_usuario_permiso",
        "save",
        "update",
        "delete",
        "FK_id_usuario",
        "FK_id_modulo",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "FK_id_usuario",
        "FK_id_modulo",
    ];

    //colecciones
    public function usuario(){
        return $this->belongsTo('App\Models\User', 'FK_id_usuario');
    }

    public function modulo(){
        return $this->belongsTo('App\Models\Modulo', 'FK_id_modulo');
    }
}
