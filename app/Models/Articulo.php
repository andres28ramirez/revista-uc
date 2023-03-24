<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
    
    protected $table = "articulo";
    protected $primaryKey = "id_articulo";
    protected $fillable = [
        "id_archivo",
        "titulo",
        "contenido",
        "ruta_imagen_es",
        "ruta_imagen_en",
        "FK_id_edicion",
        "FK_id_autor",
        "FK_id_conocimiento",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "FK_id_conocimiento",
    ];

    //colecciones
    public function edicion(){
        return $this->belongsTo('App\Models\Edicion', 'FK_id_edicion');
    }

    public function autor(){
        return $this->belongsTo('App\Models\Autor', 'FK_id_autor');
    }
    
    public function conocimiento(){
        return $this->belongsTo('App\Models\Conocimiento', 'FK_id_conocimiento');
    }

    public function archivos(){
        return $this->hasMany('App\Models\Archivo', 'FK_id_articulo');
    }

    public function comentarios(){
        return $this->hasMany('App\Models\Comentario', 'FK_id_articulo');
    }
}
