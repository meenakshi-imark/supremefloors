@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">
		 @if (\Session::has('success'))
        <div class="alert alert-success">
            {!! \Session::get('success') !!}
        </div>
		@endif
		 @if (\Session::has('error'))
        <div class="alert alert-danger">
            {!! \Session::get('error') !!}
        </div>
		@endif
		 
				
        <div class="box-shadow account">

            <div class="main-heading">
			<div class="row">
			<div class="col-md-9">
                <h1>
                    Commisson
                </h1>
                <p>
                    This segment shows the history of commission.
                </p>
            </div>
            </div>
            </div>
            <div class="filter">
               <form action="/commission" method="GET">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
					 <i class="la la-search"></i>
                        <input type="text" class="form-control me-xl-5 me-3" name="search" placeholder="Search Commission" required>
                        <button type="submit" class="btn me-xl-5">Search</button>
						
                 </div>
                 </div>
			  </form> 
            </div>
			@if(count($commission)>0)
			<form method="POST" action="/delete-all-commission"> 
			<div id="selectval1">
			<button type="submit" class="btn me-5 mb-2">Delete</button>
			</div>
			@csrf
            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Select All</br>
							<input  class="form-check-input" type="checkbox" id="ckbCheckAll" /></th>
                            <th>Date</th>
                            <th>RO/JS</th>
                            <th>Billed Item</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
					@foreach($commission as $com)
                        <tr>
                            <td>
                                <label class="form-check-label">
                                     <input class="form-check-input selectid" type="checkbox" name="id[]" value="{{$com->id}}">
                                </label>
                            </td>
                            <td>
                                {{$com->completed_at}}
                            </td>
                            <td>{{$com->invoice_id}}
                            </td>
                            <td>	<a href="#job-detail" class="details" data-id="{{$com->id}}" role="button" aria-controls="offcanvasExample" data-bs-toggle="offcanvas">View</a></td>
                            </td>
                            <td>
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
								{{$earning}}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/delete-commission/{{$com->id}}"><i class="la la-trash"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
						@endforeach
						
						
                    </tbody>
                </table>
				{!! $commission->render() !!}
            </div>
			</form>
			 @else
            <p>No result found.</p>
            @endif
            
                            <!-- sheet -->
                <div class="offcanvas offcanvas-end sheet-detail" tabindex="-1" id="job-detail" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Billed items</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body" id="getdetails">
                        
                    </div>
                </div>
            
        </div>
    </div>
</main>
<style>
#job-detail {
    z-index: 99999;
    max-width: 700px;
    width: 100%;
    padding: 50px 50px 0px;
}   
    
</style>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	$(document).ready(function () {
		$("#ckbCheckAll").click(function () {
			$(".selectid").prop('checked', $(this).prop('checked'));
		});
	});
	
	$('.details').click(function(){
    var id= $(this).attr("data-id");
	 $.ajax({
              url: "/commission-details",
              type: "GET",
              data: { id : id },
             success:function(data){
			 $('#getdetails').html(data);
			}
          });
	
});
	</script>
@include("layouts.admin.footer")