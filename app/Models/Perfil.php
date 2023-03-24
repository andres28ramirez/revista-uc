<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;
    
    protected $table = "perfil";
    protected $primaryKey = "id_perfil";
    protected $fillable = [
        "id_perfil",
        "nombre",
        "apellido",
        "direccion",
        "telefono",
        "FK_id_usuario",
        "FK_id_tipo",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "FK_id_usuario",
        "FK_id_tipo",
    ];

    //colecciones
    public function usuario(){
        return $this->belongsTo('App\Models\User', 'FK_id_usuario');
    }

    public function tipo(){
        return $this->belongsTo('App\Models\Usuario_Tipo', 'FK_id_tipo');
    }
}
