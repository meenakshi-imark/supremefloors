@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow account">

            <div class="main-heading">
                <h1>
                    Recent Stock Movement
                </h1>
                <p>
                    The segment shows the history of stock movement in Supreme Floor ERP.
                </p>
            </div>
            <div class="tab-btn d-flex my-5">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add-PO">+ Add Stock (PO)</a>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add-JO">+ Add Stock (JO)</a>
                <a href="javascript:void(0);">- Reduce Stock (RO)</a>
            </div>

            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Date</th>
                            <th>Sales Staff</th>
                            <th>Product</th>
                            <th>Stock (packet)</th>
                            <th>Pieces</th>
                            <th>PO #</th>
                            <th>JO #</th>
                            <th>RO #</th>
                            <th>Remarks</th>
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
                                KO
                            </td>
                            <td>
                                VL601A
                            </td>
                            <td>
                                -120
                            </td>
                            <td>
                                10
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                493213
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="la la-trash"></i>Delete</a></li>
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
                                JA
                            </td>
                            <td>
                                VL601A
                            </td>
                            <td>
                                +100
                            </td>
                            <td>
                                5
                            </td>
                            <td>
                                320324
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="la la-trash"></i>Delete</a></li>
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
                                KO
                            </td>
                            <td>
                                VL601A
                            </td>
                            <td>
                                -120
                            </td>
                            <td>
                                10
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                493213
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="la la-trash"></i>Delete</a></li>
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
                                KO
                            </td>
                            <td>
                                VL601A
                            </td>
                            <td>
                                -120
                            </td>
                            <td>
                                10
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                493213
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="la la-trash"></i>Delete</a></li>
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