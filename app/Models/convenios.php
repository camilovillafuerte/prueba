<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class convenios extends Model
{
    use HasFactory;

    public $table = "convenios";
    public $timestamps = false;
    protected $fillable = ['id', 'usuario_id', 'femisor_id', 'freceptor_id', 'titulo_convenio', 'f_creaciondoc', 'estado', 'tipo_documento', 'PDF'];


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

    //Relación muchos a muchos
    public function convenios_clausulas()
    {
        return $this->belongsToMany('App\Models\convenios_clausulas');
    }
}
