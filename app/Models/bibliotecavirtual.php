<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bibliotecavirtual extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','nombre_uni','url_biblioteca','url_pprincipal'];
}
