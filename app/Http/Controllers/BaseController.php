<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller{

    private $servidor_archivos = '';

    public function __construct(){
        $this->servidor_archivos = 'http://3.15.185.2/';
    }

    public function getUrlServer(String $path){
       
       // return $this->servidor_archivos.$path;
        return $this->servidor_archivos='http://3.15.185.2/';
    }
}
