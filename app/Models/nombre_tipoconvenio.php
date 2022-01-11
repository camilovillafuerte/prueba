<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nombre_tipoconvenio extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','nombre_tipo'];
    public $table = "nombre_tipoconvenios";

    public function tipo_convenios(){
        return $this->hasMany('App\Models\tipo_convenios','nombretc_id');
    }


}
