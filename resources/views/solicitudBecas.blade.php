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
    
            main{
                width: 100% !important;
            }
    
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

th, td {
    border: 1px solid blue;
    width: 100px;
    word-wrap: break-word;
}

.item{
    /* margin:1em;
    padding:1em; */
    float:left;
}

.item2{
    float:left;
}
.container{
    width: 100%;
    overflow:hidden;
}
.page-break {
    page-break-after: always;
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
                    <h1 class="mt-3">Solicitudes de Becas</h1>
                  
                </div>
            </div>
        </header>


       <main style="margin-top: 1.5rem;">

        <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span>DATOS PERSONALES</span>
        </div>
        
<!-- <div class="container">>-->
         
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Cedula:</span>
             <span>{{$data->becas->cedula}}</span>
         </div>
         <div class="item"; style="width: 33%;padding: 10px;border: 1px solid black;">
            <span>Nombres:</span>
            <span>{{$data->becas->nombres}}</span>
        </div>
        <div class="item"; style="width: 29.8%;padding: 10px;border: 1px solid black;">
            <span>Apellido Paterno:</span>
            <span>{{$data->becas->apellido1}}</span>
        </div>
        <div class="row";  style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Apellido Materno:</span>
            <span>{{$data->becas->apellido2}}</span>
        </div>
        <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Tipo de Sangre:</span>
            <span>{{$data->becas->tipo_sangre}}</span>
        </div>
        <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Fecha de Nacimiento:</span>
            <span>{{$data->becas->fecha_nacimiento}}</span>
        </div>
        <div class="row"; style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Nacionalidad:</span>
            <span>{{$data->becas->nacionalidad}}</span>
        </div>
        <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Genero:</span>
            <span>{{$data->becas->genero}}</span>
        </div>
        <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Estado civil:</span>
            <span>{{$data->becas->estado_civil}}</span>
        </div>
        <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Discapacidad:</span>
            <span>{{$data->becas->nombre_discapacidad}}</span>
        </div>
        <div class="row"; style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Correo institucional:</span>
            <span>{{$data->becas->correo_personal_institucional}}</span>
        </div>
        <div class="row"; style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Correo alternativo:</span>
            <span>{{$data->becas->correo_personal_alternativo}}</span>
        </div>
      
        <!-- </div> -->

        <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span>CONTACTO DE EMERGENCIA</span>
        </div>
        <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Nombres:</span>
             <span>{{$data->becas->contacto_emergencia_nombres}}</span>
         </div>
         <div class="item"; style="width: 33%;padding: 10px;border: 1px solid black;">
            <span>Apellidos:</span>
            <span>{{$data->becas->contacto_emergencia_apellidos}}</span>
        </div>
        <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Teléfono:</span>
            <span>{{$data->becas->contacto_emergencia_telefono_1}}</span>
        </div>
        <div class="row"; style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Teléfono:</span>
            <span>{{$data->becas->contacto_emergencia_telefono_2}}</span>
        </div>

        <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span>RESIDENCIA</span>
        </div>

        <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>País:</span>
             <span>{{$data->becas->pais}}</span>
         </div>
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Provincia:</span>
             <span>{{$data->becas->provincia}}</span>
         </div>
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Cantón:</span>
             <span>{{$data->becas->canton}}</span>
         </div>
         <div class="row"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Calle 1:</span>
             <span>{{$data->becas->residencia_calle_1}}</span>
         </div>
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Calle 2:</span>
             <span>{{$data->becas->residencia_calle_2}}</span>
         </div>
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Calle 3:</span>
             <span>{{$data->becas->residencia_calle_3}}</span>
         </div>
         <div class="row"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Teléfono domicilio:</span>
             <span>{{$data->becas->telefono_personal_domicilio}}</span>
         </div>
         <div class="row"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Télefono Personal:</span>
             <span>{{$data->becas->telefono_personal_celular}}</span>
         </div>
        <div class="page-break"></div>
         <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span>DATOS SOLICITUD BECAS</span>
        </div>
        <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Facultad:</span>
             <span>{{$data->becas->nombre_facultad}}</span>
         </div>
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Modalidad:</span>
             <span>{{$data->becas->modalidad}}</span>
         </div>
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Destino:</span>
             <span>{{$data->becas->tipo_destino}}</span>
         </div>
         <div class="row"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Universidad Destino:</span>
             <span>{{$data->becas->universidad_destino}}</span>
         </div>
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Campus Destino:</span>
             <span>{{$data->becas->campus_destino}}</span>
         </div>
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Numero Semestre:</span>
             <span>{{$data->becas->numero_semestre}}</span>
         </div>
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Fecha Incio:</span>
             <span>{{$data->becas->fecha_inicio}}</span>
         </div>
         <div class="row"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Fecha Fin:</span>
             <span>{{$data->becas->fecha_fin}}</span>
         </div>
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Naturaleza:</span>
             <span>{{$data->becas->naturaleza}}</span>
         </div>
         <div class="item"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Becas o Apoyo:</span>
             <span>{{$data->becas->beca_apoyo}}</span>
         </div>
         <div class="row"; style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Monto:</span>
             <span>{{$data->becas->monto_referencial}}</span>
         </div>

         <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span>ESPECIFICACIONES ESPECIALES</span>
        </div>

        <div class="item"; style="width: 30%; height: 5%; padding: 10px;border: 1px solid black;">
             <span>Tipo Alergias:</span>
             <span>{{$data->becas->alergias}}</span>
         </div>
         <div class="item"; style="width: 30%; height: 5%; padding: 10px;border: 1px solid black;">
             <span>Especificar Alergias:</span>
             <span>{{$data->becas->especificar_alergia}}</span>
         </div>
         <div class="item"; style="width: 32.8%; height: 5%; padding: 10px;border: 1px solid black;">
             <span>Enfermedades Cronicas y Tratamiento:</span>
             <span>{{$data->becas->enfermedades_tratamiento}}</span>
         </div>
         <div class="row"; style="width: 30%; height: 5%; padding: 10px;border: 1px solid black;">
             <span>Poliza de Seguro:</span>
             <span>{{$data->becas->poliza_seguro}}</span>
         </div>

    </main>
        <!-- <footer >
            
        </footer> -->

    </body>
</html>