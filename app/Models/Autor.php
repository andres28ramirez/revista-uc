<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;
    
    protected $table = "autor";
    protected $primaryKey = "id_autor";
    protected $fillable = [
        "id_autor",
        "nombre",
        "email",
        "grado",
        "sintesis",
        "ruta_imagen",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    //colecciones
    public function articulos(){
        return $this->hasMany('App\Models\Articulo', 'FK_id_autor');
    }
}
