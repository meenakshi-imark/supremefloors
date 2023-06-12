@include('layouts.header')

<main id="main">


    <section class="sec-pd product-detail">
        <div class="container">
		    @if (\Session::has('success'))
        <div class="alert alert-success">{!! \Session::get('success') !!}</div>
		@endif
		@if (\Session::has('error'))
			<div class="alert alert-danger">{!! \Session::get('error') !!}
			</div>
		@endif
            <div class="row">
                <div class="col-lg-5">
                    <div class="figure">
					<figure>
					@if($products->p_image==null)
						<img src="{{asset('uploads/no-image.png')}}">
						@else
						<img src="{{asset('admin/productimage/'.$products->p_image)}}">
                        </figure>
						@endif
                        <h2>
						
						{{$products->product_name}}
                        </h2>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="txt">
                        <form method="post" action="/get-quotation">
						@csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Full Name</label>
										<input type="hidden" name="product_id" value="{{$products->id}}">
                                        <input type="text" class="form-control" placeholder="David Smith" name="fullname"required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Email address</label>
                                        <input type="email" class="form-control" placeholder="davidsmith@gmail.com" name="email"required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Phone Number</label>
                                        <input type="number" class="form-control" placeholder="+65-855-562-00" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" placeholder="545 Orchard Road #13-02 Far East Shopping Centre" name="address"  required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="form-label">Estimate Area</label>
                                                <input type="text" class="form-control" placeholder="0" required name="area" >
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="form-label">Size</label>
                                                <select class="form-select form-control" aria-label="Default select example" name="size">
                                                    <option selected>Select</option>
                                                    <option value="SQFT">SQFT</option>
                                                    <option value="SQM">SQM</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Estimate Tiles Required</label>
                                        <div class="estimate-tiles-required"><b>0</b></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row estimate-price">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <!--label class="form-label">Estimate Price</label>
                                        <h2><b>${{$products->min_cost}}</b></h2-->
                                        <div class="file-upload-grid">
                                            <input class="file-upload" type="file" id="formFile" name="file"/>
                                            <p><i class="fa fa-paperclip" aria-hidden="true"></i> Upload Floor Plan</p>
                                        </div>
                                        <span>
                                            If not you can do with a PDF file or as a JPG or PNG image file. File size less than 1 MB.
                                        </span>

                                    </div>
									<input type="submit" class="btn" value="Get Quotation">

                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>


@include('layouts.footer')