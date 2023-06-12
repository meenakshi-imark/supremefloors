<section class="pop-up-product">
    <div class="overlay"></div>
    <div class="quick-popup">

        <div class="popup__close">
            <h6 class="cancel">X</h6>
        </div>
        <figure>
            <img src="{{asset('admin/images/ok.png')}}" alt="icn">
        </figure>
        <p id="replacetxt">Successful.</p>
    </div>
</section>

<div class="modal modal-view fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vinly Flooring</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Available Colours</h6>

                <div class="row row-cols-md-4 row-cols-2">
                    <div class="col">
                        <div class="card">
                            <img src="{{asset('admin/images/pr-1.png')}}" class="card-img-top" alt="image">
                            <div class="card-body">
                                <p>VL601A SNOWY VENUS</p>
                                <span>#789784</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{asset('admin/images/pr-2.png')}}" class="card-img-top" alt="image">
                            <div class="card-body">
                                <p>VL604 VINTAGE PLUTO</p>
                                <span>#988793</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{asset('admin/images/pr-3.png')}}" class="card-img-top" alt="image">
                            <div class="card-body">
                                <p>VL605A SANTA MERCURY</p>
                                <span>#227832</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{asset('admin/images/pr-4.png')}}" class="card-img-top" alt="image">
                            <div class="card-body">
                                <p>VL607 FRENCH NEPTUNE</p>
                                <span>#865786</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{asset('admin/images/pr-5.png')}}" class="card-img-top" alt="image">
                            <div class="card-body">
                                <p>VL608A BRONZE EARTH</p>
                                <span>#896221</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{asset('admin/images/pr-6.png')}}" class="card-img-top" alt="image">
                            <div class="card-body">
                                <p>VL610 OPAL GREY</p>
                                <span>#127546</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{asset('admin/images/pr-7.png')}}" class="card-img-top" alt="image">
                            <div class="card-body">
                                <p>VL609 YELLOW SUN</p>
                                <span>#253789</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{asset('admin/images/pr-8.png')}}" class="card-img-top" alt="image">
                            <div class="card-body">
                                <p>VL612A GREY STORM</p>
                                <span>#962247</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- add PO -->
<div class="modal fade add-po" id="add-PO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Stock (PO)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="form-group">
                    <label>PO Number:</label>
                    <div class="searching ms-3">
                        <i class="la la-search"></i>
                        <input type="number" class="form-control ps-5" placeholder="Search PO Number">
                    </div>
                </div>
                <div class="add-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Stock Ordered (packet)</th>
                                <th>Stock Arrived (packet)</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>VL601A</td>
                                <td>100</td>
                                <td><input type="number" class="form-control w-25" placeholder="100"></td>
                                <td><input type="text" class="form-control" placeholder=""></td>
                            </tr>
                            <tr>
                                <td>VL601A</td>
                                <td>100</td>
                                <td><input type="number" class="form-control w-25" placeholder="100"></td>
                                <td><input type="text" class="form-control" placeholder="Lorem ipsum dolor sit amet, sed"></td>
                            </tr>
                            <tr>
                                <td>VL601A</td>
                                <td>100</td>
                                <td><input type="number" class="form-control w-25" placeholder="100"></td>
                                <td><input type="text" class="form-control" placeholder=""></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex btn-grid">
                <button type="submit" class="btn">Update Stock</button>
            </div>
        </div>
    </div>
</div>

<!-- add JO -->
<div class="modal fade add-po" id="add-JO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Stock (JO)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="form-group">
                    <label>JO Number:</label>
                    <div class="searching ms-3">
                        <i class="la la-search"></i>
                        <input type="number" class="form-control ps-5" placeholder="Search JO Number">
                    </div>
                </div>
                <div class="add-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Stock Arrived (packet)</th>
                                <th>Stock Arrived (pieces)</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>VL601A</td>
                                <td>
                                    <input type="number" class="form-control w-25" placeholder="100">
                                </td>
                                <td>
                                    <input type="number" class="form-control w-25" placeholder="100">
                                </td>
                                <td><input type="text" class="form-control" placeholder=""></td>
                            </tr>
                            <tr>
                                <td>VL601A</td>
                                <td>
                                    <input type="number" class="form-control w-25" placeholder="100">
                                </td>
                                <td><input type="number" class="form-control w-25" placeholder="100"></td>
                                <td><input type="text" class="form-control" placeholder="Lorem ipsum dolor sit amet, sed"></td>
                            </tr>
                            <tr>
                                <td>VL601A</td>
                                <td>
                                    <input type="number" class="form-control w-25" placeholder="100">
                                </td>
                                <td><input type="number" class="form-control w-25" placeholder="100"></td>
                                <td><input type="text" class="form-control" placeholder=""></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex btn-grid">
                <button type="submit" class="btn">Update Stock</button>
            </div>
        </div>
    </div>
</div>

<!-- Reduce RO -->
<div class="modal fade add-po" id="Reduce-RO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reduce Stock (RO)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="form-group">
                    <label>RO Number:</label>
                    <div class="searching ms-3">
                        <i class="la la-search"></i>
                        <input type="number" class="form-control ps-5" placeholder="Search RO Number">
                    </div>
                </div>
                <div class="add-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Stock Delivered (packet)</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>VL601A</td>
                                <td>
                                    <input type="number" class="form-control w-25" placeholder="100">
                                </td>
                                <td><input type="text" class="form-control" placeholder=""></td>
                            </tr>
                            <tr>
                                <td>VL601A</td>
                                <td>
                                    <input type="number" class="form-control w-25" placeholder="100">
                                </td>
                                <td><input type="text" class="form-control" placeholder="Lorem ipsum dolor sit amet, sed"></td>
                            </tr>
                            <tr>
                                <td>VL601A</td>
                                <td>
                                    <input type="number" class="form-control w-25" placeholder="100">
                                </td>
                                <td><input type="text" class="form-control" placeholder=""></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex btn-grid">
                <button type="submit" class="btn">Update Stock</button>
            </div>
        </div>
    </div>
	</div>

<!-- not-assign-sheet -->

<div class="modal fade not-assign-it" id="not-assign-select" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h2 class="modal-title text-center" id="staticBackdropLabel">Select Delivery Date</h2>
            <div class="modal-body">
                <div class="cal-month d-flex">
                    <a href="javascript:void(o);" class="me-3"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                    <h5>January 2022</h5>
                    <a href="javascript:void(o);" class="ms-3"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                <div class="assign-cla-data row row-cols-5">
                    <div class="dates">
                        <p>Mon<br>7</p>
                        <ul>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="dates">
                        <p>Tue<br>8</p>
                        <ul>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="dates">
                        <p>Wed<br>9</p>
                        <ul>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="dates">
                        <p>Thu<br>10</p>
                        <ul>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="dates">
                        <p>Fri<br>11</p>
                        <ul>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="date-order">
                                    <div class="driver w-100">
                                        <p class="mb-2"><b>Driver 1</b></p>
                                        <p>East <br>North East <br>Central</p>
                                    </div>
                                    <div class="select w-100">
                                        <div class="form-group w-100">
                                            <label>Select</label>
                                            <input type="radio" name="select1">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="d-flex btn-grid mx-auto">
                <button type="submit" class="btn" id="create">Create</button>
                <button type="submit" class="btn btn-white">Clear</button>
            </div>
        </div>
    </div>
</div>
<?php 
$uri =url()->current();
$arr = explode('/',$uri);
	// print_r($arr);exit();
?>

<script src="{{asset('admin/js/bundle.min.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{asset('admin/js/dashboard.js')}}"></script>	

<script>
$(".cancel").click(function() {
location.reload();
});
</script>

</body>

</html>