@include("layouts.admin.header")
<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Edit Account
                </h1>
                <p>
                    This segment is for account creation for internal personnel.
                </p>
            </div>

            <div class="form mw-100">
                <form method="POST" action="/internal-update-account/{{ $edit->id }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $edit->name }}" placeholder="Full Name">
                                <span style="color: red"> @error('name'){{$message}}@enderror</span>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <div class="with-radio">
                                    <label class="form-label">Sub Admin Account</label>
                                    <span>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="roleid" value="2" onclick="javascript:yesnoCheck();"  id="yesCheck" @if($edit->role_id=="2") checked @endif
                                            @if(old('roleid')=="2") checked @else checked @endif>
                                            <span>Yes</span>
                                        </label>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="roleid" value="1"onclick="javascript:yesnoCheck();" id="noCheck"@if($edit->role_id!="2") checked @endif
                                            {{ old('roleid') == '1' ? 'checked' : '' }}>
                                            <span>No</span>
                                        </label>
                                    </span>
                                </div>
                                <div class="search-it" id="ifYes" style="display:none">
                                    <i class="la la-search"></i>
                                    <select class="form-select" name="role"  aria-label="Default select example">
                                        <option  value="">Select</option>
                                        @foreach($roles as $role)
                                          <option value="{{$role->id}}" @if($role->id==$edit->role_id) selected @endif</option>{{$role->name}}</option>
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
                                    <option value="1"{{ $edit->gender == 1 ? 'selected' : '' }}>Male</option>
                                    <option value="2"{{ $edit->gender == 2 ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Date of Birth</label> 
                                <input type="date" class="form-control" name="dob" value="{{ date('Y-m-d', strtotime($edit->dob)); }}" placeholder="25-10-1994" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $edit->email }}" placeholder="Email">
                                <span style="color: red"> @error('email'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" value="{{ $edit->address }}" placeholder="Address"
                                >
                                <span style="color: red"> @error('address'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Mobile Phone</label>
                                <input type="number" class="form-control" name="phone" value="{{ $edit->phone }}" placeholder="Phone Number">
                                <span style="color: red"> @error('phone'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username"  value="{{ $edit->username }}" placeholder="Username" value="">
                            <span style="color: red"> @error('username'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                    @if($edit->image!=null)
                       


                    <div class="row" id="imghide">
                        <div class="col-12">
                            <div class="form-group user-img">
                            <a href="#" id="hideimg" data-id="{{$edit->id}}"><i class="fa fa-times"></i></a>
                            <img src="{{asset('uploads/'.$edit->image)}}">
                            </div>
                        </div>
                    </div>
                   @endif
                    
                    @if($edit->image!=null)
                    @php $style="display:none"; @endphp
                    @else
                    @php $style="display:block"; @endphp
                    @endif
                   
                    <div class="row"id="imgshow" style="{{$style}}">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Photo</label>
                                <div class="upload">
                                    <input type="file" name="image" value="{{ $edit->image }}" class="form-control" placeholder="" onchange="readURL(this);">
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
                        <button type="submit" class="btn">Update</button>
                        <a href="" class="btn btn-white">Clear</a>
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
function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.display = 'none';
    }
    else document.getElementById('ifYes').style.display = 'block';
}
$( document ).ready(function() {
  document.getElementById('ifYes').style.display = 'block';
});
$(document).ready(function() {
if( $('#yesCheck').is(':checked') ){
    document.getElementById('ifYes').style.display = 'none';
}
else{
    document.getElementById('ifYes').style.display = 'block';
}
});
</script>
@include("layouts.admin.footer")