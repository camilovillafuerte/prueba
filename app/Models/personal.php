<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personal extends Model
{
 /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'pgsql2';

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'personal';


    use HasFactory;
    public $timestamps = false;
    protected $filleable = ['id','cedula','apellido1','apellido2','nombres','genero',
    'idtipo_documento','idtipo_nacionalidad','idtipo_genero','idtipo_estado_civil','idtipo_etnia','idtipo_nacionalidad_indigena','idtipo_sangre','idtipo_pais_orige','idtipo_provincia_origen','idtipo_canton_origen','idtipo_parroquia_origen','idtipo_pais_residencia','idtipo_provincia_residencia','idtipo_canton_residencia','idtipo_parroquia_residencia',
'residencia_anios','numero_libreta_militar','fecha_nacimiento',
'discapacidad_numero_carne','discapacidad_numero_porcentaje','idtipo_discapacidad',
'residencia_calle_1','residencia_calle_2','residencia_calle_3',
'residencia_referencia','residencia_domicilio_numero','telefono_personal_domicilio',
'telefono_personal_celular','telefono_personal_trabajo','telefono_personal_extension',
'correo_personal_institucional','correo_personal_alternativo','contacto_emergencia_apellidos','contacto_emergencia_nombres',
'contacto_emergencia_telefono_1','contacto_emergencia_telefono_2','salario_mensual_f_total','salario_mensual_f_integrantes',
'idtipo_relacion_conyuge','idtipo_documento_conyuge','conyuge_cedula',
'conyuge_apellido_1','conyuge_apellido_2','conyuge_nombres',
'idfichero_hoja_vida_foto','idfichero_hoja_vida_cedula','idfichero_hoja_vida_certificado_votacion',
'estudiante_apellido_1_madre','estudiante_apellido_2_madre',
'estudiante_nombres_madre','estudiante_apellido_1_padre','estudiante_apellido_2_padre',
'estudiante_nombres_padre','discapacidad_observacion','discapacidad_validada',
'idtipo_beca','o_beca','snna_codigo_unico','snna_fecha_inscripcion','snna_puntaje',
'idtipo_internet_dispone','idtipo_celular_dispone','internet_horas_uso',
'red_social_horas_uso','tipo_red_social_utiliza','tipo_tecnologia_utiliza',
'transporte_horas_traslado','transporte_horas_permanencia','idtipo_transporte',
'hijos_numero','hijos_edad','idtipo_vivienda','idtipo_vivienda_localizacion',
'idtipo_jefe_f_nivel_instruccion','idtipo_salario_mensual_f_total',
'idtipo_jefe_ocupacion','idtipo_estudiante_ocupacion',
'tipo_solvencia','valor_terremoto','dato_vivienda','tipo_vivienda',
'afectada_terremoto_obser','afectado_lugar','afectado_ocupacion_padre',
'afectado_ocupacion_madre','afectacion_perdio_padre','afectacion_perdio_madre',
'act_terremoto','afectada_terremoto','tiene_enfermedad',
'tiene_padres_enfermedad','tiene_interes_estudiar','estado_usuario',
'accesos_fallidos','bloqueado','password_changed','act_sniese',
'fecha_ultima_actualizacion','logueado','fecha_ultimo_ingreso',
'documento_original','datos_actualizados','datos_especifique',
'datos_estado','idtipo_parquadero_auto','idtipo_parquadero_bici',
'problema_aprendizaje','problema_aprendizaje_otros','discapacidad_fecha',
'pasaporte','json_habito_estudio','json_caracteristica_personalidad',
'json_ambiente_familiar','json_composicion_familiar','json_ingreso_universidad',
'hv_verificada','idtipo_pais_trabajo','idtipo_provincia_trabajo','idtipo_canton_trabajo',
'idtipo_parroquia_trabajo','idtipo_contacto_familiar','idtipo_documento_familiar',
'familiar_cedula','familiar_apellido_1','familiar_apellido_2','familiar_nombres',
'control_asistencia','fecha_registro','idtipo_nivel_instruccion',
'json_problemas_salud','json_problemas_aprendizaje','esijef','esijef2',
'idnumber_moodle','escala_ocupacional','denominacion_puesto','unidad_organica','trabajador_activo',
'esta_embarazada','lactante_edad','idtipo_bloque_tutoria',
'idtipo_orientacion_sexual','idtipo_preferencia_religiosa','r_direccion',
'idtipo_r_construccion','idtipo_r_tipo_vivienda','idtipo_r_financiamiento','r_servicio_basico',
'idtipo_r_gasto_alquiler','idtipo_madre_instruccion','idtipo_padre_instruccion',
'idtipo_pareja_instruccion','dificultad_estudios','idtipo_gasto_transporte',
'idtipo_vivienda_financiamiento','idtipo_manutencion','idtipo_manutencion_alquiler',
'idtipo_gasto_alimentacion','idtipo_gasto_colegiatura','reside_portoviejo',
'integrante_bachillerato','integrante_universidad','idtipo_computador_dispone',
'idtipo_tablet_dispone','idtipo_internet_telefono_dispone',
'idtipo_clase_virtual_desea','salario_mensual_f_integrantes_ingreso',
'idfichero_hoja_vida_ruc','terminos','foto_valida','json_validar_foto',
'idfichero_hoja_vida_foto_tmp','json_control','json_vacuna_covid',
'vacunado_covid','fecha_encuesta_vacuna'];

    //Relacion de uno a muchos
    public function usuarios(){
    return $this->hasMany(Usuario::class,'personal_id');
}


    //Relacion de uno a muchos
    public function tbl_personal_rol(){
        return $this->hasMany(tbl_personal_rol::class,'id');
    }
    
    //Relacion de uno a muchos
    public function Personal()
    {
        return $this->hasMany('App\Models\tbl_personal_rol');
    }



}
