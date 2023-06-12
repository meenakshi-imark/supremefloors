@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li style="list-style: none;">{!! \Session::get('success') !!}</li>
            </ul>
        </div>
        @endif
        @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                <li style="list-style: none;">{!! \Session::get('error') !!}</li>
            </ul>
        </div>
        @endif

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                All Warehouse
                </h1>
                <p>
                    This segment shows the existing warehouse in Supreme Floor
                </p>
            </div>
			<form method="POST" action="/delete-all-warehouse">
			<div id="selectval1">
			<button type="submit" class="btn me-5 mb-2">Delete</button>
			</div>
            <div class="all-tabel table-responsive">
			
			@csrf
                <table>
                    <thead>
                        <tr>
                            <th>Select All <br>
							<input  class="form-check-input" type="checkbox" id="ckbCheckAll" /></th>
                            <th>Warehouse Name</th>
                            <th>Address</th>
                            <th>Vinly Flooring</th>
                            <th>Outdoor Decking</th>
                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($warehouses as $warehouse)
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input selectid"  type="checkbox"  name="id[]" value="{{$warehouse->id}}">
                                </label>
                            </td>
                            <td>
                                {{ $warehouse->name }}
                            </td>
                            <td>
                                {{$warehouse->address}}
                            </td>
								<td>
                                <a href="javascript:void(0)" class="view" data-bs-toggle="modal" data-bs-target="#exampleModal{{$warehouse->id}}">View</a>
								</td>
								<td>
                                <a href="javascript:void(0)" class="view" data-bs-toggle="modal" data-bs-target="#exampleModalware{{$warehouse->id}}">View</a>
								</td>
							
                            
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/warehouse-duplicate-warehouse/{{$warehouse->id}}"><i class="la la-clone"></i>Duplicate</a></li>
                                        <li><a class="dropdown-item" href="/warehouse-edit-warehouse/{{$warehouse->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="/warehouse-delete-warehouse/{{$warehouse->id}}"><i class="la la-trash"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
				</form>
            {!! $warehouses->links() !!}
        </div>
    </div>

<!---Model---->







@foreach($warehouses as $warehouse)


<div class="modal modal-view fade " id="exampleModal{{$warehouse->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$warehouse->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel{{$warehouse->id}}">{{$warehouse->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
			 @php
             $var = explode(",",$warehouse->pro_id);
			 $cat = explode(",",$warehouse->pro_cat);
             @endphp
			
			@if(count($getproducts)>0)
			 <div class="modal-body">
                <h6>Available Colours</h6>
                <div class="row row-cols-md-4 row-cols-2">
				@foreach($getproducts as $p)
				<?php
				for($i=0; $i<count($p);$i++){ 
				?>
				@if(in_array($p[$i]->id, $var))
                    <div class="col">
                        <div class="card">
                            <img src="{{asset('admin/productimage/'.$p[$i]->p_image)}}" class="card-img-top" alt="image">
                            <div class="card-body">
                                <p>{{$p[$i]->product_name}}</p>
                                <span>#{{$p[$i]->product_no}}</span>
                            </div>
                        </div>
                    </div>
				@endif
				<?php }?>
				@endforeach
                </div>
            </div>	
			@endif
        </div>
    </div>
</div>



<div class="modal modal-view fade " id="exampleModalware{{$warehouse->id}}" tabindex="-1" aria-labelledby="exampleModalware{{$warehouse->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalware{{$warehouse->id}}">{{$warehouse->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
			 @php
             $var = explode(",",$warehouse->pro_id);
			 $cat = explode(",",$warehouse->pro_cat);
             @endphp
            
			 <div class="modal-body">
                <h6>Available Colours</h6>
                <div class="row row-cols-md-4 row-cols-2">
				@foreach($getproducts1 as $p)
				<?php
				for($i=0; $i<count($p);$i++){ 
				?>
				@if(in_array($p[$i]->id, $var))
                    <div class="col">
                        <div class="card">
                            <img src="{{asset('admin/productimage/'.$p[$i]->p_image)}}" class="card-img-top" alt="image">
                            <div class="card-body">
                                <p>{{$p[$i]->product_name}}</p>
                                <span>#{{$p[$i]->product_no}}</span>
                            </div>
                        </div>
                    </div>
				@endif
				<?php }?>
				@endforeach
                </div>
            </div>	
        </div>
    </div>
</div>
@endforeach

<!---Model---->





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".selectid").prop('checked', $(this).prop('checked'));
    });
});
</script>
@include("layouts.admin.footer")
