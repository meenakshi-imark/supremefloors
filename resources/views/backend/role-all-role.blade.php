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

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    All Role Type
                </h1>
                <p>
                    This segment shows the existing role types in Supreme Floor
                </p>
            </div>
			<form method="POST" action="/delete-all-role">
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
                            <th>Role Name</th>
                            <th>Level</th>
                            @foreach($get_per as $get)
                            <th>{{$get->name}}</th>
                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input selectid" name="id[]" type="checkbox" value="{{$role->id}}">
                                </label>
                            </td>
                            <td>
                                {{$role->name}}
                            </td>
                            <td>
                                {{$role->level}}
                            </td>
                            @php
                            $var =explode(",",$role->permission_id);
                            @endphp
                            @foreach($get_per as $get)
                            @if($role->id=="1"||$role->id=="2")
                            <td>
                                <i class="las la-check" aria-hidden="true"></i>
                            </td>
                            @elseif (in_array($get->id, $var))
                            <td>
                                <i class="las la-check" aria-hidden="true"></i>
                            </td>
                            @else
                            <td>
                                <i class="las la-times" aria-hidden="true"></i>
                            </td>
                            @endif
                        
                            @endforeach

                          
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/duplicate/{{$role->id}}"><i class="la la-clone"></i>Duplicate</a></li>
                                        <li><a class="dropdown-item" href="/edit_role/{{$role->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="/delete_role/{{$role->id}}"><i class="la la-trash"></i>Delete</a></li>
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