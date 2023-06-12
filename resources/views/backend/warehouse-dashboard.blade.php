@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow account">

            <div class="main-heading">
                <div class="main-titles">
                    <h1>
                        Warehouse Dashboard
                    </h1>
                    <p>
                        The segment shows the information related to warehouse captured in Supreme Floor ERP. These numbers are accumulated weekly.
                    </p>
                </div>
                <div class="row my-5 gx-72">
                    <div class="col-md-4">
                        <div class="complete-delivery">
                            <div class="cd-head">
                                <h4>Completed Delivery</h4>
                            </div>
                            <div class="cd-data">
                                <div class="img-chat">
                                    <figure>
                                        <img src="{{asset('admin/images/chat.png')}}">
                                    </figure>
                                    <p>11 <span>/14</span></p>
                                </div>
                            </div>
                            <table>
                                <tr>
                                    <td><span style="background-color: #FFA02F;"></span></td>
                                    <td><b>Pending/Delayed</b></td>
                                    <td><b>3</b></td>
                                </tr>
                                <tr>
                                    <td><span style="background-color: #13582E;"></span></td>
                                    <td><b>Completed</b></td>
                                    <td><b>11</b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row row-cols-1 h-100">
                            <div class="abt-del">
                                <h5>Pending Delivery</h5>
                                <h2>2</h2>
                            </div>
                            <div class="abt-del">
                                <h5>Delayed</h5>
                                <h2>1</h2>
                            </div>
                            <div class="abt-del">
                                <h5>Total Delivery</h5>
                                <h2>14</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="complete-delivery">
                            <div class="cd-head">
                                <h4>Recent Update</h4>
                            </div>
                            <div class="cd-data">
                                <ul class="p-3">
                                    <li>30-05-2022<br><span>Delivery 3232930 is picked up</span></li>
                                    <li>30-05-2022<br><span>Delivery 3232930 is picked up</span></li>
                                    <li>30-05-2022<br><span>Delivery 3232930 is picked up</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-for my-3">
                <h4>Today's Delivery</h4>
            </div>
            <div class="all-tabel table-responsive mb-5">
                <table>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Delivery ID</th>
                            <th>Driver</th>
                            <th>Postal Code</th>
                            <th>RO</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                </label>
                            </td>
                            <td>
                                392433
                            </td>
                            <td>
                                Ming Xuan
                            </td>
                            <td>
                                493424
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn">View</a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-pencil-square-o" aria-hidden="true"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-trash"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                </label>
                            </td>
                            <td>
                                392433
                            </td>
                            <td>
                                Ming Xuan
                            </td>
                            <td>
                                493424
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn">View</a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-pencil-square-o" aria-hidden="true"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-trash"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                </label>
                            </td>
                            <td>
                                392433
                            </td>
                            <td>
                                Ming Xuan
                            </td>
                            <td>
                                493424
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn">View</a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-pencil-square-o" aria-hidden="true"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-trash"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                </label>
                            </td>
                            <td>
                                392433
                            </td>
                            <td>
                                Ming Xuan
                            </td>
                            <td>
                                493424
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn">View</a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-pencil-square-o" aria-hidden="true"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-trash"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-for my-3">
                <h4>This Week's Delivery</h4>
            </div>
            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Installation Date</th>
                            <th>Delivery ID</th>
                            <th>Driver</th>
                            <th>Postal Code</th>
                            <th>RO</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                </label>
                            </td>
                            <td>
                                30-05-2022
                            </td>
                            <td>
                                392433
                            </td>
                            <td>
                                Ming Xuan
                            </td>
                            <td>
                                493424
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn">View</a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-pencil-square-o" aria-hidden="true"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-trash"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                </label>
                            </td>
                            <td>
                                30-05-2022
                            </td>
                            <td>
                                392433
                            </td>
                            <td>
                                Ming Xuan
                            </td>
                            <td>
                                493424
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn">View</a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-pencil-square-o" aria-hidden="true"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-trash"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                </label>
                            </td>
                            <td>
                                30-05-2022
                            </td>
                            <td>
                                392433
                            </td>
                            <td>
                                Ming Xuan
                            </td>
                            <td>
                                493424
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn">View</a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-pencil-square-o" aria-hidden="true"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-trash"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                </label>
                            </td>
                            <td>
                                30-05-2022
                            </td>
                            <td>
                                392433
                            </td>
                            <td>
                                Ming Xuan
                            </td>
                            <td>
                                493424
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn">View</a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-pencil-square-o" aria-hidden="true"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{url('release-invoice')}}">
                                                <i class="la la-trash"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@include("layouts.admin.footer")