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
                <h1>
                All Customer Accounts
                </h1>
                <p>
                This segment shows the existing Customer Accounts in Supreme Floor ERP.
                </p>
            </div>
		<form action="/customer-all-account" method="GET">
            <div class="filter">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-xl-5 me-3" placeholder="Search Customer" name="search" required>
                        <button type="submit" class="btn me-xl-5 me-3">Search</button>
						
                    </div>
                    <!--a href="javascript:void(0);" class="btn">
                        <i class="la la-filter"></i>
                        Filter
                    </a-->
                </div>
                <!--div class="tab-select">
                    <a href="javascript:void(0);">Direct Cost (10)</a>
                    <a href="javascript:void(0);">Sales Agent (7)</a>
                    <a href="javascript:void(0);">Lorem Ipsum (7)</a>
                    <a href="javascript:void(0);">Lorem Ipsum (7)</a>
                    <a href="javascript:void(0);">Lorem Ipsum (7)</a>
                    <a href="javascript:void(0);">Lorem Ipsum (7)</a>
                </div-->
            </div>
			</form>
			@if(count($customers)>0)
			<form method="POST" action="/delete-all-customers">
			@csrf
			<div id="selectval1">
			<button type="submit" class="btn me-5 mb-2">Delete</button>
			</div>
            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Select All <br>
							<input class="form-check-input" type="checkbox" id="ckbCheckAll" /></th>
                            <th>Customer Name</th>
                            <th>Customer ID</th>
                            <th>Type</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Salary range</th>
                            <th>DOB</th>
                            <th>Bad paymaster</th>
                            <th>remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
					@foreach($customers as $customer)
                        <tr>
                            <td>
                                <label class="form-check-label">
                                     <input class="form-check-input selectid" name="id[]"type="checkbox" value="{{$customer->id}}">
                                </label>
                            </td>
                            <td>
                                <div class="id-name">
                                      <figure>
                                        @if($customer->image==null)
                                        <img src="{{asset('uploads/no-image.png')}}">
                                        @else
                                        <img src="{{asset('uploads/'.$all_account->image)}}">
                                        @endif
                                    </figure>
                                    <span>{{$customer->name}}</span>
                                </div>
                            </td>
                            <td>
                            {{$customer->staff_id}}
                            </td>
                            <td>
                            @if($customer->customer_type=="1")
							@php $type="Direct to homes"; @endphp	
							@else
							@php $type="Sales Agent"; @endphp	
							@endif
							{{$type}}
                            </td>
                            <td>
                            {{$customer->gender}}
                            </td>
                            <td>
                            {{$customer->address}}
                            </td>
                            <td>
                            {{$customer->phone}}
                            </td>
                            <td>{{$customer->email}}</td>
                            <td>{{$customer->salary}}</td>
                            <td>{{$customer->dob}}</td>
                            <td>{{$customer->membership}}</td>
                            <td>{{$customer->remarks}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/customer-edit-account/{{$customer->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="/delete-customer/{{$customer->id}}"><i class="la la-trash"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
						@endforeach
                        
                    </tbody>
                </table>
            </div>
			</form>
			 {!! $customers->render() !!}
            @else
            <p>No result found.</p>
			@endif
        </div>
    </div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".selectid").prop('checked', $(this).prop('checked'));
    });
});	
</script>
@include("layouts.admin.footer")