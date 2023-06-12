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
        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                Update Customer Account
                </h1>
                <p>
                This segment is for account updation for customer.
                </p>
            </div>

            <div class="form mw-100">
            <form method="POST" action="/customer-update-account" enctype="multipart/form-data">
				@csrf
                <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Full Name <span style="color:red" class="ms-0">*</span></label>
                                <input type="text" class="form-control" name="fullname" placeholder="Full Name" value="{{$customer->name}}" >
                                <input type="hidden" name="id" value="{{$customer->id}}" >
								<span style="color: red"> @error('fullname'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
						<div class="form-group form-select-group w-100">
                        <div class="with-radio">
                                    <label class="form-label">Type <span style="color:red" class="ms-0">*</span></label>
                                </div>
                                <div class="search-it">
                                    <i class="la la-search"></i>
                                    <select class="form-select" aria-label="Default select example" name="type" id="type" onchange="displayDivDemo('show', this)">
                                        <option value="">Select</option>
                                        <option value="1" {{ $customer->customer_type == '1' ? 'selected' : '' }}>Direct to homes</option>
                                        <option value="2" {{ $customer->customer_type == '2' ? 'selected' : '' }}>Sales Agent</option>
                                    </select>
                                </div>
								<span style="color: red"> @error('type'){{$message}}@enderror</span>
                            </div>
                        </div>
						
                    </div>
                    <div class="row" >
                        <div class="col-lg-6 show">
                            <div class="form-group">
                                <label class="form-label">Company Name <span style="color:red" class="ms-0">*</span></label>
                                <input type="text" class="form-control" name="company_name"placeholder="Company Name" value="{{$customer->company_name}}">
								<span style="color: red"> @error('company_name'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Gender <span style="color:red" class="ms-0">*</span></label>
                                <select class="form-select" aria-label="Default select example" name="gender">
                                    <option value="">Select</option>
                                    <option value="male" {{ $customer->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $customer->gender == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
								<span style="color: red"> @error('gender'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <!--div class="row" >
                        <div class="col-lg-6 show" style="display:none;">
                            <div class="form-group">
                                <label class="form-label">Company Name <span style="color:red" class="ms-0">*</span></label>
                                <input type="text" class="form-control" name="company_name"placeholder="Company Name" value="{{ old('company_name') }}">
								<span style="color: red"> @error('company_name'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100" style="display:none;">
                                <label class="form-label">Gender <span style="color:red" class="ms-0">*</span></label>
                                <select class="form-select" aria-label="Default select example" name="gender">
                                    <option value="">Select</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
								<span style="color: red"> @error('gender'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div-->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Date of Birth <span style="color:red" class="ms-0">*</span></label>
                                <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="dob"value="{{$customer->dob}}">
								<span style="color: red"> @error('dob'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Email <span style="color:red" class="ms-0">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="davidsmith@123gmail.com" value="{{$customer->email}}">
								<span style="color: red"> @error('email'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Address <span style="color:red" class="ms-0">*</span></label>
                                <input type="text" class="form-control" id="autocomplete"name="address"placeholder="Calle Socrates Nolasco #6-B, Ens. Naco, Santo Domingo, Dominican Republic" value="{{$customer->address}}">
								<span style="color: red"> @error('address'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Mobile Phone <span style="color:red" class="ms-0">*</span></label>
                                <input type="number" class="form-control" placeholder="(450) 297-1007" name="number" value="{{$customer->phone}}">
								<span style="color: red"> @error('number'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Group <span style="color:red" class="ms-0">*</span></label>
                                <input type="text" name="group"class="form-control" placeholder="David" value="{{$customer->customer_group}}">
								<span style="color: red"> @error('group'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Bad Paymaster <span style="color:red" class="ms-0">*</span></label>
								<select class="form-select" aria-label="Default select example" name="membership">
                                    <option value="yes" {{ $customer->membership == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ $customer->membership == 'no' ? 'selected' : '' }}>No</option>
                                </select>
								<span style="color: red"> @error('membership'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Estimated Salary </label>
                                <input type="text" class="form-control" placeholder="$454" name="salary" value="{{$customer->salary}}">
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->role_id=="9" || auth()->user()->role_id=="1")
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Sales Staff Name <span style="color:red" class="ms-0">*</span></label>
                                <input type="text" class="form-control" name="staff_name"placeholder="Sales Staff Name"  value="{{$customer->staff_name}}">
								<span style="color: red"> @error('staff_name'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Sales Staff ID <span style="color:red" class="ms-0">*</span></label>
                                <input type="text" class="form-control" name="staff_id" placeholder="#44958"  value="{{$customer->staff_id}}">
								<span style="color: red"> @error('staff_id'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
					
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Rebates <span style="color:red" class="ms-0"></span></label>
                                <input type="text" class="form-control" name="rebates" placeholder="Rebates" value="{{$customer->rebates}}">
								<span style="color: red"> @error('rebates'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">User Name <span style="color:red" class="ms-0">*</span></label>
                                <input type="text" class="form-control" name="username" placeholder="User Name" value="{{$customer->username}}">
								<span style="color: red"> @error('username'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
					@endif

                    <div class="row">
                        <div class="col-lg-6 show">
                            <div class="form-group">
                                <label class="form-label">Password <span style="color:red" class="ms-0">*</span></label>
                                <input type="password" class="form-control" placeholder="Password" value="{{ old('password') }}" name="password">
								<span style="color: red"> @error('password'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6 show">
                            <div class="form-group">
                                <label class="form-label">Confirm Password <span style="color:red" class="ms-0">*</span></label>
                                <input type="password" class="form-control" placeholder="Confirm Password" value="{{ old('confirm_password') }}" name="confirm_password">
								<span style="color: red"> @error('confirm_password'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Remarks</label>
                                <input type="text" class="form-control" name="remarks" placeholder="Remarks" value="{{$customer->remarks}}">
								<span style="color: red"> @error('remarks'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>

                    @if($customer->image!=null)
                       


                    <div class="row" id="imghide">
                        <div class="col-12">
                            <div class="form-group user-img">
                            <a href="#" id="hideimg" data-id="{{$customer->id}}"><i class="fa fa-times"></i></a>
                            <img src="{{asset('uploads/'.$customer->image)}}">
                            </div>
                        </div>
                    </div>
                   @endif
                    
                    @if($customer->image!=null)
                    @php $style="display:none"; @endphp
                    @else
                    @php $style="display:block"; @endphp
                    @endif
                   
                    <div class="row"id="imgshow" style="{{$style}}">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Photo</label>
                                <div class="upload">
                                    <input type="file" name="image" value="{{ $customer->image }}" class="form-control" placeholder="" onchange="readURL(this);">
                                    <div class="upload-txt">
                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        <p>Click here or drag and drop files to upload</p>
										<img id="blah" src="#" alt="your image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="row" id="hidetxt"style="display:none;">
                        <div class="col-12">
                            <ul class="readit">
                                <li><span>Photo requirement:</span> Maximum 500 KB</li>
                                <li><span>Format accepted:</span> PNG & JPEG</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn">Create</button>
                        <button type="reset" class="btn btn-white">Clear</button>
                    </div>
                    

            </form>
            
            </div>
        </div>
    </div>
</main>

<style>
.user-img { position: relative;width:150px; }
.user-img img { display: block;}
.user-img .fa-download { position: absolute; bottom:0; left:0; }
.fa-times:before {
    color: red;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
     
      var placeSearch, autocomplete;
      function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
   

      }
   
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
</script>
<script>
$( document ).ready(function() {
var type = $("#type").val();
if(type=="2"){
	$(".show").show(); 
}
else{
	$(".show").hide(); 
}
$("#blah").hide();
});	
function readURL(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();
reader.onload = function (e) {
$("#blah").show();	
$('#blah')
.attr('src', e.target.result)
.width(150)
.height(200);
};

reader.readAsDataURL(input.files[0]);
}
}

$("#hideimg").click(function() {
 $("#imghide").hide();
 $("#imgshow").show();
 $("#hidetxt").show();
 var id = $('#hideimg').attr("data-id");
 $.ajax({
	 url: "/delete_imgg",
     type:"GET",
     data:{
     "_token": "{{ csrf_token() }}",
	  id:id,
      },
	  
})
});

function displayDivDemo(id, elementValue) {
     document.getElementsByClassName(id);
	if(elementValue.value=="2"){
		$(".show").show(); 
	}
	else{
		$(".show").hide(); 
	}
}
</script>
@include("layouts.admin.footer")