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
            background-color: #eee;
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
            <img src='../storage/app/files/logo_u.jpeg' alt="" width="50px"
            style="margin-left: 700px;">
        </div>
    </header>

    <main>


        <h4 class="justify"> {{ $data->nombre_convenio }} </h4>

        <p class="justify">{{ $data->comparecientes }}</p>

        <!-- <p> Ambas partes de forma libre y voluntaria convienen celebrar el presente instrumento, al tenor de las siguientes
            CLÁUSULAS:</p> -->

        @for($i = 0; $i < count($data->clausulas); $i++)
        <div class="justify">
            <h4>{{ $i + 1 }}° {{ $data->clausulas[$i]['nombre'] }}</h4>

            <p class="justify">{{ $data->clausulas[$i]['descripcion'] }}</p>

            @for($j = 0; $j < count($data->clausulas[$i]['articulos']); $j++)
           <div class="mb-3" class="justify">
               <span style="margin-right: 10px; font-weight: bold;" class="justify">{{ $i + 1 }}.{{ $j + 1}}</span>
               {{ $data->clausulas[$i]['articulos'][$j]['des_art'] }}
           </div>
           @endfor
        </div>
        @endfor

        <!-- <div>
            <h4>2° Antecendes</h4>

           <div class="mb-3">
               <span style="margin-right: 10px; font-weight: bold;">2.1</span>
               Hola mundo
           </div>

           <div>
               <span style="margin-right: 10px; font-weight: bold;">2.2</span>
               Hola mundo 2
           </div>
        </div> -->

        <!-- Firmas -->
        <!-- <div style="margin-top: 50px !important;">
            <div style="width: 100px;">1</div>
            <div style="width: 100px;">2</div>
        </div> -->
        <table style="width: 100%; margin-top: 40px;">
            <thead style="width: 100%;">
                <tr>
                    <th>
                        <div>
                            Firma 1
                        </div>
                    </th>
                    <th>
                        <div>
                            Firma 2
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
