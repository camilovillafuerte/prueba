<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class becas_nivel_body extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','id_becas_nivels','nombre','pais','idioma','area_estudio','fecha_postulacion','modalidad','requisitos','pdf'];
}
