@include("layouts.admin.header")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Create Product
                </h1>
                <p>
                    This segment is to create a product. A product stock information is under Inventory.
                </p>
            </div>
            @if(session()->has('success'))
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                         <strong>Success!</strong> {{session()->get('success')}}
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                       </div>
                 @endif 
                 @if(session()->has('error'))
                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                         <strong>Error!</strong> {{session()->get('error')}}
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                       </div>
                 @endif 
            <!-- @if(count($errors)>0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif -->
            <div class="form mw-100">
                <form action="{{route('store-product')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Product No.*</label>
                                <input type="number" name="product_no"  class="form-control" value="{{old('product_no')}}" placeholder="45445" required>
                                @error('product_no')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Product Name*</label>
                                <input type="text" name="product_name" value="{{old('product_name')}}" class="form-control" placeholder="Product Name" required>
                                @error('product_name')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <div class="with-radio">
                                    <label class="form-label">Product Category*</label>
                                </div>
                                <select class="form-select" name="product_category" required>
                                    <option selected value="">Select Category..</option>
                                    @foreach($product_category as $category)
                                    @if (old('product_category') == $category->id)
                                    <option value="{{$category->id}}" selected>{{$category->category_name}}</option>
                                    @else
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endif
                                    @endforeach
                                    
                                </select>
                                @error('product_category')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Minimum Product Cost*</label>
                                <input type="number" name="min_cost" value="{{old('min_cost')}}" class="form-control" placeholder="$8432" required>
                                @error('min_cost')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <div class="with-radio">
                                    <label class="form-label">Skirting</label>
                                </div>
                                <div class="search-it">
                                    <div class="dropdown dropdown-product">
                                        <i class="la la-search"></i>
                                        <label class="dropdown-label">Skirting Type 1</label>
                                        <!-- <input type="hidden" class="dropdown-label" name="skirting_type[]" value=""> -->
                                        <div class="dropdown-list">
                                        <div class="checkbox add-skirting">
                                                <label for="checkbox-custom_1" class="checkbox-custom-label">New Skirting</label>
                                                <input type="text" name="dropdown_group[]" value="{{old('dropdown_group.0')}}" id="checkbox-custom_1" />
                                                <a href="#" onclick="add_more()" >Add</a>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Light Grey" class="check checkbox-custom" id="checkbox-custom_02" {{ (is_array(old('dropdown_group')) and in_array("Light Grey", old('dropdown_group'))) ? ' checked' : '' }} />
                                                <label for="checkbox-custom_02" class="checkbox-custom-label">Light Grey</label>
                                            </div>

                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Brown" class="check checkbox-custom" id="checkbox-custom_03" {{ (is_array(old('dropdown_group')) and in_array("Brown", old('dropdown_group'))) ? ' checked' : '' }} />
                                                <label for="checkbox-custom_03" class="checkbox-custom-label">Brown</label>
                                            </div>

                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="White" class="check checkbox-custom" id="checkbox-custom_04" {{ (is_array(old('dropdown_group')) and in_array("White", old('dropdown_group'))) ? ' checked' : '' }} />
                                                <label for="checkbox-custom_04" class="checkbox-custom-label">White</label>
                                            </div>

                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Pure Black" class="check checkbox-custom" id="checkbox-custom_05" {{ (is_array(old('dropdown_group')) and in_array("Pure Black", old('dropdown_group'))) ? ' checked' : '' }} />
                                                <label for="checkbox-custom_05" class="checkbox-custom-label">Pure Black</label>
                                            </div>

                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Black" class="check checkbox-custom" id="checkbox-custom_06" {{ (is_array(old('dropdown_group')) and in_array("Black", old('dropdown_group'))) ? ' checked' : '' }} />
                                                <label for="checkbox-custom_06" class="checkbox-custom-label">Black</label>
                                            </div>
                                            
                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Maple" class="check checkbox-custom" id="checkbox-custom_07" {{ (is_array(old('dropdown_group')) and in_array("Maple", old('dropdown_group'))) ? ' checked' : '' }} />
                                                <label for="checkbox-custom_07" class="checkbox-custom-label">Maple</label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="New Brown" class="check checkbox-custom" id="checkbox-custom_08" {{ (is_array(old('dropdown_group')) and in_array("New Brown", old('dropdown_group'))) ? ' checked' : '' }} />
                                                <label for="checkbox-custom_08" class="checkbox-custom-label">New Brown</label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="New Grey" class="check checkbox-custom" id="checkbox-custom_09" {{ (is_array(old('dropdown_group')) and in_array("New Grey", old('dropdown_group'))) ? ' checked' : '' }} />
                                                <label for="checkbox-custom_09" class="checkbox-custom-label">New Grey</label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Cherry" class="check checkbox-custom" id="checkbox-custom_10" {{ (is_array(old('dropdown_group')) and in_array("Cherry", old('dropdown_group'))) ? ' checked' : '' }} />
                                                <label for="checkbox-custom_10" class="checkbox-custom-label">Cherry</label>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                @error('dropdown_group')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <div class="with-radio">
                                    <label class="form-label">Supplier</label>
                                </div>
                                <div class="search-it">
                                    <i class="la la-search"></i>
                                    <div class="dropdown">
                                        <button class="bg-transparent" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                            Supplier Name
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <div class="accordion" id="accordionExample">
                                                    <!-- @php
                                                    $i = 1;
                                                    @endphp -->
                                                    <input type="hidden" name="supplier_name[]" class="supplier_name" value="">
                                                    <input type="hidden" name="supplier_id[]" class="supplierid" value="">
                                                    @foreach($suppliers as $supplier)
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne{{$i}}">
                                                            <button type="button"  name="{{$supplier->person_name}}"  onClick="get_supplier(this.name)"class="accordion-button ps-2 bg-transparent modal-trigger collapsed" data-id1="{{$supplier->person_name}}" data-id="{{$supplier->id}}"  data-bs-toggle="collapse" data-bs-target="#collapseOne{{$supplier->id}}" aria-expanded="true" aria-controls="collapseOne{{$supplier->id}}" >
                                                                {{$supplier->person_name}}
                                                            </button>
                                                        </h2>
                                                        
                                                        <div id="collapseOne{{$supplier->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne{{$supplier->id}}" data-bs-parent="#accordionExample" >
                                                            <div class="accordion-body border-bottom">
                                                                <div class="row row-cols-2">
                                                                        
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Product Code</label>
                                                                            <input type="hidden" value="{{$supplier->id}}" name="pcode[]">
                                                                            <input type="hidden" value="{{$supplier->person_name}}" name="pname[]">
                                                                            <input type="number" name="product_code[]" class="form-control ps-2" placeholder="45445">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Remarks</label>
                                                                            <input type="text" name="remarks[]" class="form-control ps-2" placeholder="Remarks">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <!-- @php
                                                    $i++;
                                                    @endphp -->
                                                    @endforeach
                                                    <!-- <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingTwo">
                                                            <button class="accordion-button collapsed ps-2 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                                Supplier Two
                                                            </button>
                                                        </h2>
                                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body border-bottom">
                                                            <input type="hidden" name="supplier_name" value="supplier two">
                                                                    <input type="hidden" name="supplier_id" value="#2">
                                                                <div class="row row-cols-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Product Code</label>
                                                                            <input type="number" name="product_code" class="form-control ps-2" placeholder="45445">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Remarks</label>
                                                                            <input type="number" name="remarks" class="form-control ps-2" placeholder="45445">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingThree">
                                                            <button class="accordion-button collapsed ps-2 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                                Supplier Three
                                                            </button>
                                                        </h2>
                                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body border-bottom">
                                                                <div class="row row-cols-2">
                                                                <input type="hidden" name="supplier_name" value="supplier three">
                                                                    <input type="hidden" name="supplier_id" value="#3">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Product Code</label>
                                                                            <input type="number" name="product_code" class="form-control ps-2" placeholder="45445">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Remarks</label>
                                                                            <input type="number" name="remarks" class="form-control ps-2" placeholder="45445">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingFour">
                                                            <button class="accordion-button collapsed ps-2 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                                Supplier Four
                                                            </button>
                                                        </h2>
                                                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body border-bottom">
                                                                <div class="row row-cols-2">
                                                                <input type="hidden" name="supplier_name" value="supplier four">
                                                                    <input type="hidden" name="supplier_id" value="#4">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Product Code</label>
                                                                            <input type="number" name="product_code" class="form-control ps-2" placeholder="45445">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Remarks</label>
                                                                            <input type="number" name="remarks" class="form-control ps-2" placeholder="45445">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="add-more d-flex justify-content-between ps-2">
                                                        <p>New Supplier</p>
                                                        <i data-toggle="modal" data-target="#exampleModalCenter" class="fa fa-plus-circle"></i>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    @error('product_code')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Units Per Packet*</label>
                                <input type="text" name="units_per_packet" class="form-control"placeholder="Enter units" required>
                                <!--select class="form-select" name="units_per_packet" aria-label="Default select example" required>
                                    <option selected value="">Select Units:</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select-->
                                @error('units_per_packet')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
						<div class="col-lg-4 col-8">
                            <div class="form-group">
                                <label class="form-label">Size per unit*</label>
                                <input type="text" id="txtChar" onkeypress="return isNumberKey(event)" name="sizeperunit" value="{{old('sizeperunit')}}" class="form-control" placeholder="Size per unit" required>
                                @error('sizeperunit')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
						<div class="col-lg-2 col-4">
                            <div class="form-group" style="margin-top: 39px;">
                                <select class="form-select" id="sq" name="area">
								  <option value="sq meter">sq meter</option>
								  <option value="sq feet">sq feet</option>
								</select>
                                @error('area')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Description for Sale Invoice*</label>
                                <input type="text" name="descriptions" value="{{old('descriptions')}}" class="form-control" placeholder="Description" required>
                                @error('descriptions')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Reorder quantity field*</label>
                                <input type="number" name="reorder_qty" value="{{old('reorder_qty')}}" class="form-control" placeholder="Reorder quantity" required>
                                @error('reorder_qty')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div> 
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Total Inventory*</label>
                                <input type="number" name="total_inventry" value="{{old('total_inventry')}}" class="form-control" placeholder="Total Inventory" required>
                                <!-- @error('total_inventry')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror -->
                            </div> 
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Photo</label>
                                <div class="upload">
                                    <input type="file" name="p_image" class="form-control" placeholder="" onchange="readURL(this);">
                                    <div class="upload-txt">
                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        <p>Click here or drag and drop files to upload</p>
										
									<img id="blah" src="#" alt="your image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <ul class="readit">
                                <li><span>Photo requirement:</span> Maximum 500 KB</li>
                                <li><span>Format accepted:</span> PNG & JPEG</li>
                            </ul>
                        </div>
                    </div>
                    @error('p_image')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror

                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn productadd" >Create</button>
                        <button type="reset" class="btn btn-white">Clear</button>
                    </div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row row-cols-2">
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Supplier Name</label>
                        <input type="text" name="suppliername" class="form-control ps-2" placeholder="Supplier Name">
                    </div>
                </div> 
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Supplier's Email</label>
                        <input type="email" name="supplier_email" class="form-control ps-2" placeholder="Email">
                    </div>
                </div>                                                           
                <div class="col">
                    <div class="form-group">
                    
                        <label class="form-label">Product Code</label>
                        <input type="number" name="product_code1" class="form-control ps-2" placeholder="45445">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Remarks</label>
                        <input type="text" name="remarks1" class="form-control ps-2" placeholder="Remarks">
                    </div>
                </div>
            </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
                
                </form>
            </div>
        </div>
    </div>
</main>
<style>
    button.btn.productadd {
    font-size: 18px;
    border: 1px solid #13582E;
    font-weight: 500;
    line-height: 3;
    padding: 0 30px;
    text-indent: 0px;
}

</style>
<script>
function get_supplier(name){
$("#dropdownMenuButton1").text(name); 

}

function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
}
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
	
	
$(document).on("click", ".modal-trigger", function () {
  var myspplierId = $(this).data('id');
  $(".supplierid").val(myspplierId);
  
  var myspplierId1 = $(this).data('id1');
  $(".supplier_name").val(myspplierId1);
  
});

$('#myModal').modal('toggle');

function add_more(){
       var html= '<div class="checkbox ">';
        
           html+= '<input type="text" name="dropdown_group[]" value="{{old('dropdown_group')}}" id="checkbox-custom_1" />';
           html+= '<a href="javascript:vioid(0)" onclick="removeitem()">Remove</a>';
           html+= '</div>';
       jQuery('.add-skirting').append('<div id="appended_item">' +html+'</div>');
       
   }
   function removeitem(){
       var html= '<div class="checkbox">';
        
           html-= '<input type="text" name="dropdown_group[]" value="{{old('dropdown_group')}}" id="checkbox-custom_1" />';
        
           html-= '</div>';
       jQuery('#appended_item').remove(html);
       
   
   }
</script>

@include("layouts.admin.footer")