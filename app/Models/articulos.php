<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class articulos extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = "articulos";
    public $timestamps = false;
    protected $fillable = ['id','des_art','subtipo'];

    public function conarticulos(){
        return $this -> belongsToMany('App\Models\contenido_articulos');
    }
}
