<?php

namespace App\Http\Controllers;

use App\Models\imagenes_solicitudes;
use Illuminate\Http\Request;

class Imagen_solicitudesController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getImgSolicitudes(){
        return response()->json(imagenes_solicitudes::all(),200);
    }
}
