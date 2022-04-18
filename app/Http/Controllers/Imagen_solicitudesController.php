<?php

namespace App\Http\Controllers;

use App\Models\imagenes_convenios;
use App\Models\imagenes_solicitudes;
use Illuminate\Http\Request;

class Imagen_solicitudesController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getImgSolicitudes(){
        return response()->json(imagenes_solicitudes::all(),200);
    }


    public function updateImagenSolicitudes(Request $request)
    {
        $carrosel = (object)$request->data;
        $con=0;
        $con2=0;
        foreach($carrosel->imagen as $img){
            $imgObj = (object)$img;
            if($imgObj->id==0)
            {
                $newInterfaz=new imagenes_solicitudes();
                $newInterfaz->imagenescon_id=intval($imgObj->imagenescon_id);
                $newInterfaz->estado='A';
                $newInterfaz->save();
                $con++;
            }
            else{
                $update = imagenes_solicitudes::find(intval($imgObj->id));
                $update->imagenescon_id=intval($imgObj->imagenescon_id);
                $update->save();
                $con++;
            }

        }
        foreach($carrosel->eliminar as $eli)
        {
            $eliObj = (object)$eli;
            $update_eli=imagenes_solicitudes::find(intval($eliObj->id));
            $update_eli->estado='D';
            $update_eli->save();
            $con2++;
        }


        if($con==count($carrosel->imagen) && ($con2==count($carrosel->eliminar)))
        {
            $response=[
                'estado'  => true,

                'mensaje' => 'Imagen Insertada, Modificado o Eliminada'
            ];
        }
        else
        {
            $response=[
                'estado'  => false,
                'numero de ingresados o modificados'=>$con,
                'numero de eliminados'=>$con2,
                'mensaje' => 'Imagen Insertada o Modificado'
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
