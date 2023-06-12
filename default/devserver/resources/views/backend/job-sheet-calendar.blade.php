@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">
	    @if (\Session::has('success'))
        <div class="alert alert-success">
         {!! \Session::get('success') !!}
        </div>
		@endif
        <div class="box-shadow account">

            <div class="main-heading d-flex justify-content-between">
                <div class="main-titles">
                    <h1>
                        Job Sheet
                    </h1>
                    <p>
                        The segment shows the ongoing job sheet of Supreme Floor ERP.
                    </p>
                </div>
                <div class="tabs-change">
                    <a href="/create-jobsheet-create" class="btn">+ Create Job Sheet</a>
                    <a href="{{url('jobsheet')}}">
                        <i class="la la-table"></i>
                        <span>Table</span>
                    </a>
                    <a href="javascript:void(0);" class="active">
                        <i class="la la-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </div>
            </div>
            <ul class="assign-tabs">
                <li>
                    <a href="javascript:void(0);" data-rel="assigned" class="active">Assigned</a>
                </li>
                <li>
                    <a href="javascript:void(0);" data-rel="not-assigned">Not Assigned</a>
                </li>
            </ul>
            <div class="filter">
				<form action="/job-sheet-calendar" method="GET">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-xl-5 me-3" name="search"placeholder="Search Record">
                        <button type="submit" class="btn me-xl-5">Search</button>
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
                            <a href="javascript:void(o);" class="me-3"><i class="fa fa-angle-left" aria-hidden="true" onClick="assigned_previous_date({{$monthnew}})"></i></a>
                            <h5><? echo date('M Y'); ?></h5>
                            <a href="javascript:void(o);" class="ms-3"><i class="fa fa-angle-right" aria-hidden="true" onClick="assigned_next_date({{$monthnew}})"></i></a>
                        </div>
                        <div class="assign-cla-data row row-cols-xxl-5 row-cols-xl-4 row-cols-md-3">
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
								@foreach($assigned as $assign)
								@php
								$date1  =  strstr($assign->created_at, ' ', true);
								$adate  =  strtotime($date1);
								$ro = DB::table('release_orders')->where('id',$assign->ro_id)->first();
								
								@endphp
								
								   @if($adate==$timestamp)
                                    <li>
                                        <div class="date-order">
                                            <table>
                                                <tr>
                                                    <th>RO</th>
                                                    <td>#{{$ro->order_id}}</td>
                                                    <th>{{$assign->jobsheet_id}}</th>
                                                </tr>
                                                <tr>
                                                    <th>ID</th>
                                                    <td>{{$ro->owner}}</td>
                                                    <th></th>
                                                </tr>
                                            </table>
											@if($assign->jobsheet_status=="1" || $assign->jobsheet_status=="5")
											@php $select ="text-success" @endphp
											@elseif($assign->jobsheet_status=="2")
											@php $select ="text-warning" @endphp
											@elseif($assign->jobsheet_status=="3")
											@php $select ="text-danger" @endphp
											@else
											@php $select ="text-info" @endphp
											@endif
                                            <p><a href="#sheet-detail" role="button" aria-controls="offcanvasExample" data-bs-toggle="offcanvas">{{$assign->description}}</a></p>
                                            <select class="form-select {{$select}}" aria-label="Default select example" onchange="location = this.value;">
											<option value="">Select</option>
											<option value="/jobsheet_status/{{$assign->id}}/1" @if($assign->jobsheet_status=="1") selected @endif>Completed</option>
											<option value="/jobsheet_status/{{$assign->id}}/5" @if($assign->jobsheet_status=="5") selected @endif>Delivered</option>
											<option value="/jobsheet_status/{{$assign->id}}/2" @if($assign->jobsheet_status=="2") selected @endif>Not Started</option>
											<option value="/jobsheet_status/{{$assign->id}}/3" @if($assign->jobsheet_status=="3") selected @endif>Postponed</option>
											<option value="/jobsheet_status/{{$assign->id}}/4" @if($assign->jobsheet_status=="4") selected @endif>Installing</option>
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

                <div class="all-tabel table-responsive" id="not-assigned" style="display: none;">
                    <div class="not-assign-cal">
                        <div class="assign-cal">
                            <div class="cal-month">
                                <a href="javascript:void(o);" class="me-3"><i class="fa fa-angle-left" aria-hidden="true" onClick="not_previous_date({{$monthnew}})"></i></a>
                                <h5><? echo date('M Y'); ?></h5>
                                <a href="javascript:void(o);" class="ms-3"><i class="fa fa-angle-right" aria-hidden="true" onClick="not_next_date({{$monthnew}})"></i></a>
                            </div>
                            <div class="assign-cla-data row row-cols-xxl-5 row-cols-xl-4 row-cols-md-3">
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
									@foreach($job_not_assigned as $not_assigned)
									@php
									$date1  =  strstr($not_assigned->created_at, ' ', true);
									$adate  =  strtotime($date1);
									$ro = DB::table('release_orders')->where('id',$not_assigned->ro_id)->first();
									@endphp
										@if($adate==$timestamp)
                                        <li>
                                            <div class="date-order">
                                                <table>
                                                    <tr>
                                                        <th>RO</th>
                                                        <td>#{{$ro->order_id}}</td>
                                                        <th>{{$not_assigned->jobsheet_id}}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>ID</th>
                                                        <td>{{$ro->owner}}</td>
                                                        <th></th>
                                                    </tr>
                                                </table>
                                                <p><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#not-assign-select">{{$not_assigned->description}}</a></p>
                                                <div class="form-group">
                                                    <label>Assign Delivery</label>
                                                    <input type="text" id="delivery{{$not_assigned->id }}" class="delivery-class delivery" placeholder="Assign Delivery" data-id="{{$not_assigned->id}}" value="{{$not_assigned->delivery_date}}" onclick="DeliveryAssign({{ $not_assigned->id }});">
													
													
                                                </div>
                                                <div class="form-group">
                                                    <label>Assign Installation</label>
                                                    <input type="text" id="installation{{$not_assigned->id }}" class="delivery-class installation" placeholder="Assign Installation" data-id="{{$not_assigned->id}}" value="{{$not_assigned->installation_date}}" onclick="NotAssign({{ $not_assigned->id }});">
                                                </div>
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
                </div>

                <!-- sheet-detail -->

                <div class="offcanvas offcanvas-end sheet-detail" tabindex="-1" id="sheet-detail" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Job Sheet Details</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="row row-cols-3">
                            <div class="col">
                                <p><b>RO: </b> 000294</p>
                            </div>
                            <div class="col">
                                <p><b>ID </b> AMD3D</p>
                            </div>
                            <div class="col">
                                <p><b>Post Code </b> 530243</p>
                            </div>
                        </div>
                        <div class="row row-cols-3 mt-4 mb-3">
                            <div class="col">
                                <p><b>Delivery Date:</b></p>
                            </div>
                            <div class="col">
                                <p>30-05-2022</p>
                            </div>
                        </div>
                        <div class="row row-cols-3 my-3">
                            <div class="col">
                                <p><b>Driver</b></p>
                            </div>
                            <div class="col">
                                <p>Driver 1</p>
                            </div>
                        </div>
                        <div class="row row-cols-3 mt-5 mb-3">
                            <div class="col">
                                <p><b>Installation Date:</b></p>
                            </div>
                            <div class="col">
                                <p>30-05-2022, 08-06-2022</p>
                            </div>
                        </div>
                        <div class="row row-cols-3 mb-5">
                            <div class="col">
                                <p><b>Installer</b></p>
                            </div>
                            <div class="col">
                                <p>Installer 1</p>
                            </div>
                        </div>
                        <div class="desc">
                            <strong>Description:</strong>
                            <p class="my-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusant doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                        </div>
                        <div class="row row-cols-3 my-5">
                            <div class="col">
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>SM</b></p>
                                    </div>
                                    <div class="col">
                                        <p>000294</p>
                                    </div>
                                </div>
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>C</b></p>
                                    </div>
                                    <div class="col">
                                        <p>000294</p>
                                    </div>
                                </div>
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>D</b></p>
                                    </div>
                                    <div class="col">
                                        <p>000294</p>
                                    </div>
                                </div>
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>Furniture</b></p>
                                    </div>
                                    <div class="col">
                                        <p>000294</p>
                                    </div>
                                </div>
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>PL</b></p>
                                    </div>
                                    <div class="col">
                                        <p>000294</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>SM</b></p>
                                    </div>
                                    <div class="col">
                                        <p>000294</p>
                                    </div>
                                </div>
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>C</b></p>
                                    </div>
                                    <div class="col">
                                        <p>000294</p>
                                    </div>
                                </div>
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>D</b></p>
                                    </div>
                                    <div class="col">
                                        <p>000294</p>
                                    </div>
                                </div>
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>Furniture</b></p>
                                    </div>
                                    <div class="col">
                                        <p>000294</p>
                                    </div>
                                </div>
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>PL</b></p>
                                    </div>
                                    <div class="col">
                                        <p>000294</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="action-links">
                            <p><b>Actions</b></p>
                            <ul class="mt-3">
                                <li class="my-4">
                                    <a href="javascript:void(0);" class=""><span>Edit</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="my-4">
                                    <a href="javascript:void(0);" class=""><span>Send Reminders Driver & Installer</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="my-4">
                                    <a href="javascript:void(0);" class=""><span>Send Customer an Email Reminder</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="my-4">
                                    <a href="javascript:void(0);" class=""><span>Create Invoice</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="my-4">
                                    <a href="javascript:void(0);" class=""><span>Download as PDF</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="my-4">
                                    <a href="javascript:void(0);" class=""><span>Delete</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
<script src="{{asset('admin/js/bundle.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function assigned_next_date(id){
var date = new Date();
var yr      = date.getFullYear();
var month   = id;
var day     = date.getDate();
newDate = yr + '-' + month + '-' + day;

    $.ajax({
              url: "/assigned-next-date",
              type: "GET",
              data: { date : newDate },
             success:function(data){
			 $('#assigned').html(data);
			}
          });
}

function assigned_previous_date(id){
var date = new Date();
var yr      = date.getFullYear();
var month   = id;
var day     = date.getDate();
newDate = yr + '-' + month + '-' + day;

    $.ajax({
              url: "/assigned-previous-date",
              type: "GET",
              data: { date : newDate },
             success:function(data){
			 $('#assigned').html(data);
			}
          });
} 

function not_next_date(id){
var date = new Date();
var yr      = date.getFullYear();
var month   = id;
var day     = date.getDate();
newDate = yr + '-' + month + '-' + day;

    $.ajax({
              url: "/not-next-date",
              type: "GET",
              data: { date : newDate },
             success:function(data){
			 $('#not-assigned').html(data);
			}
          });
}

function not_previous_date(id){
var date = new Date();
var yr      = date.getFullYear();
var month   = id;
var day     = date.getDate();
newDate = yr + '-' + month + '-' + day;

    $.ajax({
              url: "/not-previous-date",
              type: "GET",
              data: { date : newDate },
             success:function(data){
			 $('#not-assigned').html(data);
			}
          });
} 

  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
	});
$( ".delivery" ).datepicker({ dateFormat: 'yy-mm-dd' });
	function DeliveryAssign(id){
	$("#delivery"+id).on("change",function(){
	var val = $(this).val();
	var id = $(this).attr("data-id");
	$.ajax({
            url: "/assign-delivery",
            type: 'POST',
            data: { val : val, id :id },
			success:function(data){
			 Swal.fire('Delivery Date assigned successfully.');
			 setTimeout(function(){
			 location.reload();
			 },1000);  
			}
          });
	});
}
	
$(".installation" ).datepicker({ dateFormat: 'yy-mm-dd' });
	function NotAssign(id){
	$("#installation"+id).on("change",function(){
	var val = $(this).val();
	var id = $(this).attr("data-id");
	  $.ajax({
            url: "/assign-installation",
            type: 'POST',
            data: { val : val, id :id },
			success:function(data){
			 Swal.fire('Installation Date assigned successfully.');
			 setTimeout(function(){
			 location.reload();
			 },1000);  
			}
          });
	});
	}

  </script>
@include("layouts.admin.footer")