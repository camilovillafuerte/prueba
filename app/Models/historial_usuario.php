<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historial_usuario extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','usuario_id','titulo','detalle','dato_viejo','dato_nuevo','extra','fecha_creacion'];


    public function Usuario(){
        return $this->hasMany('App\Models\Usuario');
    }
}

