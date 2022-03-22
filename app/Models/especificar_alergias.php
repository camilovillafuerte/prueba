<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class especificar_alergias extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','solicitud_id','alergias_id','especificar_alergia','estado'];


    public function solicitud(){
        return $this->belongsTo(solicitudes::class, 'solicitud_id', 'id');
    }
    public function alergias(){
        return $this->belongsTo(alergias::class, 'alergias_id', 'id');
    }
    
}
