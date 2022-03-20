<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pdf_msolicitudes extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','solicitud_id','pdfcertificado_matricula','pdfcopia_record','pdfsolicitud_carta','pdfcartas_recomendacion',
    'pdfno_sancion','pdffotos','pdfseguro','pdfexamen_psicometrico','pdfdominio_idioma','pdfdocumentos_udestino','pdfcomprobante_solvencia'
    ];


      //Relacion de uno a muchos
public function soli(){
    return $this->hasMany('App\Models\solicitud_modalidades','solicitud_id');
}
}