@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Create Role
                </h1>
                <p>
                    This segment allows for new role types to be created and customized. You can assign an individual to a role in the 'Create Account' segment.
                </p>
            </div>

            <div class="form">
                <form method="POST" action="/create_role">
					@csrf
                    <div class="form-group">
                        <label class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="rolename"placeholder="Role Name">
						<span class="text-danger" id="name-error"></span>
                    </div>


                    <div class="form-group form-select-group">
                        <label class="form-label">Level</label>
                        <select class="form-select" aria-label="Default select example" id="level">
                            <option selected value="">Select</option>
                             <option value="1">Level 1</option>
                            <option value="2">Level 2</option>
                            <option value="3">Level 3</option>
                        </select>
                    </div>



                    <!-- <div class="form-group">
                        <label class="form-label">System Role Access</label>
                        <div class="check-grid">
                            <label class="form-check-label">
                                <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="" />
                                <span>Role Access System</span>
                            </label>
                        </div>
                    </div> -->


                    <div class="form-group">
                        <label class="form-label">System Role Access</label><br>
						<span class="text-danger" id="permission-error"></span>
                        <div class="accordion" id="myAccordion">
							@foreach($permissions as $per)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$per->id}}"></button>
                                    <div class="check-grid">
                                        <label class="form-check-label">
                                            <input class="form-check-input checkall{{$per->id}}" id="flexCheckDefault" type="checkbox" name="permissions" value="{{$per->id}}" onClick = "checkall({{$per->id}});"/>
                                            <span>{{$per->name}}</span>
                                        </label>
                                    </div>
                                </h2>
                                <div id="collapseOne{{$per->id}}" class="accordion-collapse collapse" data-bs-parent="#myAccordion">
                                    <div class="card-body">
										@foreach($access as $acc)
										@if($per->id==$acc->permission_id)
                                        <div class="check-grid">
                                            <label class="form-check-label">
                                                <input class="form-check-input checked{{$per->id}}" id="flexCheckDefault" type="checkbox" name="access" value="{{$acc->id}}" onClick = "checkallacc({{$per->id}});"/>
                                                <span>{{$acc->name}}</span>
                                            </label>
                                        </div>
										@endif
										@endforeach

                                    </div>
                                </div>
                            </div>
							@endforeach
                           
                        </div>
                    </div>

                    <div class="d-flex btn-grid">
                    <button type="submit" class="btn" id="create_role">Create</button>
                    <a href="" class="btn btn-white">Clear</a>
                    </div>



                </form>
            </div>


        </div>
    </div>
</main>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
var checkval = false; // desecelted
function checkall(id){
var isChecked = $('.checkall'+id).is(':checked');
if(isChecked == true){

    $('.checked'+id).each(function() {
    	if(!checkval) {
        	this.checked = true;
        } 
    }); 
}
else{
	$('.checked'+id).each(function() {
    	if(!checkval) {
        	this.checked = false;
        } 
    }); 
}

}
function checkallacc(id){
var isChecked = $('.checked'+id).is(':checked');
if(isChecked == true){
	$('.checkall'+id).each(function() {
    	if(!checkval) {
        	this.checked = true;
        } 
    }); 
	
}
else{
	$('.checkall'+id).each(function() {
    	if(!checkval) {
        	this.checked = false;
        } 
    }); 
}
}
$("#create_role").click(function(e) {
e.preventDefault();
var rolename = $('#rolename').val();
var level = $("#level").val();
var permission = [];
$.each($("input[name='permissions']:checked"), function(){
permission.push($(this).val());
});

var access = [];
$.each($("input[name='access']:checked"), function(){
access.push($(this).val());
});
if(rolename==""){
$('#name-error').text("This field is required."); 	
}
/*if(permission==""){
$('#permission-error').text("Please select atleast on permission option."); 	
}
if(access==""){
$('#permission-error').text("Please select atleast on acccess option."); 	
}*/
$.ajax({
	 url: "/create_role",
     type:"POST",
     data:{
     "_token": "{{ csrf_token() }}",
	  rolename:rolename,
	  level:level,
	  permission:permission,
	  access:access,
      },
	   success:function(response){
       if (response.status==true) {
             $(".overlay").addClass("is-active");
             $(".quick-popup").addClass("is-active");
			 setTimeout(function(){
			  window.location.href = '/role-all-role';
			}, 1000);
            }
		else{
			$('#name-error').text(response.msg); 
		}
        },
})	
});

</script>
@include("layouts.admin.footer")