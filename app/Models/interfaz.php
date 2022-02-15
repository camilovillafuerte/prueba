<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class interfaz extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','nombre','pagina'];


     //Relacion de uno a muchos
    public function interfaz_contenido(){
    return $this->hasMany(interfaz_contenido::class, 'id_interfazs', 'id');
}
}
