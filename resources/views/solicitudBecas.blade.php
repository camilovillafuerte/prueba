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

        
.border{
   
   border-bottom: 2px solid rgb(187, 216, 190) !important;
    margin-bottom: 2%;
    background-color: rgb(187, 216, 190);
    margin-top: 1.5%;
    text-align: center;
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
                <h1 class="mt-3">Solicitud de Beca</h1>
            </div>
        </div>
    </header>

    <main>
    <div class="border ">
    <h4> DATOS PERSONALES</h4>
    </div>
    <div class="row" style="margin-bottom: 2%;">
                            <div class="col-sm">
                                    <h5>Cedula</h5>
                                    <p> {{$data->solicitudmovilidad->cedula }}</p>
                            </div>
                            <div class="col-sm">
                                    <h5>Nombres</h5>
                                    <p> {{$data->solicitudmovilidad->nombres }}</p>
                            </div>
                            <div class="col-sm">
                                    <h5>Apellido 1</h5>
                                    <p> {{$data->solicitudmovilidad->apellido1 }}</p>
                            </div>
                            <div class="col-sm">
                                    <h5>Apellido 2</h5>
                                    <p> {{$data->solicitudmovilidad->apellido2 }}</p>
                            </div>
                        </div>

            <div class="row" style="margin-bottom: 2%;">
                     <div class="col-sm">
                        <h5>Tipo de Sangre<h5>
                        <p> {{$data->solicitudmovilidad->tipo_Sangre }}</p>
                    </div>
                    <div class="col-sm">
                        <h5>Fecha de nacimiento</h5>
                        <p> {{$data->solicitudmovilidad->fecha_nacimiento }}</p>
                    </div>
                    <div class="col-sm">
                        <h5>Nacionalidad</h5>
                        <p> {{$data->solicitudmovilidad->nacionalidad }}</p>
                    </div>
                    <div class="col-sm">
                         <h5>Genero</h5>
                         <p> {{$data->solicitudmovilidad->genero }}</p>
                    </div>
            </div>

        <div class="row" style="margin-bottom: 2%; text-align: center;">
            <div class="col-sm">
             <h5>Estado civil</h5>
             <p> {{$data->solicitudmovilidad->estado_civil }}</p>
            </div>
        <div class="col-sm">
            <h5>Discapacidad</h5>
            <p> {{$data->solicitudmovilidad->nombre_discapacidad }}</p>
        </div>
    </div>
        <div class="row" style="margin-bottom: 2%; text-align: center;">
            <div class="col-sm">
             <h5>Correo institucional</h5>
             <p> {{$data->solicitudmovilidad->correo_personal_institucional }}</p>
            </div>
        <div class="col-sm">
            <h5>Correo Alternativo</h5>
            <p> {{$data->solicitudmovilidad->correo_personal_alternativo }}</p>
        </div>
    </div>

    <div class="border ">
    <h4> CONTACTO DE EMERGENCIA</h4>
    </div>
        <div class="row">
        <div class="col-sm">
            <h5>Nombres</h5>
            <p> {{$data->solicitudmovilidad->contacto_emergencia_nombres }}</p>
            </div>
        <div class="col-sm">
            <h5>Apellidos</h5>
            <p> {{$data->solicitudmovilidad->contacto_emergencia_apellidos }}</p>
            </div>
        <div class="col-sm">
            <h5>Telefono 1</h5>
            <p> {{$data->solicitudmovilidad->contacto_emergencia_telefono_1 }}</p>
            </div>
        <div class="col-sm">
            <h5>Telefono 2</h5>
            <p> {{$data->solicitudmovilidad->contacto_emergencia_telefono_2 }}</p>
            </div>
    </div>

    <div class="border ">
    <h4> RESIDENCIA</h4>
    </div>
    <div class="row">
        <div class="col-sm">
            <h5>Pais</h5>
            <p> {{$data->solicitudmovilidad->pais }}</p>
        </div>
        <div class="col-sm">
            <h5>Provincia</h5>
            <p> {{$data->solicitudmovilidad->provincia }}</p>
        </div>
        <div class="col-sm">
            <h5>Canton</h5>
            <p> {{$data->solicitudmovilidad->canton }}</p>
        </div>
        </div>
        <div class="row" style="margin-bottom: 2%;">
        <div class="col-sm">
            <h5>Calle 1</h5>
            <p> {{$data->solicitudmovilidad->residencia_calle_1 }}</p>
         </div>
        <div class="col-sm">
            <h5>Calle 2</h5>
            <p> {{$data->solicitudmovilidad->residencia_calle_2 }}</p>
        </div>
        <div class="col-sm">
            <h5>Calle 3</h5>
            <p> {{$data->solicitudmovilidad->residencia_calle_3 }}</p>
        </div>
        </div>

    <div class="row" style="margin-bottom: 2%;">
        <div class="col-sm">
            <h5>Telefono Personal Domicilio</h5>
            <p> {{$data->solicitudmovilidad->telefono_personal_domicilio }}</p>
        </div>
        <div class="col-sm">
            <h5>Telefono Personal Celular</h5>
            <p> {{$data->solicitudmovilidad->telefono_personal_celular }}</p>               
        </div>

</div>       
    </main>

    <!-- <footer>
        <h1>www.styde.net</h1>
    </footer> -->
</body>

</html>
