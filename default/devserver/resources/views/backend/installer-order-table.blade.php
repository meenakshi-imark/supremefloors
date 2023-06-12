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

            <div class="main-heading d-flex justify-content-between">
                <div class="main-titles">
                    <h1>
                    Installer Order
                    </h1>
                    <p>
                    The segment shows the ongoing installer Orders of Supreme Floor ERP.
                    </p>
                </div>
                <div class="tabs-change">
					@if(auth()->user()->role_id=="1")
                    <a href="/create-jobsheet-create" class="btn">+ Create Installer Order</a>
					@endif
                    <a href="javascript:void(0);" class="active">
                        <i class="la la-table"></i>
                        <span>Table</span>
                    </a>
                    <a href="{{url('installer-order-calendar')}}" class="">
                        <i class="la la-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </div>
            </div>
			<form action="/installer-order-table" method="GET">
            <div class="filter">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-5" placeholder="Search Order" name="search">
                        <button type="submit" class="btn me-5">Search</button>
                    </div>
                    <!--a href="javascript:void(0);" class="btn">
                        <i class="la la-filter"></i>
                        Filter
                    </a-->
                </div>
            </div>
			</form>
			
			@if(count($installer)>0)
            <div class="content-tabs calender">
			<form method="POST" action="/delete-all-installers">
			@csrf
			<div id="selectval1">
			<button type="submit" class="btn me-5 mb-2">Delete</button>
			</div>
                <div class="all-tabel table-responsive" id="assigned">
                    <table>
                        <thead>
                            <tr>
                                <th>Select All <br>
								<input class="form-check-input" type="checkbox" id="ckbCheckAll" /></th>
                                <th>RO</th>
                                <th>Installation Date</th>
                                <th>Status</th>
                                <th>installer</th>
                                <th>Address</th>
                                <th>View</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
						@foreach($installer as $install)
                            <tr>
                                <td>
                                    <label class="form-check-label">
                                         <input class="form-check-input selectid" name="id[]"type="checkbox" value="{{$install->id}}">
                                    </label>
                                </td>
                                <td>
								@php 
								$ro = DB::table('release_orders')->select('order_id','site_address')->where('id',$install->ro_id)->first();
								@endphp
                                    #{{$ro->order_id}}
                                </td>
                                <td>
								{{$install->installation_date}}
                                </td>
                                <td>
								@if($install->installation_status=="3")
								@php $select ="text-success" @endphp
								@elseif($install->installation_status=="2")
								@php $select ="text-warning" @endphp
								@elseif($install->installation_status=="4")
								@php $select ="text-danger" @endphp
								@else
								@php $select ="text-info" @endphp
								@endif
                                    <select class="form-select {{$select}}" aria-label="Default select example" onchange="location = this.value;">
                                        <option value="/installation_status/{{$install->id}}/2" {{ $install->installation_status == '2' ? 'selected' : '' }}>Not Started</option>
                                        <option value="/installation_status/{{$install->id}}/1" {{ $install->installation_status == '1' ? 'selected' : '' }}>Installing</option>
                                        <option value="/installation_status/{{$install->id}}/3" {{ $install->installation_status == '3' ? 'selected' : '' }}>Completed</option>
                                        <option value="/installation_status/{{$install->id}}/4" {{ $install->installation_status == '4' ? 'selected' : '' }}>Postponed</option>
                                    </select>
                                </td>
                                <td>
                                @php 
								$installername = DB::table('users')->select('name')->where('id',$install->installer)->first();
								@endphp
								{{$installername->name}}
                                </td>
                                <td>
								{{$ro->site_address}}
                                </td>
								<td><a href="#job-detail" class="details" data-id="{{$install->id}}" role="button" aria-controls="offcanvasExample" data-bs-toggle="offcanvas">
									View Details</a></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                            <i class="la la-angle-down" aria-hidden="true"></i>
											</button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="/edit-jobsheet/{{$install->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
											<li><a class="dropdown-item popup" href="/print-installer-order/{{$install->id}}" ><i class="las la-print" aria-hidden="true"></i>Print Installer Order</a></li>	
											<li><a class="dropdown-item" href="/installer-pdf/{{$install->id}}?download=pdf"><i class="la la-download" aria-hidden="true"></i>Download as PDF</a></li>
                                            <li><a class="dropdown-item" href="/delete-installer/{{$install->id}}"><i class="la la-trash"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
							@endforeach
                        </tbody>
                    </table>
                </div>
				
			</form>
				 <form method="post" action="/installer-update" enctype="multipart/form-data">
				 @csrf 
                <div class="offcanvas offcanvas-end sheet-detail" tabindex="-1" id="job-detail" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Installation Job Details</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                  
					
                    <div class="offcanvas-body" id="getdetails">
						
                    </div>
                </div>
				</form>
				
            </div>
			{!! $installer->render() !!}
            @else
            <p>No result found.</p>
			@endif
        </div>
    </div>

	
	
	
</main>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	// function PrintElem(elem)
	// 	{
	// 	var id = elem;
	// 	$.ajax({
    //           url: "/print-installer-order",
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
    //     mywindow.close();
    //     return true;
	// }	

    $('.popup').click(function (event) {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
});
	$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".selectid").prop('checked', $(this).prop('checked'));
    });
});	

$('.details').click(function(){
var id= $(this).attr("data-id");
	 $.ajax({
              url: "/installation-details",
              type: "GET",
              data: { id : id },
             success:function(data){
			 $('#getdetails').html(data);
			}
          });
	
});
</script>
@include("layouts.admin.footer")