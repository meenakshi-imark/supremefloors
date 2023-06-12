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
        <div class="box-shadow account">

            <div class="main-heading">
                <h1>
                    All Products
                </h1>
                <p>
                    This segment shows the existing product in Supreme Floor ERP.
                </p>
            </div>
            <div class="to-btn d-flex">
                @foreach($categories as $cat)
                
                <a href="?category={{$cat->id}}">{{$cat->category_name}}</a>
                @endforeach
            </div>
			<form method="POST" action="/delete-all-products"> 
			<div id="selectval1">
			<button type="submit" class="btn me-5 mb-2">Delete</button>
			</div>
			@csrf
            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Select All <br>
							<input class="form-check-input" type="checkbox" id="ckbCheckAll" /></th>
                            <th>Product Pic</th>
                            <th>Product Name</th>
                            <th>Product ID</th>
                            <th>Min. Price</th>
                            <th>Description</th>
                            <th>Supplier Name</th>
                            <th>Supplier ID</th>
                            <th>Size Per Unit</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input selectid" type="checkbox" name="id[]" value="{{$product->id}}">
                                </label>
                            </td>
                            <td>
                                <figure class="mb-0">
                                     @if($product->p_image==null)
                                        <img src="{{asset('uploads/no-image.png')}}">
                                        @else
                                        <img src="{{asset('admin/productimage/'.$product->p_image)}}">
                                        @endif
                                </figure>
                            </td>
                            <td>
                               {{$product->product_name}}
                            </td>
                            <td>
                                {{$product->product_no}}
                            </td>
                            <td>
                                ${{$product->min_cost}}
                            </td>
                            <td>
							@if (strlen($product->descriptions) > 30)
							@php $descriptions = substr($product->descriptions, 0, 30) . '...'; @endphp
							@else 
							@php $descriptions = $product->descriptions; @endphp
							@endif
                                {{$descriptions}}
                            </td>
                            <td>
                                @php 
                                echo str_replace(",","<br>",$product->supplier_name);
                                @endphp
                            </td>
                            <td>
                                @php echo str_replace(",","<br>",$product->supplier_id); @endphp</td>
							<td>
							{{$product->sizeperunit}} {{$product->area}}
							</td>
                            <td>
                                <select class="form-select" id="mySelect" aria-label="Default select example" onchange="location = this.value;" >
                                    <option @if($product->status=="1") selected @endif value="/change-status/{{$product->id}}">Enable</option>
                                    <option @if($product->status=="2") selected @endif value="/change-status/{{$product->id}}">Disable</option>
                                </select>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/product-edit-product/{{$product->id}}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="/delete-product/{{$product->id}}"><i class="la la-trash"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
					</table>
            </div>
			</form>
			
            {!! $products->render() !!}
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