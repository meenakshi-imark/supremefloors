@include("layouts.admin.header")
<style>
    iframe{
        height:580px;
        /* height:90%; */
        width:100%;
    }
    .modal-dialog{
    height:90% !important;
}
</style>
<main class="content-wrapper">
    <div class="container-fluid">
		 @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
		@endif
		 @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
		@endif
		 
				
        <div class="box-shadow account">

            <div class="main-heading">
			<div class="row">
			<div class="col-md-9">
                <h1>
                    Quotation
                </h1>
                <p>
                    This segment shows the Quotation in Supreme Floor ERP.
                </p>
            </div>
			<div class="col-md-3" style="text-align: right;">
			<a href="/quotation-create-quotation" class="btn me-xl-5">Add Quotation</a>
            </div>
            </div>
            </div>
            <div class="filter">
               <form action="/sales-all-quotation" method="GET">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
					 <i class="la la-search"></i>
                        <input type="text" class="form-control me-xl-5 me-3" name="search" placeholder="Search Quotation" required>
                        <button type="submit" class="btn me-xl-5">Search</button>
						
                 </div>
                 </div>
			  </form> 
            </div>
			@if(count($quotations)>0)
			<form method="POST" action="/delete-all-quotation"> 
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
                            <th>Quotation</th>
                            <th>Sales Staff</th>
                            <th>Installation Date</th>
                            <th>Owner/Company</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
					@foreach($quotations as $quotation)
                        <tr>
                            <td>
                                <label class="form-check-label">
                                     <input class="form-check-input selectid" type="checkbox" name="id[]" value="{{$quotation->id}}">
                                </label>
                            </td>
                            <td>
                                {{$quotation->quotation_id}}
                            </td>
                            <td>
                            @php 
							$sp = DB::table('users')->select('name')->where('id',$quotation->attention_to)->first();
							@endphp
							@if($sp)
							@php $name= $sp->name; @endphp
							@else
							@php $name= ""; @endphp
							@endif
                            {{$name}}
                            </td>
                            <td>
                                {{$quotation->due_date}}
                            </td>
                            <td>
							@php 
							$com = DB::table('suppliers')->select('company_name')->where('id',$quotation->company)->first();
							@endphp
							@if($com)
							@php $comp_name= $com->company_name; @endphp
							@else
							@php $comp_name= ""; @endphp
							@endif
							{{$comp_name}}
                            </td>
                            <td>
							@if (strlen($quotation->invoice) > 30)
							@php $descriptions = substr($quotation->invoice, 0, 30) . '...'; @endphp
							@else 
							@php $descriptions = $quotation->invoice; @endphp
							@endif
                                {{$descriptions}}
                            </td>
                            <td>
                                ${{$quotation->total}}
                            </td>
                            <td>
                                <select class="form-select" aria-label="Default select example" onchange="location = this.value;">
                                    <option @if($quotation->status=="pending") selected @endif value="/quotation-status-change/{{$quotation->id}}/pending">Pending</option>
                                    <option @if($quotation->status=="approved") selected @endif value="/quotation-status-change/{{$quotation->id}}/approved">Approved</option>
                                    <option @if($quotation->status=="rejected") selected @endif value="/quotation-status-change/{{$quotation->id}}/rejected">Rejected</option>
                                </select>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/sales-quotation-edit/{{$quotation->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item d-flex" href="/release-order-create-ro?quotation={{$quotation->id}}">
                                            <figure class="mb-0">
                                                <img src="{{asset('admin/images/sent.png')}}">
                                            </figure> RO</a></li>
										<li><a class="dropdown-item popup" data-id="{{$quotation->id}}" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-print" aria-hidden="true"></i>Print Quotation</a></li>	
                                        <li><a class="dropdown-item" href="/quotation-pdf/{{$quotation->id}}?download=pdf"><i class="la la-download" aria-hidden="true"></i>Download as PDF</a></li>
                                        <li><a class="dropdown-item" href="/delete-quotation/{{$quotation->id}}"><i class="la la-trash"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
						@endforeach
						
						
                    </tbody>
                </table>
				{!! $quotations->render() !!}
            </div>
			</form>
			 @else
            <p>No result found.</p>
            @endif
        </div>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> -->
      <div class="appnd_iframe" >
        
      </div>
    </div>
  </div>
</div>
@foreach($quotations as $quotation)
<div id="{{$quotation->id}}" style="display:none">
<div id="getp">
</div>
</div>
@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	// function PrintElem(elem)
	// 	{
	// 	var id = elem;
	// 	$.ajax({
    //           url: "/print-quotation",
    //           type: "GET",
    //           data: { id : id },
    //          success:function(data){
	// 		 $('#getp').html(data);
	// 		  Popup(data);
	// 		}
    //       });
		
    // }

    // function Popup(dataa)
	// 	{
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
	// 	}
    $('.popup').click(function (event) {
    event.preventDefault();

    var inv_id = $(this).attr('data-id');
    var iframe = '<iframe src="https://erp.supremefloors.com.sg/print-quotation/'+inv_id+'"></iframe>';
        $('.appnd_iframe').empty('');
    $('.appnd_iframe').html(iframe);

    // window.open($(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
});
	$(document).ready(function () {
		$("#ckbCheckAll").click(function () {
			$(".selectid").prop('checked', $(this).prop('checked'));
		});
	});
	</script>
@include("layouts.admin.footer")