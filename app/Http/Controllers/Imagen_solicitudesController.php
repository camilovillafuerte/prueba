<?php

namespace App\Http\Controllers;

use App\Models\imagenes_convenios;
use App\Models\imagenes_solicitudes;
use Illuminate\Http\Request;

class Imagen_solicitudesController extends Controller
{
    //metodo con json para probar si funciona con postman
    private $baseCtrl;

    public function __construct(){
        $this->baseCtrl = new BaseController();
    }

    public function getImgSolicitudes(){
        return response()->json(imagenes_solicitudes::all(),200);
    }

    public function update(Request $request){
        $data = (object)$request->data;
        $response = [];
        $data = imagenes_solicitudes::where('id','=',1);
        $data->imagenescon_id=$data->id;
        $data->save();
        $response=$data;
        return response()->json($response);
    
    } 

    public function updateImagenSolicitudes(Request $request, $id)
    {
        $data = (object)$request->data;
        $imagen = imagenes_solicitudes::find(intval($data->imagenescon_id));
       // $imagen = imagenes_solicitudes::find($id);
            if($imagen)
           {
                $imagen->imagenescon_id=$data->imagenescon_id;
                $imagen->save();
                
                $response=[
                    'estado'  => true,
                    'mensaje' => 'Imagen Modificado'
                ];
            }else{
                $response=[
                    'estado'  => false,
                    'mensaje' => 'No se pudo modificar la imagen'
                ];
            }
            return response()->json($response);
        }
       

    public function deleteImagenSolicitudes(Request $request)
    {
        $carrosel = (object)$request->data;
        $con=0;
        foreach($carrosel->eliminar as $eli)
        {
            $eliObj = (object)$eli;
            $update = imagenes_solicitudes::find(intval($eliObj->id));
            if($update){
                $con++;
                $update->estado='D';
                $update->save();
            }
        }
        $response=[
            'estado'  => true,
            'numero'=>$con,
            'mensaje' => 'Se elimino la imagen!!...'
        ];

        return response()->json($response);


    }

    public function insertImgsolicitudes(Request $request){
        $data = (object)$request->data;
        $newImagen = new imagenes_solicitudes();
        $newImagen->imagenescon_id=intval($data->imagenescon_id);
        $newImagen->estado='A';
        $newImagen->save();
        $response = [
            'estado'  => true,
            'mensaje' => 'Imagen guardada'
        ];
        return response()->json($response);
    }
}
