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

        .justify{
            text-align: justify;
        }

        .d-flex{
            display: flex !important;
            flex: 1 1;
        }

        .mb-3{
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <header>
        <div style="width: 100% !important;">
            <img src='http://3.15.185.2/Contenido/Imagenes/escudo.png' alt="" width="50px"
            style="margin-left: 700px;">
        </div>
    </header>

    <main>


        @for($i = 0; $i < count($data->nombre_convenio); $i++)
        <h4 class="justify"> {{ $data->nombre_convenio[$i] }} </h4>
            @if($i > 0)
            <br>
            @endif
        @endfor

        @for($i = 0; $i < count($data->comparecientes); $i++)
        <p class="justify">{{ $data->comparecientes[$i] }}</p>
            @if($i > 0)
            <br>
            @endif
        @endfor

        @for($i = 0; $i < count($data->clausulas); $i++)
        <div class="justify">
            <h4>{{ $i + 1 }}° {{ $data->clausulas[$i]['nombre'] }}</h4>

            <p class="justify">{{ $data->clausulas[$i]['descripcion'] }}</p>

            @for($j = 0; $j < count($data->clausulas[$i]['articulos']); $j++)
           <div class="mb-3" class="justify">
               @for($k = 0; $k < count($data->clausulas[$i]['articulos'][$j]['des_art']); $k++)
                <div class="justify" style="display: inline-block;">
                    @if($k == 0)
                        <span style="margin-right: 10px; font-weight: bold;" class="justify">{{ $i + 1 }}.{{ $j + 1}}</span>
                        <p style="margin-left: 40px; margin-top: -20px">
                            <span> {{ $data->clausulas[$i]['articulos'][$j]['des_art'][$k] }} </span>
                        </p>
                    @else
                        <p style="margin-left: 30px; margin-top: 0x">
                            <span> {{ $data->clausulas[$i]['articulos'][$j]['des_art'][$k] }} </span>
                        </p>
                    @endif
                </div>
                @if($k > 0)
                    <br>
                @endif
               @endfor
           </div>
           @endfor
        </div>
        @endfor

        <!-- Firmas -->
        <!-- <div style="margin-top: 50px !important;">
            <div style="width: 100px;">1</div>
            <div style="width: 100px;">2</div>
        </div> -->
        <table style="width: 100%; margin-top: 50px;">
            <thead style="width: 100%;">
                <tr style="width: 100%;">
                    <th style="width: 50%">
                        <div>
                            <p style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $data->firmaEmisor[0]['nombre']}}</p>
                            <p style="margin-top:5px; margin-bottom:1px">{{ $data->firmaEmisor[0]['cargo']}}</p>
                            <p style="margin-top:5px; margin-bottom:1px">{{ $data->firmaEmisor[0]['institucion']}}</p>
                        </div>
                    </th>
                    <th style="width: 50%">
                        <div style="">
                            <p style="margin-top:10px; margin-bottom:1px; font-weight: lighter;">{{ $data->firmaReceptor[0]['nombre']}}</p>
                            <p style="margin-top:5px; margin-bottom:1px">{{ $data->firmaReceptor[0]['cargo']}}</p>
                            <p style="margin-top:5px; margin-bottom:1px">{{ $data->firmaReceptor[0]['institucion']}}</p>
                        </div>
                    </th>
                </tr>
            </thead>
        </table>
    </main>

    <!-- <footer>
        <h1>www.styde.net</h1>
    </footer> -->
</body>

</html>
