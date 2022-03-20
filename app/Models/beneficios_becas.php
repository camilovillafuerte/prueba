<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beneficios_becas extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = "contenido_articulos";
    public $timestamps = false;
    protected $fillable = ['id','naturaleza_id','beneficios_id', 'estado'];


    public function contenidos(){
        return $this->belongsTo(natu_intercambios::class, 'naturaleza_id', 'id');
    }

    public function articulos(){
        return $this->belongsTo(m_beneficios::class, 'beneficios_id', 'id');
    }
}
