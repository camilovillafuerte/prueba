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

    </style>
</head>

<body>
    <header>
        <div style="display: flex; justify-content: space-between;">
            <div style="width: 100% !important; ">
            <div class="box">
                    <img src='{{ $data->urlimagen1 }}' alt="" style="margin-left: -650px;margin-top:3px;">
                </div>
            </div>


            <div style="width: 100% !important; ">
            <div class="box">
                    <img src='{{ $data->urlimagen2 }}' alt=""  style="margin-left: 650px;margin-top:3px;">
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="justify"> <?= $data->nombre_convenio ?></div>
        <div class="justify"><?= $data->comparecientes ?></div>

        @for($i = 0; $i < count($data->clausulas); $i++)
            <div class="justify">
                <h4>{{ $i + 1 }}° {{ $data->clausulas[$i]['nombre'] }}</h4>
                <div class="justify" style="margin-top: -20px;"><?= $data->clausulas[$i]['descripcion'] ?></div>
            </div>

            @for($j = 0; $j < count($data->clausulas[$i]['articulos']); $j++)
                <div class="justify mb-3">
                    <div class="justify" style="display: inline-block;">
                        <span style="margin-right: 10px; font-weight: bold; margin-top:10px;" class="justify">{{ $i + 1 }}.{{ $j + 1}}</span>
                        <div style="margin-left: 40px; margin-top: -35px"> <?= $data->clausulas[$i]['articulos'][$j]['des_art'] ?> </div>

                    </div>
                </div>
                @endfor
                @endfor

                <table style="width: 100%; margin-top: 100px;">
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
