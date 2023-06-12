@include('layouts.header')

<style>


</style>


<main id="main">




    <section class="sec-pd product-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">

                    <div class="product-menu">
                        <nav class="sidebar card">
                            <ul class="nav flex-column" id="nav_accordion">

                                <li class="nav-item has-submenu">
                                    <a class="nav-link" href="#">All Product <!--i class="fa fa-angle-right" aria-hidden="true"></i--></a>
                                    <!--ul class="submenu collapse">
                                        <li><a class="nav-link" href="#">Submenu item 4 </a></li>
                                        <li><a class="nav-link" href="#">Submenu item 5 </a></li>
                                        <li><a class="nav-link" href="#">Submenu item 6 </a></li>
                                        <li><a class="nav-link" href="#">Submenu item 7 </a></li>
                                    </ul-->
                                </li>

								@foreach($categories as $cat)
                                <li class="nav-item has-submenu">
                                    <a class="nav-link" href="?category={{$cat->id}}"> {{$cat->category_name}} <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </li>
								@endforeach


                            </ul>
                        </nav>
                    </div>

                </div>

                <div class="col-lg-9">
                    <div class="product-grid">
                        <div class="d-flex product-inner-grid">
							@foreach($products as $product)
                            <div class="product-box-grid">
                                <figure>
										@if($product->p_image==null)
                                        <img src="{{asset('uploads/no-image.png')}}"alt="img">
                                        @else
                                        <img src="{{asset('admin/productimage/'.$product->p_image)}}"alt="img">
                                        @endif
                                </figure>
                                <div class="txt">
                                    <h6>{{$product->product_name}}</h6>
									@php
									$name  = str_replace(' ', '-', $product->product_name).'-'.$product->id;
									@endphp
                                    <a class="btn" href="/product-detail/{{$name}}">Get Quotation</a>
                                </div>
                            </div>

							@endforeach
                            <hr>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="pop-up-product">
        <div class="overlay"></div>
        <div class="quick-popup">

            <div class="popup__close">
           <h6>X</h6>
            </div>
            <h2>Quotation Request Submitted</h2>
            <p>Thank you for requesting a quotation with Supreme Floor. Our Customer service will contact you with in 3 working days.</p>
        </div>
    </section>


</main>





@include('layouts.footer')