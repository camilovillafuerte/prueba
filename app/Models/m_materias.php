<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_materias extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','solicitud_id','materia_origen','codigo_origen',
    'materia_destino','codigo_destino'];


    public function solicitud(){
        return $this->hasMany('App\Models\solicitudes');
    }
}
