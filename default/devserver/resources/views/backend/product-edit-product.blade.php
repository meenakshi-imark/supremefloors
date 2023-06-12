@include("layouts.admin.header")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Edit Product
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
                <form action="/update-product/{{$products->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Product No.</label>
                                <input type="text" name="product_no" value="{{$products->product_no}}" class="form-control" placeholder="Product No">
                                @error('product_no')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="product_name" value="{{$products->product_name}}" class="form-control" placeholder="Product Name">
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
                                    <label class="form-label">Product Category</label>
                                </div>
                                <select class="form-select" name="product_category" >
                                    <option selected>Select Category..</option>
                                    @foreach($product_category as $category)
                                    @if($products->product_category == $category->id)
                                    <option value="{{$category->id}}"  selected>{{$category->category_name}}</option>
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
                                <label class="form-label">Minimum Product Cost</label>
                                <input type="number" name="min_cost" value="{{$products->min_cost}}" class="form-control" placeholder="$8432">
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
                                            @php
                                            $dropdown_group = explode(',', $products->skirting_type);
                                            @endphp
											@if($dropdown_group!="Light Grey" ||$dropdown_group!="Brown" ||$dropdown_group!="White" ||$dropdown_group!="Pure Black" ||$dropdown_group!="Black" ||$dropdown_group!="Maple" ||$dropdown_group!="New Brown" ||$dropdown_group!="New Grey" ||$dropdown_group!="Cherry")
											@php $val =	$dropdown_group; @endphp
											@else 
											$val =	"";	
											@endif
                                            <div class="checkbox add-skirting">
                                                <label for="checkbox-custom_1" class="checkbox-custom-label">New Skirting</label>
                                                @foreach($val as $new_skirting)
                                                @if($new_skirting=="Light Grey" ||$new_skirting=="Brown" ||$new_skirting=="White" ||$new_skirting=="Pure Black" ||$new_skirting=="Black" ||$new_skirting=="Maple" ||$new_skirting=="New Brown" ||$new_skirting=="New Grey" ||$new_skirting=="Cherry")
                                               
                                               @php
                                               break;
                                               @endphp
                                               @endif
                                                <input type="text" name="dropdown_group[]" value="{{$new_skirting}}" id="checkbox-custom_1" />
                                               
                                               @endforeach
                                                
                                                <a href="#" onclick="add_more()" >Add</a>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Light Grey" class="check checkbox-custom" id="checkbox-custom_02"  @if(in_array("Light Grey",$dropdown_group)) checked @endif >
                                                <label for="checkbox-custom_02" class="checkbox-custom-label">Light Grey</label>
                                            </div>

                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Brown" class="check checkbox-custom" id="checkbox-custom_03" @if(in_array("Brown",$dropdown_group)) checked @endif >
                                                <label for="checkbox-custom_03" class="checkbox-custom-label">Brown</label>
                                            </div>

                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="White" class="check checkbox-custom" id="checkbox-custom_04" @if(in_array("White",$dropdown_group)) checked @endif >
                                                <label for="checkbox-custom_04" class="checkbox-custom-label">White</label>
                                            </div>

                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Pure Black" class="check checkbox-custom" id="checkbox-custom_05" @if(in_array("Pure Black",$dropdown_group)) checked @endif >
                                                <label for="checkbox-custom_05" class="checkbox-custom-label">Pure Black</label>
                                            </div>

                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Black" class="check checkbox-custom" id="checkbox-custom_06" @if(in_array("Black",$dropdown_group)) checked @endif >
                                                <label for="checkbox-custom_06" class="checkbox-custom-label">Black</label>
                                            </div>
                                            
                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Maple" class="check checkbox-custom" id="checkbox-custom_07" @if(in_array("Maple",$dropdown_group)) checked @endif >
                                                <label for="checkbox-custom_07" class="checkbox-custom-label">Maple</label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="New Brown" class="check checkbox-custom" id="checkbox-custom_08" @if(in_array("New Brown",$dropdown_group)) checked @endif >
                                                <label for="checkbox-custom_08" class="checkbox-custom-label">New Brown</label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="New Grey" class="check checkbox-custom" id="checkbox-custom_09" @if(in_array("New Grey",$dropdown_group)) checked @endif >
                                                <label for="checkbox-custom_09" class="checkbox-custom-label">New Grey</label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="dropdown_group[]" value="Cherry" class="check checkbox-custom" id="checkbox-custom_10" @if(in_array("Cherry",$dropdown_group)) checked @endif >
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
                                                    @php
                                                    $suppliersname =explode(',', $products->supplier_name);
                                                    $suppliersid = explode(',', $products->supplier_id);
                                                    $productcodes = explode(',', $products->product_code);
                                                    $remarks = explode(',', $products->remarks);
                                                    $count = count($suppliersid);
                                                    
                                                    @endphp

                                                    <!-- <input type="hidden" name="supplier_name[]" class="supplier_name" value="">
                                                    <input type="hidden" name="supplier_id[]" class="supplierid" value=""> -->

                                                             @for ($i = 0; $i < $count; $i++)
                                                                                                            
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingOne{{$i}}">
                                                                    <!-- $supplier = DB::table('suppliers')->where('person_name',$products->supplier_name); -->
                                                                <button type="button" class="accordion-button ps-2 bg-transparent modal-trigger collapsed" data-id1="{{$suppliersname[$i]}}" data-id="{{$suppliersid[$i]}}"  data-bs-toggle="collapse" data-bs-target="#collapseOne{{$suppliersid[$i]}}" aria-expanded="true" aria-controls="collapseOne{{$suppliersid[$i]}}" >
                                                                    {{$suppliersname[$i]}}
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOne{{$suppliersid[$i]}}" class="accordion-collapse collapse" aria-labelledby="headingOne{{$suppliersid[$i]}}" data-bs-parent="#accordionExample" >
                                                                <div class="accordion-body border-bottom">
                                                                    <div class="row row-cols-2">
                                                                        <div class="col">
                                                                            <div class="form-group">
                                                                            <input type="hidden" value="{{$suppliersid[$i]}}" name="pcode[]">
                                                                            <input type="hidden" value="{{$suppliersname[$i]}}" name="pname[]">
                                                                                <label class="form-label">Product Code</label>
                                                                                <input type="number" name="product_code[]" value="{{$productcodes[$i]}}" class="form-control ps-2" placeholder="45445">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Remarks</label>
                                                                                <input type="text" name="remarks[]" value="{{$remarks[$i]}}" class="form-control ps-2" placeholder="45445">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endfor 

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
                                <label class="form-label">Units Per Packet</label>
                                <input type="text" name="units_per_packet" class="form-control"placeholder="Enter units" value="{{$products->units_per_packet}}" required>
                                <!--select class="form-select" name="units_per_packet" aria-label="Default select example">
                                    <option selected>Select Units:</option>
                                    <option value="1" {{ $products->units_per_packet=="1"? 'selected':'' }} >1</option>
                                    <option value="2" {{ $products->units_per_packet=="2"? 'selected':'' }}>2</option>
                                    <option value="3" {{ $products->units_per_packet=="3"? 'selected':'' }}>3</option>
                                    <option value="4" {{ $products->units_per_packet=="4"? 'selected':'' }}>3</option>
                                </select-->
                                @error('units_per_packet')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
						<div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Size per unit</label>
                                <input type="text" name="sizeperunit" id="txtChar" onkeypress="return isNumberKey(event)" value="{{$products->sizeperunit}}" class="form-control" placeholder="Size per unit">
                                @error('sizeperunit')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
						<div class="col-lg-2">
                            <div class="form-group" style="margin-top: 39px;">
                                <select class="form-select" id="sq" name="area">
								  <option value="sq meter"{{ $products->area=="sq meter"? 'selected':'' }} >sq meter</option>
								  <option value="sq feet" {{ $products->area=="sq feet"? 'selected':'' }} >sq feet</option>
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
                                <label class="form-label">Description for Sale Invoice</label>
                                <input type="text" name="descriptions" value="{{$products->descriptions}}" class="form-control" placeholder="Description">
                                @error('descriptions')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Reorder quantity field</label>
                                <input type="number" name="reorder_qty" value="{{$products->reorder_qty}}" class="form-control" placeholder="Reorder quantity">
                                @error('reorder_qty')
                                 <span class="alert text-danger">{{ $message }}</span>
                               @enderror
                            </div> 
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Total Inventory</label>
                                <input type="number" name="total_inventry" value="{{$products->total_inventry}}" class="form-control" placeholder="Total Inventory">
                                <!-- @error('total_inventry')
                                 <div class="alert"><strong class="text-danger">{{ $message }}</strong></div>
                               @enderror -->
                            </div> 
                        </div>
                        
                    </div>
                    @if($products->p_image!=null)
                       


                       <div class="row" id="imghide">
                           <div class="col-12">
                               <div class="form-group user-img" style="height:50px;width:50px">
                               <a href="#" id="hideimg" data-id="{{$products->id}}"><i class="fa fa-times"></i></a>
                               <img src="{{asset('admin/productimage/'.$products->p_image)}}">
                               </div>
                           </div>
                       </div>
                      @endif
                       
                       @if($products->p_image!=null)
                       @php $style="display:none"; @endphp
                       @else
                       @php $style="display:block"; @endphp
                       @endif
                    <div class="row" id="imgshow" style="{{$style}}">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Photo</label>

                                <div class="upload">
                                    <input type="file" name="p_image" value="{{ $products->image }}" class="form-control " placeholder="" onchange="readURL(this);">
                                    <div class="upload-txt">
                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        <p>Click here or drag and drop files to upload</p>
										<img id="blah" src="#" alt="your image" />
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
                    </div>

                    
                    @error('p_image')
                                 <div class="alert"><strong class="text-danger">{{ $message }}</strong></div>
                               @enderror

                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn" >Update</button>
                        <button type="reset" class="btn btn-white">Clear</button>
                    </div>
                    <!--model-->
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
                <!--end-model-->
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

<script type="text/javascript">
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
	
$("#hideimg").click(function() {
   
 $("#imghide").hide();
 $("#imgshow").show();
 $("#hidetxt").show();
 var id = $('#hideimg').attr("data-id");
 $.ajax({
	 url: "/delete_img",
     type:"GET",
     data:{
     "_token": "{{ csrf_token() }}",
	  id:id,
      },
	  
})
});



$(document).on("click", ".modal-trigger", function () {
  var myspplierId = $(this).data('id');
  $(".supplierid").val(myspplierId);
  
  var myspplierId1 = $(this).data('id1');
  $(".supplier_name").val(myspplierId1);
  
});

$('#myModal').modal('toggle');

function add_more(){
       var html= '<div class="checkbox ">';
        
           html+= '<input type="text" name="dropdown_group[]" value="" id="checkbox-custom_1" />';
           html+= '<a href="javascript:vioid(0)" onclick="removeitem()">Remove</a>';
           html+= '</div>';
       jQuery('.add-skirting').append('<div id="appended_item">' +html+'</div>');
       
   }
   function removeitem(){
       var html= '<div class="checkbox">';
        
           html-= '<input type="text" name="dropdown_group[]" value="" id="checkbox-custom_1" />';
        
           html-= '</div>';
       jQuery('#appended_item').remove(html);
       
   
   }
</script>

@include("layouts.admin.footer")