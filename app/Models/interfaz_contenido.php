<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class interfaz_contenido extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id_interfazs','nombre','descripcion','urlimagen','estado'];

    public function interfaz(){
        return $this->belongsTo(interfaz::class, 'id_interfazs', 'id');
    }
}
