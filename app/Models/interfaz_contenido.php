<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class interfaz_contenido extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','id_interfazs','usuario_id','nombre','descripcion','PDF','imagen_id','estado'];

    public function interfaz(){
        return $this->belongsTo(interfaz::class, 'id_interfazs', 'id');
    }
    
    //Relacion de uno a muchos
    public function usuarios(){
    return $this->hasMany('App\Models\usuarios','usuario_id');
}
  //Relacion de uno a muchos
  public function imagenes(){
    return $this->hasMany('App\Models\imagenes_interfaces','imagen_id');
}

public function imagenes_interfaz(){
    return $this->belongsTo(imagenes_intefaces::class, 'imagen_id', 'id');
}

}
