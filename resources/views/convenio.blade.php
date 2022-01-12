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
            background-color: #f4f4f4;
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
    </style>
</head>

<body>
    <header>
        <h1>Hola mundo</h1>
        <!-- <img src="./../../public/logo_u.jpeg" alt=""> -->
        <!-- <img src="{{ asset('img/logo_u.jpeg') }}" alt="" /> -->
        <!-- <h1>{{ $data }}</h1> -->
    </header>

    <main>
        <h1>Contenido</h1>
        @foreach($data as $c)
        <li>{{ $c->titulo_convenio }}</li>
        @endforeach
    </main>

    <footer>
        <h1>www.styde.net</h1>
    </footer>
</body>

</html>
