<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Supreme</title>
        <meta name="title" content="Supreme">
        <meta name="description" content="Supreme">
        <meta name="viewport" content="width=device-width, initial-scale=1,
            maximum-scale=1, user-scalable=no, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap');
            
            @font-face {
                font-family: 'Helvetica';
                src: url('Helvetica-Light.eot');
                src: url('Helvetica-Light.eot?#iefix') format('embedded-opentype'),
                    url('Helvetica-Light.woff2') format('woff2'),
                    url('Helvetica-Light.woff') format('woff'),
                    url('Helvetica-Light.ttf') format('truetype'),
                    url('Helvetica-Light.svg#Helvetica-Light') format('svg');
                font-weight: 300;
                font-style: normal;
                font-display: swap;
            }

            @font-face {
                font-family: 'Helvetica';
                src: url('Helvetica.eot');
                src: url('Helvetica.eot?#iefix') format('embedded-opentype'),
                    url('Helvetica.woff2') format('woff2'),
                    url('Helvetica.woff') format('woff'),
                    url('Helvetica.ttf') format('truetype'),
                    url('Helvetica.svg#Helvetica') format('svg');
                font-weight: 400;
                font-style: normal;
                font-display: swap;
            }

            @font-face {
                font-family: 'Helvetica';
                src: url('Helvetica-Bold.eot');
                src: url('Helvetica-Bold.eot?#iefix') format('embedded-opentype'),
                    url('Helvetica-Bold.woff2') format('woff2'),
                    url('Helvetica-Bold.woff') format('woff'),
                    url('Helvetica-Bold.ttf') format('truetype'),
                    url('Helvetica-Bold.svg#Helvetica-Bold') format('svg');
                font-weight: 700;
                font-style: normal;
                font-display: swap;
            }

            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .main-pdf{
                max-width: 720px;
                margin: 0 auto;
                padding: 30px 60px;
            }
            .pdf-header .top-head{
                display: block;
                height: 40px;
            }
            .pdf-header .top-head h2{
                font-size: 14px;
                font-weight: 700;
                font-family: 'Helvetica';
                display: inline-block;
                /*width: 50%;*/
                float: left;
            }
            .pdf-header .top-head figure{
                height: 40px;
                display: inline-block;
                width: 50%;
              /*  margin-right: auto;*/
              float: right;
                text-align: right;
            }
            .pdf-header .top-head figure img{
                max-width: 100%;
                height: 100%;
            }
            .pdf-header{
                margin-bottom: 15px;
            }
            .pdf-header h1{
                text-align: center;
                font-size: 18px;
                font-weight: 700;
                font-family: 'Tinos', serif;
            }
            table, td, tr, th{
                border: 1px solid #000;
                border-collapse: collapse;
            }

            table{
                width: 100%;
            }

            .table-1{
                margin-bottom: 40px;
            }
            table thead th{
                font-family: 'Tinos', serif;
                font-size: 9px;
                padding: 5px;
                background-color: #C0C0C0;
                font-weight: 700;
            }
            table tbody tr td{
                font-family: 'Tinos', serif;
                font-size: 9px;
                padding: 5px;
                font-weight: 400;
                vertical-align: top;
            }       
            table tbody tr td span{
                display: block;
                font-size: 10px;
                color: #0F9E0D;
            }
            .table-4 table tbody tr td span{
                max-width: 125px;
                display: inline-block;
            }
           
        </style>
    </head>

    <body>
        <div class="main-pdf">
            <div class="pdf-header">
                <div class="top-head">
                    <h2>Job Order ID: {{$ro->order_id}}</h2>
                    <figure>
                        <img src="{{ asset('admin/pdf/logo.png') }}" alt="">
                    </figure>
                </div>
                <h1>Job Sheet</h1>
            </div>
            <div class="table-4">
                <table>
                    <tbody>
                        <tr>
                            <td>RO:</td>
                            <td><span>{{$ro->order_id}}</span></td>
                            <td>ID:</td>
                            <td><span>{{$ro->owner}}</span></td>
                        </tr>
                        <tr>
                            <td>Delivery Date:</td>
                            <td><span>{{$jobsheets->delivery_date}}</span></td>
                            <td>Installation Date :</td>
                            <td><span>{{$jobsheets->installation_date}}</span></td>
                        </tr>
                        <tr>
                            @if($drivers)
                            @php $d_name=$drivers->name; @endphp
                            @else
                            @php $d_name=""; @endphp	
                            @endif	
                            <td>Driver :</td>
                            <td><span>{{$d_name}}</span></td>
                            @if($installers)
                            @php $i_name=$installers->name; @endphp
                            @else
                            @php $i_name=""; @endphp	
                            @endif
                            <td>Installer :</td>
                            <td><span>{{$i_name}}</span></td>
                        </tr>
                        <tr>
                            <td>C</td>
                            <td><span>{{$jobsheets->c}}</span></td>
                            <td>PL:</td>
                            <td><span>{{$jobsheets->pl}}</span></td>
                        </tr>
                        <tr>
                            <td>Postal Code/Address:</td>
                            <td><span>{{$ro->site_address}}</span></td>
                            <td>Description:</td>
                            <td><span>{{$jobsheets->description}}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
<script>
window.onload = function () {
window.print();
window.onafterprint = window.close;
}
</script>
    </body>

</html>
