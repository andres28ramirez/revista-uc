<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;
    
    protected $table = "notificacion";
    protected $primaryKey = "id_notificacion";
    protected $fillable = [
        "id_notificacion",
        "titulo",
        "descripcion",
        "ruta",
        "FK_id_modulo",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    //colecciones
    public function modulo(){
        return $this->belongsTo('App\Models\Modulo', 'FK_id_modulo');
    }

    public function usuarios(){
        return $this->hasMany('App\Models\Usuario_Notificacion', 'FK_id_notificacion');
    }
}
