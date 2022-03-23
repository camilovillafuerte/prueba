<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudes extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','personal_id','logo_id','universidad_id','escuela_id','naturaleza_id','modalidad1_id','modalidad2_id',
    'becas_id','montos_id','carrera_destino','semestre_cursar','campus_destino','numero_semestre','fecha_inicio','fecha_fin','fcreacion_solicitud','PDF','poliza_seguro','estado_solicitud','tipo','estado'];

   
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

     //Relacion de uno a muchos
     public function enfermedades(){
        return $this->hasMany(enfermedades::class,'solicitud_id');
    }

     //Relacion de uno a muchos
     public function materias(){
        return $this->hasMany(m_materias::class,'solicitud_id');
    }

    public function bene_modalidad(){
        return $this->belongsToMany('App\Models\beneficios_modalidad');
    }
    //Relacion de uno a muchos
    public function sm_aprobadas(){
        return $this->hasMany(s_aprobadas::class,'solicitud_id');
    }

    //Relacion de uno a muchos
    public function Becas()
    {
        return $this->hasMany('App\Models\becas_apoyos');
    }

    public function Monto()
    {
        return $this->hasMany('App\Models\m_montos');
    }

    public function PDF()
    {
        return $this->hasMany('App\Models\pdf_solicitudes');
    }

    public function soli(){
        return $this->hasMany('App\Models\especificar_alergias','solicitud_id');
    }

    public function Imagen()
    {
        return $this->hasMany('App\Models\imagenes_convenios');
    }
}
