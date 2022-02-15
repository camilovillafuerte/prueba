<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class funcionalidad extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['funcion_id','funcionalidad','estado'];


 //Relación muchos a muchos
    public function funcionalidad_usuario(){
        return $this->belongsToMany('App\Models\funcionalidad_usuario','funcion_id');
    }
}
