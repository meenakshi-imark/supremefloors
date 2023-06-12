<style>
a.tb_btn{
background: #fff !important;
color: #000 !important;
border: 1px solid #13582E !important;		
}
a.tb_btn.selected{
background-color: #EBF9EB !important;
}
</style>
@include("layouts.admin.header")
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
                    <a href="javascript:void(0);" class="active">
                        <i class="la la-table"></i>
                        <span>Table</span>
                    </a>
                    <a href="/job-sheet-calendar" class="">
                        <i class="la la-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </div>
            </div>
                <ul class="assign-tabs">
                <li>
                    <a href="javascript:void(0);" id="assign"onclick="TabAssign();" data-rel="assigned" class="active">Assigned</a>
                </li>
                <li>
                    <a href="javascript:void(0);" id="notassign" onclick="TabAssignnot();"data-rel="not-assigned">Not Assigned</a>
                </li>
            </ul>
            <div class="filter">
				<form action="/jobsheet" method="GET">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-xl-5 me-3" placeholder="Search Jobsheet" name="search">
                        <button type="submit" class="btn me-xl-5">Search</button>
                    </div>
                    
                </div>
				</form>
            </div>
			<?php 
			if($_GET){
			if(isset($_GET['status'])){
			if($_GET['status']=="notassigned"){
			echo'<script>  
			$(document).ready(function () {
			$("#assigned").hide();
			$("#not-assigned").show();
			$("#assign").removeClass("active");
			$("#notassign").addClass("active");
			});
			</script>';
			}
			}
			
			if(isset($_GET['filter'])){
			if($_GET['filter']=="completed"){
				$completed = "selected";
			}
			elseif($_GET['filter']=="not-started"){
				$notstarted = "selected";
			}
			elseif($_GET['filter']=="postponed"){
				$postponed = "selected";
			}
			elseif($_GET['filter']=="installing"){
				$installing = "selected";
			}
			elseif($_GET['filter']=="delivered"){
				$delivered = "selected";
			}
			else{
				$completed = "";
				$notstarted = "";
				$postponed = "";
				$installing = "";
				$delivered = "";
			}
			}}
		
			?>
			<form method="POST" action="/delete-all-sheets">
			@csrf
			<div id="selectval1">
			<button type="submit" class="btn me-5 mb-2">Delete</button>
			</div>
            <div class="content-tabs">
			<div class="filter">
                <div class="tab-select">
                    <a href="@if(isset($completed)) /jobsheet @else jobsheet?filter=completed @endif" class="tb_btn @if(isset($completed)) selected @endif">Completed</a>
                    <a href="@if(isset($notstarted)) /jobsheet @else jobsheet?filter=not-started @endif" class="tb_btn @if(isset($notstarted)) selected @endif">Not Started</a>
                    <a href="@if(isset($postponed)) /jobsheet @else jobsheet?filter=postponed @endif" class="tb_btn @if(isset($postponed)) selected @endif">Postponed</a>
                    <a href="@if(isset($installing)) /jobsheet @else jobsheet?filter=installing @endif" class="tb_btn @if(isset($installing)) selected @endif">Installing</a>
                    <a href="@if(isset($delivered)) /jobsheet @else jobsheet?filter=delivered @endif" class="tb_btn @if(isset($delivered)) selected @endif">Delivered</a>
                </div>
            </div>
				@if(count($assigned)>0)
                <div class="all-tabel table-responsive" id="assigned">
                    <table>
                        <thead>
                            <tr>
                                <th>Select All </br>
								<input class="form-check-input" type="checkbox" id="ckbCheckAll" /></th>
                                <th>RO</th>
                                <th>Installation Date</th>
                                <th>Status</th>
                                <th>ID/Owner</th>
                                <th>Description</th>
                                <th>Address</th>
                                <th>View</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
						
							@foreach($assigned as $assign)
                            <tr>
                                <td>
                                <label class="form-check-label">
                                    <input class="form-check-input selectid" type="checkbox" name="id[]" value="{{$assign->id}}">
                                </label>
								</td>
                                </td>
                                <td>
								@php 
								$ro = DB::table('release_orders')->where('id',$assign->ro_id)->first();
								@endphp
                                    #{{$ro->order_id}}
                                </td>
                                <td>
								{{$assign->installation_date}}
                                </td>
                                <td>
								@if($assign->jobsheet_status=="1" || $assign->jobsheet_status=="5")
								@php $select ="text-success" @endphp
								@elseif($assign->jobsheet_status=="2")
								@php $select ="text-warning" @endphp
								@elseif($assign->jobsheet_status=="3")
								@php $select ="text-danger" @endphp
								@else
								@php $select ="text-info" @endphp
								@endif
                                    <select class="form-select {{$select}}" aria-label="Default select example" onchange="location = this.value;">
										<option value="">Select</option>
                                        <option value="/jobsheet_status/{{$assign->id}}/1" @if($assign->jobsheet_status=="1") selected @endif>Completed</option>
                                        <option value="/jobsheet_status/{{$assign->id}}/5" @if($assign->jobsheet_status=="5") selected @endif>Delivered</option>
                                        <option value="/jobsheet_status/{{$assign->id}}/2" @if($assign->jobsheet_status=="2") selected @endif>Not Started</option>
                                        <option value="/jobsheet_status/{{$assign->id}}/3" @if($assign->jobsheet_status=="3") selected @endif>Postponed</option>
                                        <option value="/jobsheet_status/{{$assign->id}}/4" @if($assign->jobsheet_status=="4") selected @endif>Installing</option>
                                    </select>
                                </td>
                                <td>
								{{$ro->owner}}
                                </td>
                                <td>
                                    {{$assign->description}}
                                </td>
                                <td>
                                    {{$ro->site_address}}
                                </td>
								<td>
								<a href="/job-sheet-details/{{$assign->id}}" class="text-success">
								  View Details
								</a>	
								</td>
                                <td>
                                    <div class="dropdown">
                                        <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                            <i class="la la-angle-down" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="/edit-jobsheet/{{$assign->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                            @if($assign->dispute_status=="1")
											<li><a class="dropdown-item" href="/approve-dispute/{{$assign->id}}/2"><i class="la la-check"></i>Approve</a></li>
											@endif
											<li><a class="dropdown-item popup" href="/print-jobsheet/{{$assign->id}}"><i class="las la-print" aria-hidden="true"></i>Print Jobsheet</a></li>	
											<li><a class="dropdown-item" href="/details-pdf/{{$assign->id}}?download=pdf"><i class="la la-download" aria-hidden="true"></i>Download as PDF</a></li>
											<li><a class="dropdown-item" href="/delete-jobsheet/{{$assign->id}}"><i class="la la-trash"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
							
							@endforeach
                            
                            
                            
                        </tbody>
                    </table>
                </div>
				@else
				<p>No result found.</p>
				@endif
                @if(count($job_not_assigned)>0)
                <div class="all-tabel table-responsive" id="not-assigned" style="display: none;">
                    <table>
                        <thead>
                            <tr>
                                <th>Select All </br>
								<input class="form-check-input" type="checkbox" id="ckbCheckAll1" /></th>
                                <th>RO</th>
                                <th>Installation Date</th>
                                <th>Assign Delivery</th>
                                <th>Assign Installation</th>
                                <th>Description</th>
                                <th>C</th>
                                <th>PL</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
						@foreach($job_not_assigned as $notassigned)
						
						@php 
						$ro = DB::table('release_orders')->where('id',$notassigned->ro_id)->first();
						@endphp
                            <tr>
                                <td>
                                    <label class="form-check-label">
                                         <input class="form-check-input selectid1" type="checkbox" name="idd[]" value="{{$notassigned->id}}">
                                    </label>
                                </td>
                                <td>
                                    #{{$ro->order_id}}
                                </td>
                                <td>
								@php 
								$date = strtok($ro->created_at, ' ');
								@endphp
								{{$date}}
                                </td>
                                <td>
                                    <input type="text" id="delivery{{$notassigned->id }}" class=" form-control delivery-class delivery" placeholder="Assign Delivery" data-id="{{$notassigned->id}}" value="{{$notassigned->delivery_date}}" onclick="DeliveryAssign({{ $notassigned->id }});">
                                </td>
                                <td>
                                    <input type="text" id="installation{{$notassigned->id }}" class="form-control delivery-class installation"  placeholder="Assign Installation" data-id="{{$notassigned->id}}" value="{{$notassigned->installation_date}}" onclick="NotAssign({{ $notassigned->id }});">
                                </td>
                                <td>
								{{$notassigned->description}}
                                </td>
                                <td>
                                    {{$notassigned->c}}
                                </td>
                                <td>{{$notassigned->pl}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                            <i class="la la-angle-down" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="/edit-jobsheet/{{$notassigned->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                            <li><a class="dropdown-item" href="/delete-jobsheet/{{$notassigned->id}}"><i class="la la-trash"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            
                        </tbody>
                    </table>
                </div>
				@else
				<p>No result found.</p>
				@endif
            </div>
			</form>
		
	 </div>
	</div>
</main>


</div>




<script src="{{asset('admin/js/bundle.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<script>
	// function PrintElem(elem)
	// 	{
	// 	var id = elem;
	// 	$.ajax({
    //           url: "/print-jobsheet",
    //           type: "GET",
    //           data: { id : id },
    //          success:function(data){
	// 		 $('#getp').html(data);
	// 		  Popup(data);
	// 		}
    //       });
		
	// 	}

    // function Popup(dataa)
	// {
    //     var mywindow = window.open('', 'new div', 'height=400,width=600');
    //     mywindow.document.write('<html><head><title>Quotation</title>');
    //     mywindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">');
    //     mywindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">');
    //     mywindow.document.write('<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">');
    //     mywindow.document.write('</head><body >');
    //     mywindow.document.write(dataa);
    //     mywindow.document.write('</body></html>');
    //     mywindow.print();
    //     mywindow.open();
    //     return true;
	// 	}	
 $('.popup').click(function (event) {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
});
$(document).ready(function () {
	
$("#ckbCheckAll").click(function () {
$(".selectid").prop('checked', $(this).prop('checked'));
});	
$("#ckbCheckAll1").click(function () {
$(".selectid1").prop('checked', $(this).prop('checked'));
});

});
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
			}
          });
	});
	}

function TabAssign(){
	$("#assigned").show();
	$("#not-assigned").hide();
	$("#notassign").removeClass("active");
	$("#assign").addClass("active");

}
function TabAssignnot(){
	$("#assigned").hide();
	$("#not-assigned").show();
	$("#assign").removeClass("active");
	$("#notassign").addClass("active");

}

  </script>
@include("layouts.admin.footer")
 
