<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class becas_nivel_body extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','id_becas_nivels','nombre','pais','idioma','area_estudio',
    'fecha_postulacion','url','modalidad','requisitos','reconocimiento_titulo','pdf','estado'];

    public function becas_nivel(){
        return $this->belongsTo('App\Models\becas_nivel');
    }

}
