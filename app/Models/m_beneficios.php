<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_beneficios extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','descripcion','tipo','estado'];

    //Relación muchos a muchos
    public function bene_modalidad(){
        return $this->belongsToMany('App\Models\beneficios_modalidad');
    }
}
