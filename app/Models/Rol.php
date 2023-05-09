<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    
    protected $table = "rol";
    protected $primaryKey = "id_rol";
    protected $fillable = [
        "id_rol",
        "nombre",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    //colecciones
    public function usuarios(){
        return $this->hasMany('App\Models\Usuario_Rol', 'FK_id_rol');
    }
}
