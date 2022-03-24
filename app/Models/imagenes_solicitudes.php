<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imagenes_solicitudes extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','imagenescon_id','estado'];
    public $table = "imagenes_solicitudes";


    public function Imagen()
    {
        return $this->hasMany('App\Models\imagenes_convenios');
    }
}
