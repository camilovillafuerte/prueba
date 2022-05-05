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

th, td {
    border: 1px solid blue;
    width: 100px;
    word-wrap: break-word;
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
           <h4 style="margin-bottom: 10px; margin-top: 10px;">Reporte de Becas Aprobados</h4>
           @elseif($data->request->estado == 'R')
           <h4>Reporte de Becas Rechazadas</h4>
           @else
           <h4>Reporte de Becas Pendientes</h4>
           @endif
        </div>

       <main style="margin-left: -10px; margin-top: 1.5rem;">
        <table border="2">
            <thead>
                <tr>
                    <th style="width: 5%;" scope="col" >#</th>
                    <th style="width: 12%;" scope="col" >Cédula</th>
                    <th style="width: 23%;" scope="col" >Nombres</th>
                    <th style="width: 20%;" scope="col" >Universidad Destino</th>
                    <th style="width: 15%;" scope="col" >Facultad</th>
                    <th style="width: 13%;" scope="col" >Naturaleza Movilidad</th>
                    <th style="width: 12%;" scope="col" >Fecha Inicio</th>
                    <th style="width: 12%;" scope="col" >Fecha Fin</th>
                  </tr>
            </thead>
            <tbody>
                @if(count($data->becas)>0)
                @for($i = 0; $i < count($data->becas); $i++)
                <tr>
                    <th scope="col" style="width: 5%;">{{ $i + 1 }}</th>
                    <td style="width: 12%;" class="text-center">{{ $data->becas[$i]->cedula }}</td>
                    <td style="width: 23%;" class="text-center">{{ $data->becas[$i]->nombres }} {{ $data->becas[$i]->apellidos }}</td>
                    <td style="width: 20%;" class="text-center">{{ $data->becas[$i]->universidad_destino }}</td>
                    <td style="width: 15%;" class="text-center">{{ $data->becas[$i]->nombre_facultad }}</td>
                    <td style="width: 13%;" class="text-center">{{ $data->becas[$i]->naturaleza }}</td>
                    <td style="width: 12%;" class="text-center">{{ $data->becas[$i]->fecha_inicio }}</td>
                    <td style="width: 12%;" class="text-center">{{ $data->becas[$i]->fecha_fin }}</td>
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
                        Total de resultados: {{ count($data->becas) }}
                    </small>
                </div>
            </div>
        </footer>

    </body>
</html>