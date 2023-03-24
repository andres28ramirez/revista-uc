<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    
    protected $table = "comentario";
    protected $primaryKey = "id_comentario";
    protected $fillable = [
        "id_comentario",
        "autor",
        "contenido",
        "FK_id_usuario",
        "FK_id_articulo",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    //colecciones
    public function articulo(){
        return $this->belongsTo('App\Models\Articulo', 'FK_id_articulo');
    }

    public function usuario(){
        return $this->belongsTo('App\Models\User', 'FK_id_usuario');
    }
    
    public function respuestas(){
        return $this->hasMany('App\Models\Respuesta', 'FK_id_comentario');
    }
}
