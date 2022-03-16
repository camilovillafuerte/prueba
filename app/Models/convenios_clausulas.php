<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class convenios_clausulas extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = "convenios_clausulas";
    public $timestamps = false;
    protected $fillable = ['id','id_convenios','id_clausulas','id_contenidos','estado'];


    //Relación muchos a muchos
    public function convenios(){
        return $this->hasMany('App\Models\convenios');
    }
    public function clausulas(){
        return $this->belongsTo(clausulas::class, 'id_clausulas', 'id');
    }
    public function contenidos(){
        return $this->belongsTo(contenido::class, 'id_contenidos', 'id');
    }
    public function conve(){
        return $this->belongsTo(convenios::class, 'id_convenios', 'id');
    }
}
