<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class convenios extends Model
{
    use HasFactory;

    public $table = "convenios";
    public $timestamps = false;
    protected $fillable = ['id', 'usuario_id', 'femisor_id', 'freceptor_id','imagen1_id','imagen1_id' ,'titulo_convenio', 'f_creaciondoc', 'estado', 'tipo_documento', 'PDF','fecha_firma','fecha_fin'];


    //Relacion de uno a muchos
    public function tipo_convenios()
    {
        return $this->hasMany('App\Models\tipo_convenios', 'id_convenios');
    }

    //Relacion de uno a muchos
    public function Usuario()
    {
        return $this->hasMany('App\Models\Usuario');
    }

    //Relacion de uno a muchos
    public function Firma_emisor()
    {
        return $this->hasMany('App\Models\firmas');
    }

    //Relacion de uno a muchos
    public function Firma_receptor()
    {
        return $this->hasMany('App\Models\firmas');
    }

    public function Imagen1()
    {
        return $this->hasMany('App\Models\imagenes_convenios');
    }

    //Relacion de uno a muchos
    public function Imagen2()
    {
        return $this->hasMany('App\Models\imagenes_convenios');
    }

    //Relación muchos a muchos
    public function convenios_clausulas()
    {
        return $this->belongsToMany('App\Models\convenios_clausulas');
    }
}
