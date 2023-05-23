<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edicion_Visita extends Model
{
    use HasFactory;

    protected $table = "edicion_visita";
    protected $primaryKey = "id_edicion_visita";
    protected $fillable = [
        "id_edicion_visita",
        "mes",
        "year",
        "total",
        "FK_id_edicion",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    //colecciones
    public function edicion(){
        return $this->belongsTo('App\Models\Edicion', 'FK_id_edicion');
    }
}
