
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
                <h5 style="margin-top: 10px;margin-left: 430px;">Desde {{ $data->request->fecha_inicio }} Hasta {{ $data->request->fecha_fin }}</h5>
                 @if($data->request->tipo_documento == 'A')
                <h4 style="margin-bottom: 10px; margin-top: 10px;">Reporte de convenios Aprobados</h4>
                @elseif($data->request->tipo_documento == 'G')
                <h4>Reporte de convenios Guardados</h4>
                @else
                <h4>Reporte de convenios Plantillas</h4>
                @endif
               

    <main style="margin-left: -10px; margin-top: 1.5rem;">
        <table >
            <thead>
                <tr>
                    <th scope="col" class="w-10">#</th>
                    <th scope="col" class="w-65">Título</th>
                    <th scope="col" class="w-25">Fecha de creación</th>
                  </tr>
            </thead>
            <tbody>
                @if($data->convenios->count() > 0)
                @for($i = 0; $i < $data->convenios->count(); $i++)
                <tr>
                    <th scope="col" class="w-10">{{ $i + 1 }}</th>
                    <td class="w-65">{{ $data->convenios[$i]->titulo_convenio }}</td>
                    <td class="w-25 text-center">{{ $data->convenios[$i]->f_creaciondoc }}</td>
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
                    Total de resultados: {{ $data->convenios->count() }}
                </small>
            </div>
        </div>
    </footer>
</body>
</html>