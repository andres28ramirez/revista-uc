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
        "descripcion",
        "fecha",
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
}
