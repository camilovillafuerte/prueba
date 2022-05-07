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
#contenedor {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
}

#contenedor > div {
  width: 50%;
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
                    <h1 class="mt-3">Solicitudes de Becas</h1>
                  
                </div>
            </div>
        </header>


       <main style="margin-top: 1.5rem;">

        <div style="width: 100% !important; padding: 10px; text-align: center; background-color: rgb(63, 151, 67)">
           <span>DATOS PERSONALES</span>
        </div>
        

         <div style="width: 30%;padding: 10px;border: 1px solid black;">
             <span>Cedula:</span>
             <span>{{$data->becas->cedula}}</span>
         </div>
         <div style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Nombres:</span>
            <span>{{$data->becas->nombres}}</span>
        </div>
        <div style="width: 30%;padding: 10px;border: 1px solid black;">
            <span>Apellido Paterno:</span>
            <span>{{$data->becas->apellido1}}</span>
        </div>



        {{-- <table border="2">
            <thead>
                <tr>

                    <th style="width: 12%;" scope="col" >Cédula</th>
                    <th style="width: 23%;" scope="col" >Nombres</th>
                    <th style="width: 20%;" scope="col" >Apellido1</th>
                    <th style="width: 15%;" scope="col" >Apellido2</th>
           
                  </tr>
            </thead>
            <tbody>

                <tr>

                    <td style="width: 12%;" class="text-center">{{ $data->becas->cedula }}</td>
                    <td style="width: 23%;" class="text-center">{{ $data->becas->nombres }} </td>
                    <td style="width: 20%;" class="text-center">{{ $data->becas->apellido1 }}</td>
                    <td style="width: 15%;" class="text-center">{{ $data->becas->apellido2 }}</td>
 
                </tr>

            </tbody>
        </table> --}}
    </main>
        <!-- <footer >
            
        </footer> -->

    </body>
</html>