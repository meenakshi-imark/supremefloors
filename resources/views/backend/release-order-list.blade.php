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
                <h1>
                    Release Order List
                </h1>
                <p>
                    This segment is to Create a Release Orders captured in Supreme Floor ERP.
                </p>
            </div>
			<div class="filter">
				<form action="/release-order-list" method="GET">
                <div class="form-group">
                    <div class="d-flex w-100">
                        <input type="text" class="form-control ps-2 h-100 me-xl-5 me-3" name="search" placeholder="Search All Orders" required>
                        <button type="submit" class="btn me-xl-5">Search</button>
                    </div>
                </div>
				</form>
            </div>
			@if(count($orders)>0)
			<form method="POST" action="/delete-all-ro"> 
			<div id="selectval1">
			<button type="submit" class="btn me-5 mb-2">Delete</button>
			</div>
			@csrf
            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Select All <br>
							<input class="form-check-input" type="checkbox" id="ckbCheckAll" /></th>
                            <th>RO</th>
                            <th>Installation Date</th>
                            <th>Description</th>
                            <th>Cost</th>
                            <th>Installation Site Address</th>
                            <th>Approval</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
					@foreach($orders as $order)
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input selectid" type="checkbox" name="id[]" value="{{$order->id}}">
                                </label>
                            </td>
                            <td>
                                #{{$order->order_id}}
                            </td>
                            <td>
                                {{$order->estimate_date}}
                            </td>
                            <td>
                                {{$order->remarks}}
                            </td>
                            <td>
                                ${{$order->total}}
                            </td>
                            <td>
							{{$order->site_address}}
                            </td>
							<td>
								<select class="form-select" aria-label="Default select example" onchange="location = this.value;">
                                    <option @if($order->approval=="1") selected @endif value="/ro-status-change/{{$order->id}}/1">Pending</option>
                                    <option @if($order->approval=="2") selected @endif value="/ro-status-change/{{$order->id}}/2">Approved</option>
                                </select>
								</td>
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="/release-order-edit-ro/{{$order->id}}">
                                                <i class="la la-pencil-square-o" aria-hidden="true"></i>
                                                Edit</a>
                                        </li>
										<li><a class="dropdown-item popup" href="javascript:void(0);" data-id="{{$order->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-print" aria-hidden="true"></i>Print RO</a></li>	
										<li><a class="dropdown-item" href="/ro-pdf/{{$order->id}}?download=pdf"><i class="la la-download" aria-hidden="true"></i>Download as PDF</a></li>
                                        <li>
                                            <a class="dropdown-item" href="/delete-ro/{{$order->id}}">
                                                <i class="la la-trash"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
				 {!! $orders->render() !!}
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
@foreach($orders as $order)
<div id="{{$order->id}}" style="display:none">
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
    //           url: "/print-ro",
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
	// 	}	

    $('.popup').click(function (event) {
    event.preventDefault();
    var inv_id = $(this).attr('data-id');
    var iframe = '<iframe src="https://erp.supremefloors.com.sg/print-ro/'+inv_id+'"></iframe>';
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