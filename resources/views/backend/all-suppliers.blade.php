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

        <div class="box-shadow account">

            <div class="main-heading">
                <h1>
                    All Suppliers
                </h1>
                <p>
                    This segment shows the all suppliers in Supreme Floor ERP.
                </p>
            </div>
			 <div class="filter">
                <form action="/suppliers" method="GET">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-xl-5 me-3" name="search" placeholder="Search Suppliers" required>
                        <button type="submit" class="btn me-xl-5">Search</button>
						
                    </div>
					</form>
					</div>
            </div>
		 @if(count($get)>0)
            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Contact Person Name</th>
                            <th>Phone</th>
                            <th>Website</th>
                            <th>Country of Origin</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($get as $suppliers)
                        <tr>
                            <td>
                              {{$suppliers->company_name}}  
                            </td>
                            <td>{{$suppliers->email}}</td>
                            <td>{{$suppliers->address}}</td>
                            <td>{{$suppliers->person_name}}</td>
                            <td>{{$suppliers->phone}}</td>
                            <td>{{$suppliers->website}}</td>
                            <td>{{$suppliers->country}}</td>
							@if (strlen($suppliers->remarks) > 30)
							@php $remarks = substr($suppliers->remarks, 0, 30) . '...'; @endphp
							@else 
							@php $remarks = $suppliers->remarks; @endphp
							@endif
                            <td>{{$remarks}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/edit_supplier/{{$suppliers->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="/delete_suppliers/{{$suppliers->id}}"><i class="la la-trash"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
			 {!! $get->render() !!}
            @else
            <p>No result found.</p>
            @endif
        </div>
    </div>
</main>

@include("layouts.admin.footer")