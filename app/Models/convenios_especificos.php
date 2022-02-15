<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class convenios_especificos extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','descripcion_ce'];
    public $table = "convenios_especificos";

    public function tipo_convenios(){
        return $this->hasMany('App\Models\tipo_convenios','id_convenios_especificos');
    }
}
