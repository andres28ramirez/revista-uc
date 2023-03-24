<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario_Rol extends Model
{
    use HasFactory;
    protected $table = "usuario_rol";
    protected $primaryKey = "id_usuario_rol";
    protected $fillable = [
        "id_usuario_rol",
        "FK_id_usuario",
        "FK_id_rol",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "FK_id_usuario",
        "FK_id_rol",
    ];

    //colecciones
    public function usuario(){
        return $this->belongsTo('App\Models\User', 'FK_id_usuario');
    }

    public function rol(){
        return $this->belongsTo('App\Models\Rol', 'FK_id_rol');
    }
}
