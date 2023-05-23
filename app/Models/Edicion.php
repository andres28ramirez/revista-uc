<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edicion extends Model
{
    use HasFactory;
    
    protected $table = "edicion";
    protected $primaryKey = "id_edicion";
    protected $fillable = [
        "id_edicion",
        "numero",
        "titulo",
        "titulo_en",
        "descripcion",
        "descripcion_en",
        "fecha",
        "periodo",
        "ruta_imagen",
        "ruta_archivo",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    //colecciones
    public function articulos(){
        return $this->hasMany('App\Models\Articulo', 'FK_id_edicion');
    }

    public function descargas(){
        return $this->hasMany('App\Models\Edicion_Descarga', 'FK_id_edicion');
    }
    
    public function visitas(){
        return $this->hasMany('App\Models\Edicion_Visita', 'FK_id_edicion');
    }
}
