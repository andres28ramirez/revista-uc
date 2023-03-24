<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $table = "archivo";
    protected $primaryKey = "id_archivo";
    protected $fillable = [
        "id_archivo",
        "nombre",
        "ruta_archivo_es",
        "ruta_archivo_en",
        "tipo",
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
}
