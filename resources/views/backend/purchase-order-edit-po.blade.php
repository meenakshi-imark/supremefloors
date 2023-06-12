@include("layouts.admin.header")
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script>
	$(document).ready(function(){  
	
	 // document.querySelectorAll('.testimonial').forEach(function (element, index) {
		// const box = document.querySelector('.testimonial');
		 // box[index].setAttribute('id', 'test1' + index);
		// element.innerHTML = 'Testimonial ' + (index + 1);
		// element.attr("id", +index + 1);
		// });
	

	 $('#addmore').click(function(e) {  
	 var numItems = $('.price').length;
     $("#append").append('<div class="row row-cols-md-5" >'+
                        '<div class="col">'+
                            '<div class="form-group form-select-group w-100">'+
                                '<label class="form-label">Product</label>'+
								'<select class="form-select pro-select1"  aria-label="Default select example" name="product[]" >'+
									'<option value="">Select</option>'+
									@foreach($products as $p)
                                    '<option value="{{$p->id}}">{{$p->product_name}}</option>'+
									@endforeach
									'</select>'+
                            '</div>'+
                        '</div>'+
						'<div class="col">'+
                            '<div class="form-group form-select-group w-100">'+
                                '<label class="form-label">Unit</label>'+
                                '<select class="form-select" aria-label="Default select example" name="unit[]" required>'+
                                    '<option value="SQFT">SQFT</option>'+
                                    '<option value="SQM">SQM</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Unit Price</label>'+
                                '<input type="text" class="form-control price" value="" id="price'+numItems+'"name="unitprice[]"  required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Quantity</label>'+
                                '<input type="number" id="quantity1'+numItems+'" name="quantity[]" class="form-control quantity1" placeholder="2" required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Price</label>'+
                                '<input type="text" id="totalprice1'+numItems+'" name="price[]" class="form-control totalprice" placeholder="$1000.00"  required >'+
                            '</div>'+
                        '</div>'+
						'<div>');  
    });  
	

$(document).on('change', '.pro-select1', function() {
  var pid = $(this).val();
  var numItems = $('.price').length;
  var classname = numItems-1 ;
  var newclass = "#price"+classname;
  var quantity = "#quantity1"+classname;
  var totalprice = "#totalprice1"+classname;	 
  
  $.ajax({
         url: "/get-price",
         type: 'GET',
         data: { pid : pid },
	     success:function(data){
			$(newclass).attr("value", '$'+data); 
		}
        });	
		
  $(quantity).on("keyup change", function(e) {
    var price = $(newclass).val();
    var quantity =   this.value;
	 $.ajax({
            url: "/total-price",
            type: 'GET',
            data: { price : price,quantity:quantity },
			success:function(data){
			 $(totalprice).attr("value", '$'+data);
				var sum = 0;
				$("input[class *= 'totalprice']").each(function(){
					var avoid = "$";
					var value = $(this).val();
					// var price1 = $('#totalprice').val();
					var newval = value.replace(avoid, '');
					// var totalval=price1.replace(avoid, '');
					// var newtotal = parseInt(totalval, 10)+parseInt(newval,10);
					sum += +newval;
					// var total = sum+parseInt(totalval,10);
					// alert(total);
					$('#total_price').attr("value", sum);
				});

			}
       }); 
	
});

});
});  



	</script>
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
                    Edit Purchase Order
                </h1>
                <p>
                    This segment is to edit Purchase Order
                </p>
            </div>

            <div class="form mw-100">
                <form method="POST" action="/update-purchase-order">
				@csrf
                    <div class="row row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Purchase Order Number</label>
                                <input type="text" class="form-control"  name="ordernumber" value="#{{$orders->order_no}}" readonly>
                                <input type="hidden" class="form-control"  name="id" value="{{$orders->id}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Supplier</label>
                                <div class="search-it">
                                    <i class="la la-search"></i>
                                    <select class="form-select" aria-label="Default select example" name="supplier" required>
										@foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}" @if($supplier->id==$orders->supplier_id) selected @endif>{{$supplier->person_name}}</option>
										@endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
					@for($i=0;$i<count($arr['products']);$i++)
						
                    <div class="row row-cols-md-5 row-cols-1">
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Product</label>
								
                               <select class="form-select pro-select pro{{$i}}"  aria-label="Default select example" name="product[]" required>
								 @foreach($products as $p)
                                    <option value="{{$p->id}}" @if($p->id== $arr['products'][$i]) selected @endif>{{$p->product_name}}</option>
								@endforeach
                                </select>
                            </div>
                        </div>
												
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Unit</label>
                                <select class="form-select" aria-label="Default select example" name="unit[]" required>
                                    <option value="SQFT" @if($arr['unit'][$i]=="SQFT") selected @endif>SQFT</option>
                                    <option value="SQM" @if($arr['unit'][$i]=="SQM") selected @endif>SQM</option>
                                </select>
                            </div>
                        </div>
						
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Unit Price</label>
                                <input type="text" id="price1{{$i}}"class="form-control price1" name="unitprice[]" value="${{$arr['unitprice'][$i]}}" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="text" id="quantity{{$i}}" name="quantity[]" class="form-control quantity" value="{{$arr['quantity'][$i]}}" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Price</label>
                                <input type="text" id="totalprice{{$i}}" name="price[]" class="form-control totalprice" placeholder="$1000.00" value="${{$arr['price'][$i]}}" required>
                            </div>
                        </div>
						
                    </div>
					@endfor
					
					<div class="row" >
					<div class="input_fields_wrap form-group">
						<a id="addmore">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            Add More Fields
                        </a>
					</div>
					</div>
					
					<div id="append">
						
					</div>
                    <div class="prices">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <h6>Estimated days before Arrival:</h6>
                                    </td>
                                    <td>
                                        <div class="fill-days">
                                            <input type="number" class="form-control" name="days" value="{{$orders->days_before_arrival}}" required>
                                            <span>days</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>Estimated Arrival:</h6>
                                    </td>
                                    <td>
										<div class="fill-days" ><input type="date" name="date" style="max-width:fit-content;" class="form-control" required value="{{$orders->estimated_arrival}}"></div></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>Total Price:</h6>
										
                                    </td>
                                    <td><input type="text" id="total_price" name="totalprice"style="border: none;" value="${{$orders->total_price}}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn">Update</button>
                        <button type="reset" class="btn btn-white">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	
<script type="text/javascript">
$(document).on("keyup change", ".totalprice", function() {
    var sum = 0;
    $("input[class *= 'totalprice']").each(function(){
		var avoid = "$";
		var value = $(this).val();
		var newval = value.replace(avoid, '');
        sum += +newval;
		$('#total_price').attr("value", sum);
    });
    // $(".total1").val(sum);
	 // var price = $('#totalprice').val();
	 
});



$('.pro-select').change(function(){ 

var pid = $(this).val();
// var price = $('.price1').length;
// var classname = price-2 ;
// var price1 = "#price1"+classname;

var numItems = $('.price1').length;
var classname = numItems-2 ;
var newclass = "#price1"+classname;
var quantity = "#quantity"+classname;
var totalprice = "#totalprice"+classname;



  $.ajax({
           url: "/get-price",
           type: 'GET',
           data: { pid : pid },
		   success:function(data){
		   $(newclass).attr("value", '$'+data);
			}
          });
});
	
    var path = "{{ route('autocomplete') }}";
	
  	$(document).on('keyup change', '.search1', function() {
		   $("#search1" ).autocomplete({
		 source: function( request, response ) {
			 
			 }   
      
			});
	
		});
  
/*     $( ".search" ).autocomplete({
	
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
           $('.search').val(ui.item.label);
		   $(".productid").val(ui.item.id);
		    $.ajax({
            url: "/get-price",
            type: 'GET',
            data: { pid : ui.item.id },
			success:function(data){
			 $('#price').attr("value", '$'+data);
			}
          });
           return false;
        }
      });
	   */
	   
$(".quantity").on("keyup change", function(e) {	   
 var quantityy = $('.quantity').length;
 var classname = quantityy-2 ;
 var qty = "#quantity"+classname;
 var totalprice = "#totalprice"+classname;
 var price1 = "#price1"+classname;
 
  $(qty).on("keyup change", function(e) {

    var price = $(price1).val();
    var quantity =   this.value;

	 $.ajax({
            url: "/total-price",
            type: 'GET',
            data: { price : price,quantity:quantity },
			success:function(data){
			 $(totalprice).attr("value", '$'+data);

			}
       }); 
	});
})
</script>


@include("layouts.admin.footer")