@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow account">

            <div class="main-heading d-flex justify-content-between">
                <div class="main-titles">
                    <h1>
                        Delivery Order
                    </h1>
                    <p>
                        The segment shows the ongoing Delivery Orders of Supreme Floor ERP.
                    </p>
                </div>
                <div class="tabs-change">
					@if(auth()->user()->role_id=="1")
                    <a href="/create-jobsheet-create" class="btn">+ Create Delivery Order</a>
					@endif
                    <a href="{{url('delivery-order-table')}}">
                        <i class="la la-table"></i>
                        <span>Table</span>
                    </a>
                    <a href="javascript:void(0);" class="active">
                        <i class="la la-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </div>
            </div>
            <div class="filter">
			<form action="/delivery-order-calendar" method="GET">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-5" placeholder="Search Order" name="search" required>
                        <button type="submit" class="btn me-5">Search</button>
                    </div>
                </div>
				</form>
            </div>
			@php
			$month_end = strtotime('last day of this month', time());
			$lastdate = date('D, j', $month_end);
			$last = date('j', $month_end);
            $new_date = date('Y-m-d');
            $monthnew = date('m', strtotime($new_date));
			@endphp
            <div class="content-tabs calender">

                <div class="all-tabel table-responsive" id="assigned">
                    <div class="assign-cal">
                        <div class="cal-month">
                            <a href="javascript:void(o);" class="me-3"><i class="fa fa-angle-left" aria-hidden="true" onClick="previous_date({{$monthnew}})"></i></a>
                            <h5><? echo date('M Y'); ?></h5>
                            <a href="javascript:void(o);" class="ms-3"><i class="fa fa-angle-right" aria-hidden="true" onClick="next_date({{$monthnew}})"></i></a>
                        </div>
                        <div class="assign-cla-data row row-cols-5">
							@for($i=1;$i<=$last;$i++)
							@php
							$date = date("Y").'-'.date('m').'-'.$i;
							$timestamp = strtotime($date);
							$day = date('D', $timestamp);
							$currentdate =  date('Y-m-d');
							$current = strtotime($currentdate);
							@endphp
							@if($current==$timestamp)
							@php $class="today"; @endphp
							@else
							@php $class=""; @endphp
							@endif
                             <div class="dates {{$class}}">
                                 <p>{{$day}}<br>{{$i}}</p>
                                <ul>
								
								@foreach($delivery as $del)
								@php
								$date1  =  strstr($del->created_at, ' ', true);
								$adate  =  strtotime($del->delivery_date);
								$ro = DB::table('release_orders')->where('id',$del->ro_id)->first();
								
								@endphp
								
								  @if($adate==$timestamp)
                                    <li>
                                        <div class="date-order">
                                            <table>
                                                <tr>
                                                    <th>RO</th>
                                                    <td>#{{$ro->order_id}}</td>
                                                    <th>{{$del->jobsheet_id}}</th>
                                                </tr>
													<tr>
													<th></th>
                                                    <td>
													@php 
													$driver = DB::table('users')->select('name')->where('id',$del->driver)->first();
													@endphp
													
													<a href="#job-detail" class="details" data-id="{{$del->id}}" role="button" aria-controls="offcanvasExample" data-bs-toggle="offcanvas">{{$driver->name}}</a></td>
                                                    <th></th>
                                                </tr>
                                            </table>
											@if($del->delivery_status=="1")
											@php $select ="text-success" @endphp
											@elseif($del->delivery_status=="2")
											@php $select ="text-warning" @endphp
											@elseif($del->delivery_status=="3")
											@php $select ="text-danger" @endphp
											@else
											@php $select ="text-info" @endphp
											@endif
                                            <select class="form-select {{$select}}" aria-label="Default select example" onchange="location = this.value;">
                                                <option value="/delivery_status/{{$del->id}}/2" {{ $del->delivery_status == '2' ? 'selected' : '' }}>Pending</option>
                                                <option value="/delivery_status/{{$del->id}}/4" {{ $del->delivery_status == '4' ? 'selected' : '' }}>Picked Up</option>
                                                <option value="/delivery_status/{{$del->id}}/1"{{ $del->delivery_status == '1' ? 'selected' : '' }}>Delivered</option>
                                                <option value="/delivery_status/{{$del->id}}/3" {{ $del->delivery_status == '3' ? 'selected' : '' }}>Missed</option>
                                            </select>
                                        </div>
                                    </li>
								   @endif
                                   @endforeach
                                    
                                </ul>
                            </div>
							@endfor
                            
                            
                           
                            
                        </div>
                    </div>
                </div>

                <!-- sheet -->
				<form method="POST" action="/delivery-update" enctype="multipart/form-data">  
					@csrf
                <div class="offcanvas offcanvas-end sheet-detail" tabindex="-1" id="job-detail" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Delivery Job Details</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body" id="getdetails">
                        
                    </div>
                </div>
				</form>

            </div>
        </div>
    </div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
function next_date(id){
var date = new Date();
var yr      = date.getFullYear();
var month   = id;
var day     = date.getDate();
newDate = yr + '-' + month + '-' + day;

    $.ajax({
              url: "/del-next-date",
              type: "GET",
              data: { date : newDate },
             success:function(data){
			 $('.assign-cal').html(data);
			}
          });
}

function previous_date(id){
var date = new Date();
var yr      = date.getFullYear();
var month   = id;
var day     = date.getDate();
newDate = yr + '-' + month + '-' + day;

    $.ajax({
              url: "/del-previous-date",
              type: "GET",
              data: { date : newDate },
             success:function(data){
			 $('.assign-cal').html(data);
			}
          });
}   
$('.details').click(function(){
var id= $(this).attr("data-id");
	 $.ajax({
              url: "/delivery-details",
              type: "GET",
              data: { id : id },
             success:function(data){
			 $('#getdetails').html(data);
			}
          });
	
});
</script>
@include("layouts.admin.footer")