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
                font-size: 10px;
                display: block;
                color: #0F9E0D;
            }
            .table-2{
                margin-bottom: 100px;
            }
            .table-2 table thead tr{
                border-bottom: none;
            }
            .table-2 table thead tr th{
                border-bottom: none;
            }
            .table-2 table tbody tr:first-child{
                border-top: none;
                text-align: center;
            }
            .table-2 table tbody tr:first-child td{
                border-top: none;
            }
            .table-2 table thead tr th:last-child{
                text-align: end;
                padding-right: 15px;
            }
            .table-2 table tbody tr td:last-child{
                padding-right: 15px;
                text-align: end;
            }
            .table-2 table tbody tr.noborder td:first-child{
                border-bottom-style: hidden;
                border-left-style: hidden;
            }
            table thead tr td em{
                text-transform: uppercase;
            }
            table tbody tr td p span{
                color: #000;
                text-transform: uppercase;
                margin-bottom: 5px;
                display: inline-block;
            }
            table tbody tr td p strong{
                margin-top: 10px;
                display: inline-block;
            }
            .company-hold {
                margin-top: 30px;
                display: block;
                width: 100%;
            }
            .company-hold .single-1 {
                display: inline-block;
                float: left;
            }
            .company-hold .single-1 .supreme-stamp {
                border-bottom: 1px solid;
                padding-top: 180px;
            }
            .company-hold .single-2 {
                display: inline-block;
                width: 200px;
                text-align: center;
                float: right;
            }
            .company-hold .single-2 .filler .stamp {
                border-bottom: 1px solid;
                padding-top: 90px;
            }
            .company-hold::after {
                content: "";
                clear: both;
                display: block;
            }
            .address-detail{
                margin-top: 30px;
            }
            .address-detail p:first-child{
                font-size: 9px;
                margin-bottom: 10px;
            }

            .address-detail p{
                font-size: 9px;
                margin-bottom: 3px;
            }
        </style>
    </head>

    <body>
        <div class="main-pdf">
            <div class="pdf-header">
                <div class="top-head">
                    <h2>Quotation ID: {{$quotation->quotation_id}}</h2>
                    <figure>
                    <img src="{{ asset('admin/pdf/logo.png') }}" alt="">
                    </figure>
                </div>
                <h1>Quotation</h1>
            </div>
            <div class="table-1">
                <table>
                    <tbody>
                        <tr>
                        @php 
                        $com = DB::table('suppliers')->select('company_name')->where('id',$quotation->company)->first();
                        @endphp
                        @if($com)
                        @php $comp_name= $com->company_name; @endphp
                        @else
                        @php $comp_name= ""; @endphp
                        @endif
                            <td>Company / Owner :</td>
                            <td><span>{{$comp_name}}</span></td>
                            <td>Date :</td>
                            <td><span>{{$quotation->due_date}}</span></td>
                        </tr>
                        <tr>
                            <td>Address :</td>
                            <td><span>{{$quotation->address}}</span></td>
                            <td>Installation Date :</td>
                            <td><span>-</span></td>
                        </tr>
                        <tr>
                        @php 
                        $sp = DB::table('users')->select('name')->where('id',$quotation->attention_to)->first();
                        @endphp
                        @if($sp)
                        @php $name= $sp->name; @endphp
                        @else
                        @php $name= ""; @endphp
                        @endif
                            <td>Attn :</td>
                            <td><span>{{$name}}</span></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="padding: 0;">
                                <table style="border: none;">
                                    <tbody><tr style="border: none;">
                                            <td style="width: 50%; padding: 0;
                                                border: none;"></td>
                                            <td style="padding: 0;border:
                                                none;">
                                                <span style="color:#000;
                                                    padding: 5px; display:
                                                    inline-block; border-right:
                                                    1px solid; border-left: 1px
                                                    solid;">Hp:</span>
                                                <span style="padding: 5px;
                                                    display: inline-block;">{{$quotation->phone}}</span>
                                            </td>
                                        </tr>
                                    </tbody></table>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Email :</td>
                            <td><span>{{$quotation->email}}</span></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-2">
                <table>
                    <thead>
                        <tr>
                            <th>Product/Job</th>
                            <th>QTY</th>
                            <th>Unit Price (S$)</th>
                            <th>Amount (S$)</th>
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
                            <td><span>${{$arr['price'][$i]}}</span></td>
                            <td><span>${{$arr['amount'][$i]}}</span></td>
                        </tr>
                      @endfor
                        <tr class="noborder">
                            <td colspan="2"></td>
                            <td><strong>Subtotal</strong></td>
                            <td><span>${{$quotation->subtotal}}</span></td>
                        </tr>
                        <tr class="noborder">
                            <td colspan="2"></td>
                            @php 
                            $gst = $quotation->subtotal*$quotation->gst/100;
                            @endphp
                            <td><strong>% GST</strong></td>
                            <td><span>${{$gst}}</span></td>
                        </tr>
                        <tr class="noborder">
                            <td colspan="2"></td>
                            @php 
                            $rebates = $quotation->subtotal*$quotation->rebates/100;
                            $total = $quotation->subtotal+$gst-$rebates;
                            @endphp
                            <td><strong>Total</strong></td>
                            <td><span>${{$total}}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-3">
                <table>
                    <tbody>
                        <tr>
                            <td><strong>Site Address:</strong></td>
                            <td><em>LK 141 TOA PAYOH LORONG 2 #23-160</em></td>
                        </tr>
                        <tr>
                            <td><strong>Payment Terms:</strong></td>
                            <td>
                                <p><span>50% UPON CONFIRMATION 50% UPON
                                        COMPLETION</span></p>
                                <p>Bank transfer account</p>
                                <p>UOB: 210-305-730-4</p>
                                <p>Paynow: 199902709HSF1</p>
                                <p>Cheque should be crossed & made payable to "
                                    Supreme Lion Holding Pte Ltd</p>
                                <p><strong>*Billing will based on final site
                                        measurement.</strong></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="company-hold">
                <div class="single-1">
                    <h6>SUPREME LION HOLDING PTE LTD</h6>
                    <div class="supreme-stamp"></div>
                </div>
                <div class="single-2">
                    <div class="filler">
                        <div class="stamp"></div>
                        <h6>Company stamp</h6>
                    </div>
                    <div class="filler">
                        <div class="stamp"></div>
                        <h6>Name & Signature</h6>
                    </div>
                </div>
            </div>
            <div class="address-detail">
                <p>*Kindly endorse and fax to us. Thank You.   </p>
                <p>Supreme Lion Holding Pte Ltd</p>
                <p>MEGA@WOODLANDS, 39, Woodlands Close, #03-48,49,50 , S737856</p>
                <p>Main Line : +65 90677987</p>
                <p>Website : www.supremefloors.com.sg</p>
            </div>

        </div>
        <script>
        window.onload = function () {
        window.print();
        window.onafterprint = window.close;
        }
        </script>
    </body></html>