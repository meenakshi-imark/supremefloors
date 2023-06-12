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
                    All Customer Type
                </h1>
                <p>
                    This segment shows the existing customer types in Supreme Floor ERP.
                </p>
            </div>
			<form method="POST" action="/delete-all-types">
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
                            <th>Type Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
					@foreach($types as $type)
                        <tr>
                            <td>
                                <label class="form-check-label">
                                   <input class="form-check-input selectid" name="id[]"type="checkbox" value="{{$type->id}}">
                                </label>
                            </td>
                            <td>
							{{$type->type_name}}
                            </td>
                            <td>
							{{$type->description}}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/customer-edit-create-type/{{$type->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="/delete-type/{{ $type->id }}"><i class="la la-trash"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
					@endforeach
                        
                        
                        
                        
                       
                        
                    </tbody>
                </table>
            </div>
			</form>
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