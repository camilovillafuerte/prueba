<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class funcionalidad_usuario extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['cargou_id','cedula','funcion_id'];

    //Relación muchos a muchos
    public function usuarios(){
        return $this->belongsToMany(Usuario::class,'usuario_id');
    }
    public function funcionalidad(){
        return $this->hasMany(funcionalidad::class, 'funcion_id', 'funcion_id');
    }

}
