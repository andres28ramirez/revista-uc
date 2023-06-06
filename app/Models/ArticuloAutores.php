<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloAutores extends Model
{
    use HasFactory;
    
    protected $table = "articulo_autores";
    protected $primaryKey = "id_articulo_autores";
    protected $fillable = [
        "id_articulo_autores",
        "FK_id_articulo",
        "FK_id_autor",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    //colecciones
    public function articulo(){
        return $this->belongsTo('App\Models\Articulo', 'FK_id_articulo');
    }

    public function autor(){
        return $this->belongsTo('App\Models\Autor', 'FK_id_autor');
    }
}
