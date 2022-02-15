<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_personal_rol extends Model
{
    protected $connection = 'pgsql3';

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'tbl_personal_rol';

    use HasFactory;

    public $timestamps = false;
    protected $filleable = ['id_personal','id_conexion','id_escuela','id_departamento',
    'id_rol','estado','fecha','idescuela','iddepartamento','escuela',
    'departamento','id_aplicacion'];


       //Relacion de uno a muchos
       public function tbl_rol(){
        return $this->hasMany(tbl_rol::class,'id_rol');
    }

}
