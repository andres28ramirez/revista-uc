<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;
    
    protected $table = "modulo";
    protected $primaryKey = "id_modulo";
    protected $fillable = [
        "id_modulo",
        "nombre",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    //colecciones
    public function permisos(){
        return $this->hasMany('App\Models\Usuario_Permiso', 'FK_id_modulo');
    }

    public function notificaciones(){
        return $this->hasMany('App\Models\Notificacion', 'FK_id_modulo');
    }
}
