<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conocimiento extends Model
{
    use HasFactory;
    
    protected $table = "conocimiento";
    protected $primaryKey = "id_conocimiento";
    protected $fillable = [
        "id_conocimiento",
        "nombre",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    //colecciones
    public function articulos(){
        return $this->hasMany('App\Models\Articulo', 'FK_id_conocimiento');
    }
}
