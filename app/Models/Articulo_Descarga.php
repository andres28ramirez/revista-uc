<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo_Descarga extends Model
{
    use HasFactory;
    
    protected $table = "articulo_descarga";
    protected $primaryKey = "id_articulo_descarga";
    protected $fillable = [
        "id_articulo_descarga",
        "mes",
        "year",
        "total",
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
