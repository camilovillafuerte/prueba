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
    
            h1,h2,h3,h4,h5{
                padding: 0px;
                margin: 0px;
            }
    
            table > thead tr > th {
                /* width: 33.33%; */
                border: 1px solid black;
                margin: 0px;
                padding: 7px 0px;
                background: green;
                color: #fff;
            }
    
            table > tbody > tr{
            }
            
            table > tbody > tr > th, table > tbody > tr > td{
                border: 1px solid black;
                padding: 5px 2px;
            }
    
            .w-10{
                width: 10% !important;
            }
    
            .w-25{
                width: 25% !important;
            }
    
            .w-65{
                width: 65% !important;
            }
    
            .text-center{
                text-align: center;
            }
            .m-1{
                margin:0.5rem;
            }

            table{
    table-layout: fixed;
    width: 100%;
}
#contenedor {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
}

#contenedor > div {
  width: 50%;
}



.item{
    width: 30%;
    float:right;
    clear: left;
}


.container{
    width: 660px; 
    overflow: hidden;
    height: 230px; 
    /* border: black 2px dashed;   */
     /* background-color:red;  */
}
.container2{
    width: 660px; 
    overflow: hidden;
    height: 118px; 
    /* border: black 2px dashed;   */
}
.container3{
    width: 660px; 
    overflow: hidden;
    height: 170px; 
    /* border: black 2px dashed;   */
}
.container4{
    width: 660px; 
    overflow: hidden;
    height: 150px; 
    /* border: black 2px dashed;    */
}
.container5{
    width: 660px; 
    overflow: hidden;
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
  padding: 5px;
  border: 1px solid blue;  
  /* background-color: yellow;  */
  text-align: center; 
  font-size: 18px;
}

span.b {
  display: inline-block;
  width: 205px;
  height: 34px;
  padding: 5px;
  margin-top: 5px;
  /* margin-bottom: 8px; */
  border: 1px solid blue;    
  text-align: center; 
  font-size: 18px;
}
span.c {
  display: inline-block;
  width: 648px;
  height: 30px;
  padding: 5px;
  border: 1px solid blue;    
  text-align: justify; 
  font-size: 18px;
  margin-bottom: 1px;
}
span.d {
  display: inline-block; /* the default for span */
  width: 315px;
  height: 40px; 
  margin-top: 6px; 
  padding: 5px;
  border: 1px solid blue;  
  /* background-color: yellow;  */
  text-align: center; 
  font-size: 18px;
}
span.e {
  display: inline-block;
  width: 648px;
  height: 50px;
  padding: 5px;
  border: 1px solid blue;    
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
    
                <div style="width: 100% !important; padding-top:5%; ">
                    <h1 class="mt-3">Solicitud de Becas</h1>
                  
                </div>
            </div>
        </header>


       <main style="margin-top: 1.5rem;">

        <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span style="font-weight:bold">DATOS PERSONALES</span>
        </div>

        <div class="container" style="margin-top: 5px">
     
             <span class="a">Cedula: {{$data->becas->cedula}}</span>
       
             <span class="a">Nombres: {{$data->becas->nombres}}</span>
   
            <span class="a">Apellido Paterno: {{$data->becas->apellido1}}</span>

            <span class="a">Apellido Materno: {{$data->becas->apellido2}}</span>
          
            <span class="a">Tipo de Sangre: {{$data->becas->tipo_sangre}}</span>

            <span class="a">Fecha de Nacimiento: {{$data->becas->fecha_nacimiento}}</span>

            <span class="a">Nacionalidad: {{$data->becas->nacionalidad}}</span>
           
            @if (($data->becas->genero)==='M')
            <span class="a">Genero: MASCULINO </span>
            @else
            <span class="a">Genero: FEMENINO </span>
            @endif
          
            <span class="a">Estado civil: {{$data->becas->estado_civil}}</span>
            
            <span class="a">Discapacidad: {{$data->becas->nombre_discapacidad}}</span>
            
            <span class="a">Correo institucional: {{$data->becas->correo_personal_institucional}}</span>

            <span class="a">Correo alternativo: {{$data->becas->correo_personal_alternativo}}</span>

        </div>

        <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span style="font-weight:bold">CONTACTO DE EMERGENCIA</span>
        </div>

        <div div class="container2" style="margin-top: 5px">
            <span class="a">Nombres: {{$data->becas->contacto_emergencia_nombres}}</span>
    
            <span class="a">Apellidos: {{$data->becas->contacto_emergencia_apellidos}}</span>
      
            <span class="a">Teléfono: {{$data->becas->contacto_emergencia_telefono_1}}</span>
          
            <span class="a">Teléfono: {{$data->becas->contacto_emergencia_telefono_2}}</span>
            
        </div>
    <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span style="font-weight:bold">RESIDENCIA</span>
    </div>
        <div div class="container3" style="margin-top: 5px">
            <span class="a">País: {{$data->becas->pais}}</span>
    
            <span class="a">Provincia: {{$data->becas->provincia}}</span>
      
            <span class="a">Cantón: {{$data->becas->canton}}</span>
            
            <span class="a">Calle 1: {{$data->becas->residencia_calle_1}}</span>
            
            <span class="a">Calle 2: {{$data->becas->residencia_calle_2}}</span>
            
            <span class="a">Calle 3: {{$data->becas->residencia_calle_3}}</span>

            <span class="a">Teléfono domicilio: {{$data->becas->telefono_personal_domicilio}}</span>

            <span class="a">Teléfono personal: {{$data->becas->telefono_personal_celular}}</span>
        </div>
    <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span style="font-weight:bold">DATOS SOLICITUD BECAS</span>
    </div>
    <div class="container4" style="margin-top: 5px">
    
            <span class="a">Facultad: {{$data->becas->nombre_facultad}}</span>
    
            <span class="a">Modalidad: {{$data->becas->modalidad}}</span>
        
            <span class="a">Destino: {{$data->becas->tipo_destino}}</span>
   
            <span class="c">Universidad Destino:{{$data->becas->universidad_destino}}</span>
           
             <span class="c">Campus Destino: {{$data->becas->campus_destino}}</span>
        
             </div> 
            <div class="page-break"></div>
            <div class="container5" style="margin-top: 30px">
           
            <span class="a">Numero Semestre: {{$data->becas->numero_semestre}}</span>
       
            <span class="a">Fecha Incio: {{$data->becas->fecha_inicio}}</span>
             
            <span class="a">Fecha Fin: {{$data->becas->fecha_fin}}</span>
        
             <span class="a">Naturaleza: {{$data->becas->naturaleza}}</span>
        
             <span class="a">Becas o Apoyo: {{$data->becas->beca_apoyo}}</span>
        
             <span class="c">Monto: {{$data->becas->monto_referencial}}</span>
            
          
          
             
    
             </div>
             
        <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span>ESPECIFICACIONES ESPECIALES</span>
        </div>

      <div class="container5" style="margin-top: 5px">
             <span class="d">Tipo Alergias: {{$data->becas->alergias}}</span>

             <!-- <span class="d">Poliza de Seguro: {{$data->becas->poliza_seguro}}</span> -->
             @if (($data->becas->poliza_seguro)==='N')
            <span class="d">Poliza de Seguro: NO </span>
            @else
            <span class="d">Poliza de Seguro: SI </span>
            @endif
          

             <span class="e">Especificar Alergias: {{$data->becas->especificar_alergia}}</span>

             <span class="e">Enfermedades Cronicas y Tratamiento: {{$data->becas->enfermedades_tratamiento}}</span>

    </div>

        

    </main>
        <!-- <footer >
            
        </footer> -->

    </body>
</html>