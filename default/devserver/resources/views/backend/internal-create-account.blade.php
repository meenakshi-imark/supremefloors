@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Create Account
                </h1>
                <p>
                    This segment is for account creation for internal personnel account.
                </p>
            </div>

            <div class="form mw-100">
                <form method="POST" action="/internal-account-store" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Full Name <span style="color:red;" class="ms-0">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Full Name">
                                <span style="color: red"> @error('name'){{$message}}@enderror</span>
                            </div>
							</div> 
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Staff ID <span style="color:red;" class="ms-0">*</span></label>
                                <input type="text" name="staff_id" class="form-control" placeholder="#79892" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <div class="with-radio">
                                    <label class="form-label">Sub Admin Account <span style="color:red;" class="ms-0">*</span></label>
                                    <span>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="roleid" value="2" onclick="javascript:yesnoCheck();"  id="yesCheck" 
                                            @if(old('roleid')=="2") checked @else checked @endif
                                            >
                                            <span>Yes</span>
                                        </label>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="roleid" value="1" onclick="javascript:yesnoCheck();" id="noCheck" {{ old('roleid') == '1' ? 'checked' : '' }} >
                                            <span>No</span>
                                        </label>
                                    </span>
                                </div>
                               <div class="search-it" id="ifYes" style="display:none">
                                 <i class="la la-search"></i>   
                                <select class="form-select" name="role" aria-label="Default select example">
								<option selected value="">Select</option>
								@foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
								@endforeach
                                </select>
                                 <span style="color: red"> @error('role'){{$message}}@enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender" aria-label="Default select example">
                                    <option selected>Select</option>
                                    <option value="1"{{ old('gender') == '1' ? 'selected' : '' }}>Male</option>
                                    <option value="2"{{ old('gender') == '2' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" value="{{old('dob')}}" class="form-control" placeholder="25-10-1994">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Email <span style="color:red;" class="ms-0">*</span></label>
                                <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Email">
                                <span style="color: red"> @error('email'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Address <span style="color:red;" class="ms-0">*</span></label>
                                <input type="text" name="address" value="{{old('address')}}" class="form-control" placeholder="Address">
                                <span style="color: red"> @error('address'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Mobile Phone <span style="color:red;" class="ms-0">*</span></label>
                                <input type="number" name="phone" value="{{old('phone')}}" class="form-control" placeholder="Phone Number">
                                <span style="color: red"> @error('phone'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Username <span style="color:red;" class="ms-0">*</span></label>
                                <input type="text" name="username" value="{{old('username')}}" class="form-control" placeholder="Username">
                                <span style="color: red"> @error('username'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Password <span style="color:red;" class="ms-0">*</span></label>
                                <input type="password" name="password" value="{{old('password')}}" class="form-control" placeholder="Password">
								<span style="color: red"> @error('password'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Confirm Password <span style="color:red;" class="ms-0">*</span></label>
                                <input type="password" name="confirm_password" value="{{old('confirm_password')}}" class="form-control" placeholder="Confirm Password">
								<span style="color: red"> @error('confirm_password'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" value="{{old('remarks')}}" class="form-control" placeholder="Remarks">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Photo</label>
                                <div class="upload">
                                    <input type="file" name="image" class="form-control" placeholder="" onchange="readURL(this);">
                                    <div class="upload-txt">
                                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                    <p>Click here or drag and drop files to upload</p>
									<img id="blah" src="#" alt="your image" />
                                    </div>
                                </div>
                                <span style="color: red"> @error('image'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <ul class="readit">
                                <li><span>Photo requirement:</span>  Maximum 500 KB</li>
                                <li><span>Format accepted:</span>  PNG & JPEG</li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn">Create</button>
                        <a href="" class="btn btn-white">Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
$( document ).ready(function() {
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
function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.display = 'none';
    }
    else document.getElementById('ifYes').style.display = 'block';
}
$( document ).ready(function() {
if( $('#yesCheck').is(':checked') ){
    document.getElementById('ifYes').style.display = 'none';
}
else{
    document.getElementById('ifYes').style.display = 'block';
}
});
</script>
@include("layouts.admin.footer")