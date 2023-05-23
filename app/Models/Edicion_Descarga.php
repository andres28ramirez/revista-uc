<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edicion_Descarga extends Model
{
    use HasFactory;
    
    protected $table = "edicion_descarga";
    protected $primaryKey = "id_edicion_descarga";
    protected $fillable = [
        "id_edicion_descarga",
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
