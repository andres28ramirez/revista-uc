<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informacion extends Model
{
    use HasFactory;
    
    protected $table = "informacion";
    protected $primaryKey = "id_informacion";
    protected $fillable = [
        "id_informacion",
        "titulo",
        "contenido",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];
}
