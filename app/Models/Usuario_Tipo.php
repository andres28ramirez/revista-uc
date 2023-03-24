<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario_Tipo extends Model
{
    use HasFactory;
    
    protected $table = "usuario_tipo";
    protected $primaryKey = "id_tipo";
    protected $fillable = [
        "id_tipo",
        "titulo",
        "nombre",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    //colecciones
    public function perfiles(){
        return $this->hasMany('App\Models\Perfil', 'FK_id_tipo');
    }
}
