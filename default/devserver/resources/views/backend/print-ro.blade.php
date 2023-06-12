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
            
            .table-5 table , .table-5 table tr, .table-5 table td{
                border: none;
            } 
            
            .table-5{
                 padding: 15px 0;
                 border-bottom: 1px solid #00000033;
            }

            .table-5 table tr td .tym-date{
                display: flex;
            }
            .table-5 table tr td .tym-date p:not(:last-child){
                margin-right: 15px;
            }
            .items{
                padding: 15px 0;
            }
            .items h3{
                font-size: 12px;
                font-weight: 700;
                font-family: 'Tinos', serif;
            }
            .items-table table thead tr th{
                background-color: transparent;
                text-align: start;
            }
            .items-table table tbody tr td{
                text-align: start;
            }
            .items-table table:not(:last-child) {
                margin-bottom: 20px;
            }
           
        </style>
    </head>

    <body>
        <div class="main-pdf">
            <div class="pdf-header">
                <div class="top-head">
                    <h2>Release Order ID: {{$orders->order_id}}</h2>
                    <figure>
                    <img src="{{ asset('admin/pdf/logo.png') }}" alt="">
                    </figure>
                </div>
                <h1>Release Order</h1>
            </div>
            <div class="table-5">
                <table>
                    <tbody>
                        <tr>
                            <td>
                             @php
                              $sp = DB::table('users')->select('name')->where('id',$orders->owner)->first();
                              @endphp
                              @if($sp)
                              @php $spname = $sp->name; @endphp
                              @else
                              @php $spname = "-"; @endphp
                              @endif
                                <p>Sales Person:<span> {{$spname}}</span></p>
                            </td>
                            <td>
                                <div class="tym-date">
                                  <?php 
                                  $date = $orders->created_at;
                                  $str=substr($date, 0, strrpos($date, ' '));
                                  ?>
                                    <p>Date :<span> {{$str}}</span></p>
                                    <p>Est Installn:<span> {{$orders->estimate_date}}</span></p>
                                </div>
                            </td>
                            <td>
                                <p>Key:<span> {{$orders->ro_key}}</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            @php 
                            $com = DB::table('suppliers')->select('company_name')->where('id',$orders->company_id)->first();
                            @endphp
                            @if($com)
                            @php $comp_name= $com->company_name; @endphp
                            @else
                            @php $comp_name= ""; @endphp
                            @endif
                                <p>Company:<span> {{$comp_name}}</span></p>
                            </td>
                            <td>
                           
                                <p>Sales Agent/Owner:<span> {{$spname}}</span></p>
                            </td>
                            <td>
                                <p>HP:<span> {{$orders->phone_number}}</span></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-5">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <p>Site Address:<span> {{$orders->site_address}}</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Area to Install:<span> {{$orders->area}}</span></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <p>Floor Size:<span> {{$orders->floor_size}} SQF</span></p>
                            </td>
                            <td>
                                <p>Lift Level:<span> {{$orders->lift_level}}</span></p>
                            </td>
                            <td>
                                <div class="tym-date" style="justify-content:
                                    center">
                                    <p>H/S:<span>{{$orders->hs}}</span></p>
                                    <p>C/D:<span>{{$orders->cs}}</span></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="items">
                <h3>Items</h3>
            </div>
            <div class="items-table">
                <table style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>No. of Pkts</th>
                            <th>Return</th>
                        </tr>
                    
                    </thead>
                    <tbody>
                    @for($i=0;$i<count($arr['products']);$i++)
                        <tr>
                        @php 
                        $products = DB::table('products')->where('id',$arr['products'][$i])->get();
                        @endphp
                            <td><span>{{$products[0]->product_name}}</span></td>
                            <td><span>{{$arr['quantity'][$i]}}</span></td>
                            <td><span>-</span></td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            
                <table style="table-layout: fixed; margin-top:15px;">
                    <thead>
                        <tr>
                            <th>Skirting</th>
                            <th>No. of Pkts</th>
                            <th>Return</th>
                        </tr>
                    </thead>
                    <tbody>
                    @for($i=0;$i<count($arr['skirting']);$i++)
                    <?php 
                    if($arr['skirting'][$i]){
                      $skirting  = $arr['skirting'][$i];
                    }
                    else{
                       $skirting ="-";
                    }
                    if($arr['skirtingqty'][$i]){
                        $skirtingqty  = $arr['skirtingqty'][$i];
                      }
                      else{
                         $skirtingqty ="-";
                      }
                    ?>
                        <tr>
                            <td><span>{{$skirting}}</span></td>
                            <td><span>{{$skirtingqty}}</span></td>
                            <td><span>-</span></td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
                    
                     
                <table style="table-layout: fixed; margin-top:15px;">
                    <thead>
                        <tr>
                            <th>Accessories</th>
                            <th>Colour</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if($orders->end=="yes")
                      @php $end_color = $orders->end_color; 
                      $end_qty = $orders->end_qty;
                      @endphp
                      @else
                      @php $end_color = '-'; 
                      $end_qty = '-'; 
                      @endphp
                      @endif 

                        <tr>
                            <td><span>End</span></td>
                            <td><span>{{$end_color}}</span></td>
                            <td><span>{{$end_qty}}</span></td>
                        </tr>

                        @if($orders->contact=="yes")
                        @php $contact_color = $orders->contact_color; 
                        $contact_qty = $orders->contact_qty;
                        @endphp
                        @else
                        @php $contact_color = '-'; 
                        $contact_qty = '-'; 
                        @endphp
                        @endif
                        <tr>
                            <td><span>Contact</span></td>
                            <td><span>{{$contact_color}}</span></td>
                            <td><span>{{$contact_qty}}</span></td>
                        </tr>
                        @if($orders->adaptor=="yes")
                        @php $adaptor_color = $orders->adaptor_color; 
                        $adaptor_qty = $orders->adaptor_qty;
                        @endphp
                        @else
                        @php $adaptor_color = '-'; 
                        $adaptor_qty = '-'; 
                        @endphp
                        @endif
                        <tr>
                            <td><span>Adaptor</span></td>
                            <td><span>{{$adaptor_color}}</span></td>
                            <td><span>{{$adaptor_qty}}</span></td>
                        </tr>
                        @if($orders->lcapping=="yes")
                        @php $lcapping_color = $orders->lcapping_color; 
                        $lcapping_qty = $orders->lcapping_qty;
                        @endphp
                        @else
                        @php $lcapping_color = '-'; 
                        $lcapping_qty = '-'; 
                        @endphp
                        @endif
                        
                        <tr>
                            <td><span>L-Capping</span></td>
                            <td><span>{{$lcapping_color}}</span></td>
                            <td><span>{{$lcapping_qty}}</span></td>
                        </tr>
                    </tbody>
                </table>
                <table style="table-layout: fixed; margin-top:15px;">
                    <thead>
                        <tr>
                            <th>Miscellaneous</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($orders->plywood=="yes")
                        @php $plywood_qty = $orders->plywood_qty; 
                        @endphp
                        @else
                        @php $plywood_qty = '-'; 
                        @endphp
                        @endif
                        <tr>
                            <td><span>Plywood (5+1)</span></td>
                            <td><span>{{$plywood_qty}}</span></td>
                        </tr>
                        <tr>
                            <td><span>Corrugated Paper</span></td>
                            @if($orders->corrugated_qty=="0")
                            @php
                            $corrugated_qty ="-";
                            @endphp
                            @else
                            @php
                            $corrugated_qty =$orders->corrugated_qty;
                            @endphp
                            @endif
                            <td><span>{{$corrugated_qty}}</span></td>
                        </tr>
                        <tr>
                            <td><span>Plastic</span></td>
                            @if($orders->pastic_qty=="0")
                            @php
                            $pastic_qty ="-";
                            @endphp
                            @else
                            @php
                            $pastic_qty =$orders->pastic_qty;
                            @endphp
                            @endif
                            <td><span>{{$pastic_qty}}</span></td>
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