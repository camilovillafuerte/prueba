<html>

<head>
    <style>
       @page {
                margin: 0cm 0cm;
                font-family: Arial;
            }
    
            body {
                margin: 3cm 2cm 2cm;
            }
    
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
                /* background-color: #eee; */
                background-color: #fff;
                color: black;
                text-align: center;
                line-height: 30px;
                margin-bottom: 10px;
            }
    
            /* main{
                width: 100% !important;
            } */
    
            footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
                /* background-color: #f4f4f4; */
                color: #a19f9f;
                text-align: center;
                line-height: 35px;
                width: 100% !important;
            }
    
            .justify {
                text-align: justify;
            }
    
            .d-flex {
                display: flex !important;
                flex: 1 1;
            }
    
            .mb-3 {
                margin-bottom: 1.5rem;
            }
    
            .mt-3{
                margin-top: 1.5rem;
            }
    
            .mt-4{
                margin-top: 2rem;
            }
    
            .mt-5{
                margin-top: 2.5rem;
            }
    
            .box {
                margin: 10px;
                padding: 5px;
              
            }
            .box img {
                height : 80px;
                width: 80px;
                opacity: 0.6;
            }
    
            .box .right {
                position:absolute;
                top:0;
                margin-right:0;
                text-align: right;
            }
    
            .scale-down {object-fit: scale-down}
       
        .page-break {
        page-break-after: always;
        }

        .border{
   
    border-bottom: 2px solid rgb(187, 216, 190) !important; 
    margin-bottom: 2%; 
    background-color: rgb(187, 216, 190);
    margin-top: 1.5%;
    text-align: center;
            }

            .justify {
            text-align: justify;
        }
table{
    table-layout: fixed;
    width: 103%;
}
th, td {
    border: 1px solid black;
    width: 30%;
    height: 5%;
    word-wrap: break-word;
}
h1,h2,h3,h4,h5{
                padding: 0px;
                margin: 0px;
            }
    
.container{
    width: 660px; 
    overflow: hidden;
    /* height: 230px;  */
    padding-top: 10px; 
    /* border: black 2px dashed;   */
     /* background-color:red;  */
}
.container2{
    width: 660px; 
    overflow: hidden;
    /* height: 118px;  */
    padding-top: 10px; 
    /* border: black 2px dashed;   */
}
.container3{
    width: 660px; 
    overflow: hidden;
    /* height: 170px;  */
    padding-top: 10px; 
    /* border: black 2px dashed;   */
}
.container4{
    width: 660px; 
    overflow: hidden;
    /* height: 150px;  */
    padding-top: 10px; 
    /* border: black 2px dashed;    */
}
.container5{
    width: 660px; 
    overflow: hidden;
    padding-top: 10px; 
    /* height: 300px;  */
     /* border: black 2px dashed;  */
    /* margin-top: 30px;    */
}
.page-break {
    page-break-after: always;
 }

span.a {
  display: inline-block; /* the default for span */
  width: 205px;
  height: 40px; 
  margin-top: 6px; 
  /* padding: 5px; */
  padding: 8px 5px 8px 5px; 
  border: 1px solid black;  
  /* background-color: yellow;  */
  text-align: center; 
  font-size: 16px;
}

span.b {
  display: inline-block;
  width: 205px;
  height: 30px;
  /* padding: 5px; */
  padding: 8px 5px 8px 5px; 
  margin-top: 8px;
  /* margin-bottom: 8px; */
  border: 1px solid black;    
  text-align: center; 
  font-size: 16px;
}
span.c {
  display: inline-block;
  width: 648px;
  height: 30px;
  /* padding: 5px; */
  padding: 8px 5px 8px 5px; 
  border: 1px solid black;    
  text-align: justify; 
  font-size: 18px;
  margin-bottom: 1px;
}
span.d {
  display: inline-block; /* the default for span */
  width: 315px;
  height: 40px; 
  margin-top: 6px; 
  /* padding: 5px; */
  padding: 8px 5px 8px 5px; 
  border: 1px solid black;  
  /* background-color: yellow;  */
  text-align: center; 
  font-size: 18px;
}
span.e {
  display: inline-block;
  width: 648px;
  height: 60px;
  /* padding: 5px; */
  padding: 8px 5px 8px 5px; 
  border: 1px solid black;    
  text-align: justify; 
  font-size: 18px;
  margin-bottom: 1px;
}
</style>
    </head>
    <body>
        <header>
            <div style="display: flex; justify-content: space-between;">
                <div style="width: 100% !important; ">
                <div class="box">
                        <img src='{{ $data->request->imagen1 }}' alt="" style="margin-left: -650px;margin-top:3px;">
                    </div>
                </div>
    
                <div style="width: 100% !important; ">
                    <h1 class="mt-3">Universidad Técnica de Manabí</h1>
                    <h3>Departamento de Relaciones Internacionales, Convenios y Becas</h3>
                    <h2 class="mt-3">Solicitud de Movilidad</h2>
                </div>
            </div>
        </header>


       <main style="margin-top: 2.5rem;">

        <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span style="font-weight:bold">DATOS PERSONALES</span>
        </div>

        <div class="container" style=" margin-bottom:6px">
     
             <span class="a">Cedula: {{$data->movilidad->cedula}}</span>
       
             <span class="a">Nombres: {{$data->movilidad->nombres}}</span>
   
            <span class="a">Apellido Paterno: {{$data->movilidad->apellido1}}</span>

            <span class="a">Apellido Materno: {{$data->movilidad->apellido2}}</span>
          
            <span class="a">Tipo de Sangre: {{$data->movilidad->tipo_sangre}}</span>

            <span class="a">Fecha de Nacimiento: {{$data->movilidad->fecha_nacimiento}}</span>

            <span class="a">Nacionalidad: {{$data->movilidad->nacionalidad}}</span>

            <!-- <span class="a">Genero: {{$data->movilidad->genero}} </span> -->
            @if (($data->movilidad->genero)==='M')
            <span class="a">Genero: MASCULINO </span>
            @else
            <span class="a">Genero: FEMENINO </span>
            @endif

            <span class="a">Estado civil: {{$data->movilidad->estado_civil}}</span>
            
            <span class="a">Discapacidad: {{$data->movilidad->nombre_discapacidad}}</span>
            
            <span class="a">Correo institucional: {{$data->movilidad->correo_personal_institucional}}</span>

            <span class="a">Correo alternativo: {{$data->movilidad->correo_personal_alternativo}}</span>

        </div>

        <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span style="font-weight:bold">CONTACTO DE EMERGENCIA</span>
        </div>

        <div div class="container2" style=" margin-bottom:6px">
            <span class="a">Nombres: {{$data->movilidad->contacto_emergencia_nombres}}</span>
    
            <span class="a">Apellidos: {{$data->movilidad->contacto_emergencia_apellidos}}</span>
      
            <span class="a">Teléfono: {{$data->movilidad->contacto_emergencia_telefono_1}}</span>
          
            <span class="a">Teléfono: {{$data->movilidad->contacto_emergencia_telefono_2}}</span>
            
        </div>
    <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span style="font-weight:bold">RESIDENCIA</span>
    </div>
        <div div class="container3" style=" margin-bottom:6px">
            <span class="a">País: {{$data->movilidad->pais}}</span>
    
            <span class="a">Provincia: {{$data->movilidad->provincia}}</span>
      
            <span class="a">Cantón: {{$data->movilidad->canton}}</span>
            
            <span class="a">Calle 1: {{$data->movilidad->residencia_calle_1}}</span>
            
            <span class="a">Calle 2: {{$data->movilidad->residencia_calle_2}}</span>
            
            <span class="a">Calle 3: {{$data->movilidad->residencia_calle_3}}</span>

            <span class="a">Teléfono domicilio: {{$data->movilidad->telefono_personal_domicilio}}</span>

            <span class="a">Teléfono personal: {{$data->movilidad->telefono_personal_celular}}</span>
        </div>

        <div class="page-break"></div>
        <div style="padding-top: 50px;">
    <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span style="font-weight:bold">DATOS SOLICITUD BECAS</span>
    </div>
    </div>
    <div class="container4" style=" margin-bottom:6px">
    
            <span class="c">Carrera: {{$data->movilidad->nombre_carrera}}</span>
    
            <span class="d">Modalidad: {{$data->movilidad->modalidad}}</span>
        
            <span class="d">Destino: {{$data->movilidad->tipo_destino}}</span>
   
            <span class="c">Universidad Destino:{{$data->movilidad->universidad_destino}}</span>
           
            
             <!-- </div>  -->
            <!-- <div class="page-break"></div> -->
            <!-- <div class="container5" style=" margin-bottom:6px"> -->
            <span class="c">Carrera Destino: {{$data->movilidad->carrera_destino}}</span>
        
             <span class="a">Semestre a Cursar: {{$data->movilidad->semestre_cursar}}</span>
  
             <span class="a">Fecha Incio: {{$data->movilidad->fecha_inicio}}</span>
             
            <span class="a">Fecha Fin: {{$data->movilidad->fecha_fin}}</span>
        
             <span class="a">Naturaleza: {{$data->movilidad->naturaleza}}</span>
        
             <span class="a">Becas o Apoyo: {{$data->movilidad->beca_apoyo}}</span>
        
             <span class="c">Monto: {{$data->movilidad->monto_referencial}}</span>
            
          
           
             
    
             </div>
             
        <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span>ESPECIFICACIONES ESPECIALES</span>
        </div>

      <div class="container5" style=" margin-bottom:6px">
             <span class="d">Tipo Alergias: {{$data->movilidad->alergias}}</span>

             <!-- <span class="d">Poliza de Seguro: {{$data->movilidad->poliza_seguro}}</span> -->
            
            @if (($data->movilidad->poliza_seguro)==='N')
            <span class="d">Poliza de Seguro: NO </span>
            @else
            <span class="d">Poliza de Seguro: SI </span>
            @endif

             <!-- <span class="e"> -->
             <div >  
             Especificar Alergias: <?=$data->movilidad->especificar_alergia ?> 
             </div>  
            <!-- </span> -->

             <!-- <span class="e"> -->
             <div> 
             Enfermedades Cronicas y Tratamiento: <?=$data->movilidad->enfermedades_tratamiento ?>
             </div>  
            <!-- </span> -->

            <div class="page-break"></div>
    </div>
    <div style="padding-top: 50px;">
    <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span>HOMOLOGACION DE ESTUDIOS</span>
    </div>
    </div>

    <table >
            <thead>
                <tr>
                    <th scope="col" style="width:30%;  border: 1px solid blue; ">Materia Origen</th>
                    <th scope="col" style="width:30%;  border: 1px solid blue; ">Clave</th>
                    <th scope="col" style="width:30%;  border: 1px solid blue; ">Materia Destino</th>
                    <th scope="col" style="width:30%;  border: 1px solid blue; ">Clave</th>
                  </tr>
            </thead>
            <tbody>
              
                @for($i = 0; $i < count($data->movilidad->materias); $i++)
                <tr>
                    <td style="width:30%">{{ $data->movilidad->materias[$i]->materia_origen }}</td>
                    <td style="width:30%">{{ $data->movilidad->materias[$i]->codigo_origen }}</td>
                    <td style="width:30%">{{ $data->movilidad->materias[$i]->materia_destino }}</td>
                    <td style="width:30%">{{ $data->movilidad->materias[$i]->codigo_destino }}</td>
                </tr>
                @endfor
                
            </tbody>
        </table>
    </main>

    <!-- <footer>
        <h1>www.styde.net</h1>
    </footer> -->
</body>

</html>