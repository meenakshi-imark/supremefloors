@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow account">

            <div class="main-heading d-flex justify-content-between">
                <div class="main-titles">
                    <h1>
                    Activity Log
                    </h1>
                    <p>
                    The segment shows the logs of all activity in Supreme Floor ERP.
                    </p>
                </div>
                <div class="tabs-change">
                    <a href="javascript:void(0);" class="active">
                        <i class="la la-table"></i>
                        <span>Table</span>
                    </a>
                    <a href="javascript:void(0);">
                        <i class="la la-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </div>
            </div>
            <div class="filter">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-5" placeholder="Search Quotation">
                        <button type="button" class="btn me-5">Search</button>
                    </div>
                    <a href="javascript:void(0);" class="btn">
                        <i class="la la-filter"></i>
                        Filter
                    </a>
                </div>
            </div>

            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Account</th>
                            <th>Timestamp</th>
                            <th>Activity</th>
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
                            SM
                            </td>
                            <td>
                            30-05-2022
                            </td>
                            <td>
                            Changes Invoice Status
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
                            SM
                            </td>
                            <td>
                            30-05-2022
                            </td>
                            <td>
                            Changes Invoice Status
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
                            SM
                            </td>
                            <td>
                            30-05-2022
                            </td>
                            <td>
                            Changes Invoice Status
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
                            SM
                            </td>
                            <td>
                            30-05-2022
                            </td>
                            <td>
                            Changes Invoice Status
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
                            SM
                            </td>
                            <td>
                            30-05-2022
                            </td>
                            <td>
                            Changes Invoice Status
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
                            SM
                            </td>
                            <td>
                            30-05-2022
                            </td>
                            <td>
                            Changes Invoice Status
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
                            SM
                            </td>
                            <td>
                            30-05-2022
                            </td>
                            <td>
                            Changes Invoice Status
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
                            SM
                            </td>
                            <td>
                            30-05-2022
                            </td>
                            <td>
                            Changes Invoice Status
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