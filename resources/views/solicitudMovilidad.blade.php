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
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #f4f4f4;
            color: black;
            text-align: center;
            line-height: 35px;
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
        
        th, td {
    border: 1px solid blue;
    width: 175px;
    word-wrap: break-word;
}
</style>

    </style>
</head>

<body>
    <header>
        <div style="display: flex; justify-content: space-between;">
            <div style="width: 100% !important; ">
            <div class="box">
                    <img src='http://3.15.185.2/Contenido/Imagenes/escudo.png' alt="" style="margin-left: -650px;margin-top:3px;">
                </div>
            </div>
    </header>

    <main>
    <div class="card mt-4">
              <div class="card-header" style="margin-top: 3%;">
                    <h2 class="card-title font-weight-bold">Solicitudes de Movilidad</h2>
              </div>
              </div>
              <div class="border ">
                            <h4>DATOS PERSONALES</h4>
                </div>
                    <table   style="margin: 0 auto;" >
                    <thead >
                        <tr>
                        @forelse ($datos as $b2)
                                    <th>Cedula</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->cedula }}</td>

                                    <th>Nombres</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->nombres }}</td>
                        </tr>
                        <tr>
                                    <th>Apellido Paterno</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->apellido1 }}</td>

                                    <th>Apellido Materno</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->apellido2 }}</td>
                        </tr>
                      
                        <tr>
                         <th>Tipo de Sangre</th>
                        <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;"> {{ $b2->tipo_sangre }}</td>
      
                         <th>Fecha de nacimiento</th>
                           <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;"> {{ $b2->fecha_nacimiento }}</td> 
                           </tr>
                           <tr>   
                         <th>Nacionalidad</th>
                        <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;"> {{ $b2->nacionalidad }}</td>   
     
                         <th>Genero</th>
                        <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->genero}}</td>    
                        </tr>

                        <tr>
                        <th>Estado Civil</th>
                        <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->estado_civil}}</td>    
                        
                        <th>Discapacidad</th>
                        <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->nombre_discapacidad}}</td>    
                        
                        </tr>

                        <tr>
                        <th>Correo Insitucional</th>
                        <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->correo_personal_institucional}}</td>    
                        </tr>
                        <tr>
                        <th>Correo Alternativo</th>
                        <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->correo_personal_alternativo}}</td>    
                        </tr>
                        

                        @empty
                        @endforelse
       
                
                </thead>
                </table >
                <div class="border ">
                            <h4>CONTACTO DE EMERGENCIA</h4>
                         </div>

                    <table   style="margin: 0 auto;" >
                    <thead >
                        <tr>
                        @forelse ($datos as $b2)
                                    <th>Nombres</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->contacto_emergencia_nombres}}</td>

                                    <th>Apellidos</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->contacto_emergencia_apellidos}}</td>
                        </tr>
                        <tr>
                      
                                    <th>Telefono 1</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->contacto_emergencia_telefono_1 }}</td>

                                    <th>Telefono 2</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->contacto_emergencia_telefono_2}}</td>
                        </tr>
                        @empty
                        @endforelse
                </thead>
                </table>
                <div class="border ">
                            <h4>RESIDENCIA</h4>
                         </div>
                         <table style="margin: 0 auto;">
                    <thead >
                        <tr>
                        @forelse ($datos as $b2)
                                    <th>País</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->pais}}</td>

                                    <th>Provincia</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->provincia}}</td>
                                    </tr>
                                    <tr>
                                    <th>Canton </th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->canton }}</td>
                                    <th>Calle 1</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->residencia_calle_1}}</td>
                                    </tr>
                                    <tr>
                                    <th>Calle 2</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->residencia_calle_2}}</td> 
                                    <th>Calle 3</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->residencia_calle_3}}</td> 
                                    </tr>
                                    <tr>
                                    <th>Telefono Personal Domicilio</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->telefono_personal_domicilio}}</td> 
                                    </tr>
                                    <tr>
                                    <th>Telefono Personal Celular </th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->telefono_personal_celular}}</td> 
                                    </tr>
                        @empty
                        @endforelse
                </thead>
                </table>
                <div class="border " >
                            <h4>SOLICITUD</h4>
                         </div>

                         <table   style="margin: 0 auto;">
                    <thead >
                        <tr>
                        @forelse ($datos as $b2)
                                    <th>Carrera</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->nombre_carrera}}</td>

                                    <th>Modalidad</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->modalidad}}</td>
                                    </tr>
                                    <tr>
                                    <th>Tipo Destino </th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->tipo_destino }}</td>
                                    <th>Universidad Destino</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->universidad_destino}}</td>
                                    </tr>
                                    <tr>
                                    <th>Carrera Destino</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->carrera_destino}}</td> 
                                    <th>Semestre a cursar</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->semestre_cursar}}</td> 
                                    </tr>
                                    <tr>
                                    <th>Fecha Inicio</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->fecha_inicio}}</td> 
                                    </tr>
                                    <tr>
                                    <th>Fecha Fin</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->fecha_fin}}</td> 
                                    </tr>
                                    <tr>
                                    <th>Naturaleza</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->naturaleza}}</td> 
                                    <th>Becas o Apoyo</th>
                                    <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->beca_apoyo}}</td> 
                                    </tr>
                                    <tr>
                                        <th> Monto</th>
                                        <td style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $b2->monto_referencial}}</td> 
                                   
                                    </tr>
                        @empty
                        @endforelse
                </thead>
                </table>         
                       
                    </main>

    <!-- <footer>
        <h1>www.styde.net</h1>
    </footer> -->
</body>

</html>