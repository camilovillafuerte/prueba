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
                </div>
            </div>
        </header>

         <div class="m-1"></div>

        <div style="display:flex; margin-top: 40px;align-items: flex-start;">
            <h5 style="margin-top: 10px; margin-left: 700px; ">Desde {{ $data->request->fecha_inicio }} Hasta {{ $data->request->fecha_fin }}</h5>
            @if($data->request->estado == 'A')
           <h4 style="margin-bottom: 10px; margin-top: 10px;">Reporte de Movilidad Aprobados</h4>
           @elseif($data->request->estado == 'R')
           <h4>Reporte de Movilidad Rechazadas</h4>
           @else
           <h4>Reporte de Movilidad Pendientes</h4>
           @endif
        </div>

       <main style="margin-left: -10px; margin-top: 1.5rem;">
        <table >
            <thead>
                <tr>
                    <th scope="col" class="w-5">#</th>
                    <th scope="col" class="w-10">Cédula</th>
                    <th scope="col" class="w-50">Nombres</th>
                    <th scope="col" class="w-30">Universidad Destino</th>
                    <th scope="col" class="w-20">Nombre Carrera</th>
                    <th scope="col" class="w-20">Naturaleza Movilidad</th>
                    <th scope="col" class="w-20">Fecha Inicio</th>
                    <th scope="col" class="w-20">Fecha Fin</th>
                  </tr>
            </thead>
            <tbody>
                @if(count($data->movilidad)>0)
                @for($i = 0; $i < count($data->movilidad); $i++)
                <tr>
                    <th scope="col" class="w-5">{{ $i + 1 }}</th>
                    <td class="w-10">{{ $data->movilidad[$i]->cedula }}</td>
                    <td class="w-50 text-center">{{ $data->movilidad[$i]->nombres }} {{ $data->movilidad[$i]->apellidos }}</td>
                    <td class="w-30 text-center">{{ $data->movilidad[$i]->universidad_destino }}</td>
                    <td class="w-20 text-center">{{ $data->movilidad[$i]->nombre_carrera }}</td>
                    <td class="w-20 text-center">{{ $data->movilidad[$i]->naturaleza }}</td>
                    <td class="w-20 text-center">{{ $data->movilidad[$i]->fecha_inicio }}</td>
                    <td class="w-20 text-center">{{ $data->movilidad[$i]->fecha_fin }}</td>
                </tr>
                @endfor
                @endif
            </tbody>
        </table>
    </main>
        <footer >
            <div style="display: block" style="margin-bottom: 10px !important;">
                <div style="width: 50%; position: absolute; bottom: 0px; left: 0px;">
                    <small>
                        Hora y fecha del reporte {{ date('d-m-Y h:m:s')}}
                    </small>
                </div>
                <div style="width: 50%; position: absolute; bottom: 0px; right: 0px;">
                    <small>
                        Total de resultados: {{ count($data->movilidad) }}
                    </small>
                </div>
            </div>
        </footer>

    </body>
</html>