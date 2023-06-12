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
			<div class="row">
			<div class="col-md-9">
                <h1>
                    Purchase Order List
                </h1>
                <p>
                    This segment shows Purchase orders captured in Supreme Floor ERP.
                </p>
			</div>
			<div class="col-md-3">
			<a href="/purchase-order-create-po" class="btn me-md-5 mb-2 mb-2 w-100 w-md-auto">Create PO</a>
			</div>
			</div>
            </div>
            <div class="filter">
				<form action="/purchase-order-list" method="GET">
                <div class="form-group">
                    <div class="d-flex w-100">
                        <input type="text" class="form-control ps-2 h-100 me-xl-5 me-3" name="search" placeholder="Search All Orders" required>
                        <button type="submit" class="btn">Search</button>
                    </div>
                </div>
				</form>
            </div>
			@if(count($orderlist)>0)
			
			<form method="POST" action="/delete-all-orders"> 
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
                            <th>PO</th>
                            <th>Date Created</th>
                            <th>Estimate Arrival</th>
                            <th>Cost</th>
                            <th>Approval</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
					@foreach($orderlist as $list)
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input selectid" type="checkbox" name="id[]" value="{{$list->id}}">
                                </label>
                            </td>
                            <td>#{{$list->order_no}}</td>
							
							@php 
							$x = $list->created_at;
							$created = strtok($x, " ");
							@endphp
                            <td>{{$created}}</td>
                            <td>{{$list->estimated_arrival}}</td>
                            <td>${{$list->total_price}}</td>
							
							<td>
                                 <select class="form-select" aria-label="Default select example"  onchange="location = this.value;" >
                                    <option @if($list->approval=="pending") selected @endif value="/approval-change/{{$list->id}}/pending">Pending</option>
                                    <option @if($list->approval=="approved") selected @endif  value="/approval-change/{{$list->id}}/approved">Approved</option>
                                    <option @if($list->approval=="rejected") selected @endif  value="/approval-change/{{$list->id}}/rejected">Rejected</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-select" aria-label="Default select example"  onchange="location = this.value;" >
                                    <option @if($list->status=="1") selected @endif value="/status-change/{{$list->id}}">Sent</option>
                                    <option @if($list->status=="2") selected @endif  value="/status-change/{{$list->id}}">Received</option>
                                </select>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/edit-purchase-order/{{$list->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item"onclick="PrintElem('{{$list->id}}')" data-id="{{$list->id}}"><i class="las la-print" aria-hidden="true"></i>Print PO</a></li>
                                        <li><a class="dropdown-item" href="/delete-order/{{$list->id}}"><i class="la la-trash"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                      @endforeach
                       
                        
                        
                        

                    </tbody>
                </table>
				 {!! $orderlist->render() !!}
            </div>
			</form>
			 @else
            <p>No result found.</p>
            @endif
        </div>
    </div>
</main>
@foreach($orderlist as $list)
<div id="{{$list->id}}" style="display:none">
<div id="getp">
</div>
</div>
@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
    function PrintElem(elem)
    {
		var id = elem;
		$.ajax({
              url: "/print-po",
              type: "GET",
              data: { id : id },
             success:function(data){
			 $('#getp').html(data);
			  Popup(data);
			}
          });
       
    }

    function Popup(dataa)
    {
        var mywindow = window.open('', 'new div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Quotation</title>');
        mywindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">');
        mywindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">');
        mywindow.document.write('<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">');
        mywindow.document.write('</head><body >');
        mywindow.document.write(dataa);
        mywindow.document.write('</body></html>');
        mywindow.print();
        mywindow.close();
        return true;
    }
</script>
	<script>
	$(document).ready(function () {
		$("#ckbCheckAll").click(function () {
			$(".selectid").prop('checked', $(this).prop('checked'));
		});
	});
	</script>
@include("layouts.admin.footer")