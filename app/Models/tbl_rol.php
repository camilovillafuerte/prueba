<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_rol extends Model
{
    protected $connection = 'pgsql3';

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'tbl_rol';

    use HasFactory;
    public $timestamps = false;
    protected $filleable = ['id_rol','descripcion','estado','nivel',
    'dias_caducidad_clave','abrevia','orden'];

     //Relacion de uno a muchos
     public function tbl_personal_rol()
     {
         return $this->hasMany('App\Models\tbl_personal_rol');
     }
}
