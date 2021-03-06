<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contenido_articulos extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = "contenido_articulos";
    public $timestamps = false;
    protected $fillable = ['id','id_contenidos','id_articulos', 'estado'];


    public function contenidos(){
        return $this->belongsTo(contenido::class, 'id_contenidos', 'id');
    }

    public function articulos(){
        return $this->belongsTo(articulos::class, 'id_articulos', 'id');
    }
}
