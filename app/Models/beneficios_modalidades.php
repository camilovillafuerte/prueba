<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beneficios_modalidades extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','solicitud_id','beneficios_id','estado'];

    public function solicitud(){
        return $this->belongsTo(solicitud_modalidades::class, 'solicitud_id', 'id');
    }

    public function solicitudbecas(){
        return $this->belongsTo(solicitud_becas::class, 'solicitud_id', 'id');
    }
    public function beneficios(){
        return $this->belongsTo(m_beneficios::class, 'beneficios_id', 'id');
    }
}
