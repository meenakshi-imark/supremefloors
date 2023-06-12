@include("layouts.admin.header")

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
                <h1>
                    Invoice
                </h1>
                <p>
                    This segment shows the Invoice in Supreme Floor ERP.
                </p>
            </div>
            <div class="filter">
               <form action="/all-invoice" method="GET">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
					<i class="la la-search"></i>
                        <input type="text" class="form-control me-xl-5 me-3" name="search" placeholder="Search Invoice" required>
                        <button type="submit" class="btn me-xl-5">Search</button>
						
                 </div>
                 </div>
			  </form> 
            </div>
			@if(count($invoices)>0)
			<form method="POST" action="/delete-all-invoice"> 
			<div id="selectval1">
			<button type="submit" class="btn me-5 mb-2">Delete</button>
			</div>
			@csrf
            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Select All</br>
							<input class="form-check-input" type="checkbox" id="ckbCheckAll" /></th>
                            <th>Invoice</th>
                            <th>Attention To</th>
                            <th>Installation Date</th>
                            <th>Owner/Company</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Completed Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
					@foreach($invoices as $invoice)
                        <tr>
                            <td>
                                <label class="form-check-label">
                                     <input class="form-check-input selectid" type="checkbox" name="id[]" value="{{$invoice->id}}">
                                </label>
                            </td>
                            <td>
                                {{$invoice->invoice_id}}
                            </td>
                            <td>
                            @php 
							
							$sp = DB::table('users')->select('name')->where('id',$invoice->attention_to)->first();
							@endphp
							@if($sp)
                            {{$sp->name}}
							@else
							-
							@endif
                            </td>
                            <td>
                                {{$invoice->due_date}}
                            </td>
                            <td>
							-
                            </td>
                            <td>
							@if (strlen($invoice->invoice) > 30)
							@php $descriptions = substr($invoice->invoice, 0, 30) . '...'; @endphp
							@else 
							@php $descriptions = $invoice->invoice; @endphp
							@endif
                                {{$descriptions}}
                            </td>
                            <td>
                                ${{$invoice->total}}
                            </td>
                            <td>
                                <select class="form-select" aria-label="Default select example" onchange="location = this.value;">
                                    <option @if($invoice->status=="pending") selected @endif value="/invoice-status-change/{{$invoice->id}}/pending">Pending</option>
                                    <option @if($invoice->status=="completed") selected @endif value="/invoice-status-change/{{$invoice->id}}/completed">Completed</option>
                                    <option @if($invoice->status=="rejected") selected @endif value="/invoice-status-change/{{$invoice->id}}/rejected">Rejected</option>
                                </select>
							</td>
							<td>
							@if($invoice->status=="completed")
							{{$invoice->completed_at}}
							@else
							-
							@endif
							</td>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/edit-invoice-edit/{{$invoice->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item popup" href="/print-invoice/{{$invoice->id}}" ><i class="las la-print" aria-hidden="true"></i>Print Invoice</a></li>	
										<li><a class="dropdown-item" href="/invoice-pdf/{{$invoice->id}}?download=pdf"><i class="la la-download" aria-hidden="true"></i>Download as PDF</a></li>
                                        <li><a class="dropdown-item" href="/delete-invoice/{{$invoice->id}}"><i class="la la-trash"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
						@endforeach
						
						
                    </tbody>
                </table>
				{!! $invoices->render() !!}
            </div>
			</form>
			 @else
            <p>No result found.</p>
            @endif
        </div>
    </div>
</main>

@foreach($invoices as $invoice)
<div id="{{$invoice->id}}" style="display:none">
<div id="getp">
</div>
</div>
@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
		// function PrintElem(elem)
		// {
		// var id = elem;
		// $.ajax({
        //       url: "/print-invoice",
        //       type: "GET",
        //       data: { id : id },
        //      success:function(data){
		// 	 $('#getp').html(data);
		// 	  Popup(data);
		// 	}
        //   });
		
		// }

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
	// 	}
    $('.popup').click(function (event) {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
});
	$(document).ready(function () {
		$("#ckbCheckAll").click(function () {
			$(".selectid").prop('checked', $(this).prop('checked'));
		});
	});
	</script>
@include("layouts.admin.footer")