<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_convenios extends Model
{
    use HasFactory;
    public $table = "tipo_convenios";
    public $timestamps = false;
    protected $fillable = ['id','nombretc_id','descripcion_tc','id_convenios','id_convenios_especificos'];

    //Relacion de uno a muchos inversa
    public function convenios(){
    return $this->hasMany('App\Models\convenios');
}
    public function convenios_especificos(){
    return $this->hasMany('App\Models\convenios_especificos');
}
public function nombre_tipoconvenio(){
    return $this->hasMany('App\Models\nombre_tipoconvenio');
}
}
