<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;
    
    protected $table = "respuesta";
    protected $primaryKey = "id_respuesta";
    protected $fillable = [
        "id_respuesta",
        "nombre",
        "contenido",
        "FK_id_usuario",
        "FK_id_comentario",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "FK_id_usuario",
        "FK_id_comentario",
    ];

    //colecciones
    public function usuario(){
        return $this->belongsTo('App\Models\User', 'FK_id_usuario');
    }

    public function comentario(){
        return $this->belongsTo('App\Models\Comentario', 'FK_id_comentario');
    }
}
