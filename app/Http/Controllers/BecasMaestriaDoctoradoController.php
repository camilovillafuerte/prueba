<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BecasMaestriaDoctoradoController extends Controller
{
    public function roles_becas_maestrias()
{ 
    $roles = DB::table('esquema_dricb.usuarios')
    ->join('esq_datos_personales.personal','esquema_dricb.usuarios.personal_id','=','esq_datos_personales.personal.id')
    ->join('esq_roles.tbl_personal_rol','esq_roles.tbl_personal_rol.id_personal','=','esq_datos_personales.personal.id')
    ->join('esq_roles.tbl_rol','esq_roles.tbl_personal_rol.id_rol','=','esq_roles.tbl_rol.id_rol')
    ->select('usuarios.*','personal.*','tbl_personal_rol.*','tbl_rol.*')
    -> where('descripcion','<>','ESTUDIANTE') 
    -> get();
  
    return response() -> json ($roles);
}
}
