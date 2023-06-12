@include("layouts.admin.header")
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow account">

            <div class="main-heading">
                <div class="main-titles">
                    <h1>
                        Sales Dashboard
                    </h1>
                    <p>
                        The segment shows the Sales transactions captured in Supreme Floor ERP. These numbers are accumulated weekly.
                    </p>
                </div>
                <div class="row row-cols-md-3 my-md-5">
                    <div class="col">
                        <div class="report d-flex justify-content-between">
                            <div class="report-type">
                                <h4>Quotation</h4>
                                <h2>${{number_format($quotation)}}</h2>
                                <!--a href="javascript:void(0)" class="btn">Report</a-->
                            </div>
                            <div class="graph">
                                <figure>
                                    <img src="{{asset('admin/images/chat-line.png')}}">
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="report d-flex justify-content-between">
                            <div class="report-type">
                                <h4>Invoice</h4>
                                <h2>${{number_format($invoices)}}</h2>
                                <!--a href="javascript:void(0)" class="btn">Report</a-->
                            </div>
                            <div class="graph">
                                <figure>
                                    <img src="{{asset('admin/images/chat-line.png')}}">
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="report d-flex justify-content-between">
                            <div class="report-type">
                                <h4>Payment Made</h4>
                                <h2>${{number_format($payment)}}</h2>
                                <!--a href="javascript:void(0)" class="btn">Report</a-->
                            </div>
                            <div class="graph">
                                <figure>
                                    <img src="{{asset('admin/images/chat-line.png')}}">
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--div class="week-sale">
                <div class="week-head d-flex justify-content-between align-items-start">
                    <div class="topic-txt">
                        <h2>This Week Sales</h2>
                    </div>
                    <ul>
                        <li>
                            <a href="javascript:void(0)" class="active"><i class="la la-calendar"></i></a>
                        </li>
                        <li><span class="green"></span>Past</li>
                        <li><span class="yellow"></span>Today</li>
                    </ul>
                </div>
                <div class="chat-data my-5">
                    <figure>
                        <img src="{{asset('admin/images/main-chat.jpg')}}">
                    </figure>
                </div>
            </div-->
            <div class="row Conversion">
                <div class="col">
                    <div class="complete-delivery">
                        <div class="cd-head">
                            <h4>Quotation Conversion</h4>
                        </div>
						
					<div id="piechart" style="width: 100%; height: 100%;"></div>
                        <!--div class="cd-data">
                            <div class="img-chat">
                                <figure>
                                    <img src="{{asset('admin/images/chat.png')}}">
                                </figure>
                                <p>62%</p>
                            </div>
                        </div>
                        <div class="row abt-data pb-md-4 pb-2">
                            <div class="col-auto">
                                <p><span style="background-color: #13582E;"></span> Quotation 25%</p>
                            </div>
                            <div class="col-auto">
                                <p><span style="background-color: #FFA02F;"></span> Invoice 25%</p>
                            </div>
                        </div-->
                    </div>
                </div>
                <div class="col">
                    <div class="complete-delivery">
                        <div class="cd-head">
                            <h4>Invoice Conversion</h4>
                        </div>
						<div id="inPieChart" style="width: 100%; height: 100%;"></div>
                        <!--div class="cd-data">
                            <div class="img-chat">
                                <figure>
                                    <img src="{{asset('admin/images/chat-2.png')}}">
                                </figure>
                                <p>50%</p>
                            </div>
                        </div>
                        <div class="row abt-data pb-md-4 pb-2">
                            <div class="col-auto">
                                <p><span style="background-color: #F32727;"></span> Pending 20%</p>
                            </div>
                            <div class="col-auto">
                                <p><span style="background-color: #FFA02F;"></span> Missed 30%</p>
                            </div>
                            <div class="col-auto">
                                <p><span style="background-color: #13582E;"></span> Paid 50%</p>
                            </div>
                        </div-->
                    </div>
                </div>
                <div class="col">
                    <div class="complete-delivery">
                        <div class="cd-head">
                            <h4>Invoice Conversion</h4>
                        </div>
                        <div class="cd-data">
                            <div class="week-invoice">
                                <h2>${{number_format($invoice_conversion)}}</h2>
                                <p>This week</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-lg-5">
                <div class="col-lg-8 mb-md-5 mb-lg-0">
                    <div class="Commission-tabel">
                        <div class="com-head d-flex justify-content-between">
                            <h4>Commission Breakdown</h4>
                            <!--a href="javascript:void(0)">view comission</a-->
                        </div>
                        <div class="sale-table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Earning</th>
                                        <th>Percentage</th>
                                        <th>Date of Payment</th>
                                        <th>Sale Amount</th>
                                        <th>Invoice No.</th>
                                    </tr>
                                </thead>
                                <tbody>
								@foreach($commission as $com)
								<?php 
								$date1 = new DateTime($com->created_at);
								$date2 = new DateTime($com->completed_at);
								$interval = $date1->diff($date2);
								if($interval->days<7){
								$percentage ="4";	
								}
								elseif($interval->days>=8 && $interval->days<=14){
								$percentage ="3.5";	
								}
								elseif($interval->days>=15 && $interval->days<=40){
								$percentage ="3";	
								}
								elseif($interval->days>=41 && $interval->days<=75){
								$percentage ="2";	
								}
								else{
								$percentage ="1";		
								}
								$earning = $com->total*$percentage/100;
								?>
                                    <tr>
                                        <td>
                                            +{{$earning}}
                                        </td>
                                        <td>
										{{$percentage}}%
                                        </td>
                                        <td>
										{{$com->completed_at}}
                                        </td>
                                        <td>
                                            ${{number_format($com->total)}}
                                        </td>
                                        <td>
										{{$com->invoice_id}}
                                        </td>
                                    </tr>
								@endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="Commission-tabel">
                        <div class="com-head text-center">
                            <h4>Latest On-going Installation</h4>
                        </div>
                        <div class="sale-table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Ro</th>
                                        <th>Installation Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
								@foreach($installation as $install)
								@php
								$ro= DB::table('release_orders')->select('order_id')->where('id',$install->ro_id)->first();
								@endphp
                                    <tr>
                                        <td>
										{{$ro->order_id}}
                                        </td>
                                        <td>
										{{$install->installation_date}}
                                        </td>
                                        <td>
                                            Installing
                                        </td>
                                    </tr>
								@endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-for my-lg-3 mt-4 mb-3">
                <h4>Pending Invoice</h4>
            </div>
            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Invoice No.</th>
                            <th>Due date</th>
                            <th>Sale Amount</th>
                            <th>Days Lapsed</th>
                            <th>Customer Name</th>
                            <th>Mobile Number</th>
                            <!--th>Bad Paymaster</th-->
                        </tr>
                    </thead>
                    <tbody>
					@foreach($invoice as $in)
                        <tr>
                            <td>
							{{$in->invoice_id}}
                            </td>
                            <td>
							{{$in->due_date}}
                            </td>
                            <td>
                                {{$in->total}}
                            </td>
                            <td>
                                4
                            </td>
                            <td>
							@php 
							$user = DB::table('users')->select('name')->where('id',$in->attention_to)->first();
							@endphp
							@if($user)
							@php $name = $user->name; @endphp
							@else
							@php $name = "";	 @endphp
							@endif
							{{$name}}
                            </td>
                            <td>
							{{$in->phone}}
                            </td>
                            <!--td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                    <!-- <label class="form-check-label" for="flexSwitchCheckDefault">dfs</label> -->
                                <!--/div>
                            </td-->
                        </tr>
					@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
 
        function drawChart() {
 
        var data = google.visualization.arrayToDataTable([
            ['Month Name', 'Registered User Count'],
 
                @php
                foreach($pieChart as $d) {
                    echo "['".$d->month_name."', ".$d->count."],";
                }
                @endphp
        ]);
		  var data1 = google.visualization.arrayToDataTable([
            ['Month Name', 'Registered User Count'],
			
                @php
                foreach($inpieChart as $d) {
                    echo "['".$d->month_name."', ".$d->count."],";
                }
                @endphp
        ]);
 
          var options = {
            is3D: false,
          };
 
          var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		  var chart1 = new google.visualization.PieChart(document.getElementById('inPieChart'));
 
          chart.draw(data, options);
          chart1.draw(data1, options);
        }
 

		
		
		
		
		
		
      </script>
@include("layouts.admin.footer")