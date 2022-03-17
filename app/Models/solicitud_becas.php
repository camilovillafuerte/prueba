<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitud_becas extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','personal_id','naturaleza_id','modalidad1_id','modalidad2_id','universidad_destino',
    'campus_destino','fecha_inicio','fecha_fin','duracion_semestre',
    'beca_apoyo','monto_referencial','fcreacion_solicitud','PDF','estado_solicitud','estado'];


    public function naturaleza(){
        return $this->hasMany('App\Models\natu_intercambios');
        }
        
        //Relacion de uno a muchos
        public function Modalidad1()
        {
            return $this->hasMany('App\Models\modalidades');
        }
    
        //Relacion de uno a muchos
        public function Modalidad2()
        {
            return $this->hasMany('App\Models\modalidades');
        }

        public function bene_modalidad(){
            return $this->belongsToMany('App\Models\beneficios_modalidad');
        }

}
