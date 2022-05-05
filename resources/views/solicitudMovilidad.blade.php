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
                    <h2 class="card-title font-weight-bold">Solicitudes</h2>
              </div>
            <div class="row" class="justify" style="margin-left:10%; margin-top:5%">
              <div class="card-body"   class="col-sm">
                    <table class="table table-bordered">
                        <thead>
                           
                               <div style="margin-right: 10px; font-weight: bold">
                               <p>Cédula</p>
                               <p>Apellido Paterno</p>
                               <p>Apellido Materno</p>
                               <p>Nombres</p>
                               <p>Fecha de Nacimiento</p>
                               <p>Nacionalidad</p>
                               <p>Genero</p>
                               <p>Estado civil</p>
                               <p>Discapacidad</p>
                               <p>Tipo de sangre</p>
                               <p>Correo institucional</p>
                               <p>Correo personal</p>
                               <h3 style="font-weight-bold">Contacto de Emergencia</h3>
                               <p>Nombres</p>
                               <p>Apellidos</p>
                               <p>Teléfono</p>
                               <p>Teléfono</p>
                               <h3 style="font-weight-bold">Residencia</h3>
                               <p>País</p>
                               <p>Provincia</p>
                               <p>Cantón</p>
                               <p>Residencia calle 1</p>
                               <p>Residencia calle 2</p>
                               <p>Residencia calle 3</p>
                               <p>Teléfono domicilio</p>
                               <p>Teléfono personal</p>
                              
                              
                               </div>
                          
                        </thead>
                        </div>

                       
                            @forelse ($datos as $b2)
                              <div class="row" class="col-sm">
                                  <div style="margin-top: 3%; text-align: justify">
                                <p>{{ $b2->cedula }}</p>
                                <p>{{ $b2->apellido1 }}</p>
                                <p>{{ $b2->apellido2 }}</p>
                                <p>{{ $b2->nombres}}</p> 
                                <p>{{ $b2->fecha_nacimiento}}</p> 
                                <p>{{ $b2->nacionalidad}}</p> 
                                <p>{{ $b2->genero}}</p>
                                <p>{{ $b2->estado_civil}}</p>
                                <p>{{ $b2->nombre_discapacidad}}</p>
                                <p>{{ $b2->tipo_sangre}}</p>
                                <p>{{ $b2->correo_personal_institucional}}</p> 
                                <p>{{ $b2->correo_personal_alternativo}}</p>
                                <p><br></p> 
                                <p>{{ $b2->contacto_emergencia_nombres}}</p>
                                <p>{{ $b2->contacto_emergencia_apellidos}}</p> 
                                <p>{{ $b2->contacto_emergencia_telefono_1}}</p> 
                                <p>{{ $b2->contacto_emergencia_telefono_2}}</p>                    
                                <p><br></p>
                                <p>{{ $b2->pais}}</p>
                                <p>{{ $b2->provincia}}</p>
                                <p>{{ $b2->canton}}</p> 
                                <p>{{ $b2->residencia_calle_1}}</p> 
                                <p>{{ $b2->residencia_calle_2}}</p> 
                                <p>{{ $b2->residencia_calle_3}}</p> 
                                <p>{{ $b2->telefono_personal_domicilio}}</p> 
                                <p>{{ $b2->telefono_personal_celular}}</p> 
                               
                            </div>
                                  
                                </div>
                               

                            @empty

                            @endforelse
                        
                    </table>
                    </main>

    <!-- <footer>
        <h1>www.styde.net</h1>
    </footer> -->
</body>

</html>