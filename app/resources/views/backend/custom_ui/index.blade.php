@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('styles')
    <link rel="stylesheet" href="{{ asset('/public/backend/css/custom-ui.css') }}">
@section('content')
<div class="content-wrapper dashboard-wrapper mt-30">
    <div class=" mt-5">

        <div class="my-5">
            {{-- pop up modal --}}

            <a href="#" type="button" class="btn btn-sm btn-success" data-toggle="modal"
                data-target="#successModal">Success</a>
            <a href="#" type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                data-target=".confirm-delete">Delete</a>
            <a href="#" type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                data-target="#warningModal">Warning</a>
            <a href="#" type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#errorModal">Error</a>

        </div>

        <!-- Basic Modal -->
        {{-- <div class="modal fade custom-modal custom-success-modal" id="successModal" tabindex="-1" role="dialog"
                aria-labelledby="successModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="svg-container">
                                <svg>
                                    <circle class="bg" cx="57" cy="57" r="52" />
                                    <circle class="modal-progress-circle" cx="57" cy="57" r="40" />
                                </svg>
                                <i class="fas fa-check" aria-hidden="true"></i>
                            </div>
                            <div class="text-container">
                                <h3>Successful</h3>
                                <p>Something happend Succesffully?</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div> --}}

        {{-- <div class="modal fade custom-modal custom-delete-modal confirm-delete" id="deleteModal" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="svg-container">
                                <svg>
                                    <circle class="bg" cx="57" cy="57" r="52" />
                                    <circle class="modal-progress-circle" cx="57" cy="57" r="40" />
                                </svg>
                                <i class="fas fa-trash" aria-hidden="true"></i>
                            </div>
                            <div class="text-container">
                                <h3>Delete</h3>
                                <p>Do you want to delete it?</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-danger">Confirm</button>
                        </div>
                    </div>
                </div>
            </div> --}}
        {{-- <div class="modal fade custom-modal custom-warning-modal" id="warningModal" tabindex="-1" role="dialog"
                aria-labelledby="warningModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="svg-container">
                                <svg>
                                    <circle class="bg" cx="57" cy="57" r="52" />
                                    <circle class="modal-progress-circle" cx="57" cy="57" r="40" />
                                </svg>
                                <i class="fas fa-exclamation" aria-hidden="true"></i>
                            </div>
                            <div class="text-container">
                                <h3>Update</h3>
                                <p>OTP required in update</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div> --}}

        {{-- <div class="modal fade custom-modal custom-error-modal" id="errorModal" tabindex="-1" role="dialog"
                aria-labelledby="errorModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="svg-container">
                                <svg>
                                    <circle class="bg" cx="57" cy="57" r="52" />
                                    <circle class="modal-progress-circle" cx="57" cy="57" r="40" />
                                </svg>
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </div>
                            <div class="text-container">
                                <h3>Oppsss</h3>
                                <p>Something went wrong!</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div> --}}

        <!-- Date range picker -->
        <button class="btn btn-sm btn-primary daterange">Joining Date</button>
        {{-- <input type="text" class="daterange" name="daterange" value="01/01/2018 - 01/15/2018" hidden/> --}}



        {{-- Button List --}}

        {{-- Primary --}}

        <a href="#" class="btn btn-sm btn-primary">Primary</a>

        {{-- Success --}}

        <a href="#" class="btn btn-sm btn-success">Success</a>

        {{-- Danger --}}

        <a href="#" class="btn btn-sm btn-danger">Danger</a>
        <a href="#" class="btn btn-sm btn-light">Light</a>
        <br>

        {{-- End --}}

        {{-- Badge Large List --}}
        <div class="mt-3">
            {{-- Primary --}}

            <span href="#" class="badge py-3 px-4 fs-7 badge-light-primary">Primary</span>

            {{-- Success --}}

            <span href="#" class="badge py-3 px-4 fs-7 badge-light-success">Success</span>

            {{-- Danger --}}

            <span href="#" class="badge py-3 px-4 fs-7 badge-light-danger">Danger</span>

            {{-- Warning --}}

            <span href="#" class="badge py-3 px-4 fs-7 badge-light-warning">warning</span>
        </div>
        {{-- End --}}

        {{-- Badge Small List --}}
        <div class="mt-3">
            {{-- Primary --}}

            <span href="#" class="badge badge-light-primary">Primary</span>

            {{-- Success --}}

            <span href="#" class="badge badge-light-success">Success</span>

            {{-- Danger --}}

            <span href="#" class="badge badge-light-danger">Danger</span>

            {{-- Warning --}}

            <span href="#" class="badge badge-light-warning">warning</span>
        </div>
        {{-- End --}}

        {{-- Checkbox --}}
        <div class="mt-3">
            <div class="form-check form-check-custom form-check-solid text-gray-700 ">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked="checked" />
                <label class="form-check-label" for="flexCheckChecked">
                    Checked checkbox
                </label>
            </div>
        </div>
        {{-- end --}}

        {{-- Radio button --}}
        <div class="mt-3">
            <div class="form-check form-check-custom form-check-solid text-gray-700 ">
                <input class="form-check-input" type="radio" value="" id="flexRadioChecked" checked="checked" />
                <label class="form-check-label" for="flexRadioChecked">
                    Checked radio
                </label>
            </div>
        </div>

        {{-- end --}}

        {{-- Form --}}
        <div class="mt-3">
            <div class="did-floating-label-content">
                <input class="did-floating-input" type="text" placeholder=" ">
                <label class="did-floating-label">Sale Price</label>
            </div>
            {{-- Input field --}}
            <div class="form-floating mb-3">
                <input type="email" class="form-control label-color" id="floatingInput2" placeholder="name@example.com"
                    value="" />
                <label for="floatingInput">Valid input</label>
            </div>
            <!--Select Option-->
            <div class="form-floating mb-3">
                {{-- <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select> --}}
                <div class="ding">
                    <select class="search-selector" id="multiple">
                        <option value="1" selected>Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <select class="search-selector-multple mt-3" multiple id="multiple">
                        <option value="1" selected>Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>
            </div>
            <ul class="list-style-none">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown"
                        class="dropdown-toggle btn btn-soft-white table-box-shadow border-radius-20 dropdown-val-show">Dropdown
                        Form<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="form-check form-check-custom form-check-solid text-gray-700 ">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked"
                                    checked="checked" />
                                <label class="form-check-label" for="flexCheckChecked">
                                    Checked checkbox
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check form-check-custom form-check-solid text-gray-700 ">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked"
                                    checked="checked" />
                                <label class="form-check-label" for="flexCheckChecked">
                                    Checked checkbox
                                </label>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            <!--Valid Input-->
            <div class="form-floating mb-3">
                <input type="email" class="form-control is-valid" id="floatingInput2" placeholder="name@example.com"
                    value="test@example.com" />
                <label for="floatingInput">Valid input</label>
            </div>


            <!--Invalid Input -->
            <div class="form-floating">
                <input type="password" class="form-control is-invalid" id="floatingPassword2" placeholder="name@example.com"
                    value="test@example.com" />
                <label for="floatingPassword">Invalid input</label>
                <span class="error text-danger">your input is invalid </span>
            </div>
            <!--Text area-->
            <div class="form-floating mb-7">
                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                <label for="floatingTextarea">Comments</label>
            </div>
        </div>
        <div class="mt-3">
            <input type="file" id="brand_logo" />
            <label for="brand_logo" class="btn-2"><i class="fas fa-cloud-upload-alt"></i> Upload File</label>
            <div class="custom-image-upload-wrapper d-flex justify-center">
                <div class="image-area"><img id="imgPreview" src="" class="img-fluid mx-auto my-auto">
                </div>

            </div>
        </div>
        {{-- preloader --}}
        <div class="dots-container">
            <div class="pulse-dot-white pulse-dot-1"></div>
            <div class="pulse-dot-white pulse-dot-2"></div>
            <div class="pulse-dot-white pulse-dot-3"> </div>
        </div>

        {{-- end --}}
        {{-- Drag Drop --}}
        <div class="mt-3">
            <div action="/" method="post" class="dropzone" id="my-awesome-dropzone">

            </div>
        </div>
        <div class="mt-3">

        </div>
        <ul class="list-style-none mb-0">
            <li class="dropdown">
                <a href="#" data-toggle="dropdown"
                    class=" btn btn-soft-white table-box-shadow border-radius-10 border-none custom-btn d-flex align-items-center justify-content-center">Gender</a>
                <ul class="dropdown-menu mw-350 pt-3 pb-3">
                    <li>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-check-custom form-check-solid text-gray-700 ">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked"
                                        checked="checked" />
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Male
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-check-custom form-check-solid text-gray-700 ">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked"
                                        checked="checked" />
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Female
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-custom form-check-solid text-gray-700 ">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked"
                                        checked="checked" />
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Others
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center pl-20">
                            <p class="mb-0 text-gray-600">Clear</p>
                            <div class="pr-20">
                                <button class="btn btn-sm btn-primary custom-btn pr-20">Apply</button>
                            </div>
                        </div>
                    </li>
                </ul>

            </li>
        </ul>
        <div class="mt-3">
            <ul class="list-style-none mb-0">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown"
                        class=" btn btn-soft-white table-box-shadow border-radius-10 border-none custom-btn d-flex align-items-center justify-content-center">Products</a>
                    <ul class="dropdown-menu mw-350 pt-3 pb-3">
                        <div class="range-slider">
                            <input value="25000" min="0" max="120000" step="500" type="range" />
                            <input value="50000" min="0" max="120000" step="500" type="range" />
                            <div class="d-flex justify-content-between align-items-center">
                                <input type="number" value="25000" min="0" max="120000" />
                                <div class="dashed">
                                </div>
                                <input type="number" value="50000" min="0" max="120000" />
                            </div>
                        </div>
                        <li>
                            <hr>
                            <div
                                class="d-flex justify-content-between align-items-center pl-20">
                                <p class="mb-0 text-gray-600">Clear</p>
                                <div class="pr-20">
                                    <button
                                        class="btn btn-sm btn-primary custom-btn pr-20">Apply</button>
                                </div>
                            </div>
                        </li>
                    </ul>

                </li>
            </ul>
        </div>

        {{-- end --}}

        {{-- Basic Table --}}
        <div class="mt-3">
            <div class="card card-table-ui">
                <div class="card-header card-table-header pt-7 border-bottom-none row">
                    <h3 class="card-title col-md-3">
                        <span class="card-label fw-bolder text-gray-800">Product Orders</span> <br>
                        <span class="text-gray-400 mt-1 fw-bold">Avg. 57 orders per day</span>
                    </h3>
                    <div class="col-md-9">
                        <!--begin::Filters-->
                        <div class="row align-items-center">
                            <!--begin::Destination-->
                            <div class="col-md-8">
                                <!--begin::Label-->
                                <!--end::Label-->
                                <!--begin::Select-->
                                <div class="row">
                                    <div class="col-sm-6 col-12">
                                        <select class="form-select border-none fw-bolder w-auto" id="category"
                                            aria-label="Floating label select example">
                                            <option selected>Show All</option>
                                            <option value="1">Category A</option>
                                            <option value="2">Category B</option>
                                            <option value="3">Category C</option>
                                        </select>
                                    </div>
                                    <!--end::Select-->
                                    <div class="col-sm-6 col-12">
                                        <!--begin::Label-->
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select class="form-select fw-bolder border-none w-auto" id="status"
                                            aria-label="Floating label select example">
                                            <option selected>Show All</option>
                                            <option value="1">Shipped</option>
                                            <option value="2">Confirmed</option>
                                            <option value="3">Pending</option>
                                            <option value="4">Rejected</option>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Destination-->
                            <!--begin::Status-->
                            <!--end::Status-->
                            <!--begin::Search-->
                            <div class="position-relative my-1 col-md-4">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-2 position-absolute top-50 translate-middle-y ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                            transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" data-kt-table-widget-4="search" class="form-control  fs-7 ps-12"
                                    placeholder="Search">
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Filters-->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-3 dataTable no-footer">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="text-gray-400">Order ID</th>
                                    <th class="text-gray-400">Created</th>
                                    <th class="text-gray-400">Customer</th>
                                    <th class="text-gray-400">Total</th>
                                    <th class="text-gray-400">Profit</th>
                                    <th class="text-gray-400">Status</th>
                                    <th class="text-gray-400">Action</th>

                                </tr>
                            </thead>
                            <tbody class="fw-bolder fs-5 ">
                                <tr class="odd position-relative">
                                    <td>
                                        <a href="/metronic8/demo1/../demo1/apps/ecommerce/catalog/edit-product.html"
                                            class="text-gray-800 text-hover-primary">#XGY-346</a>
                                    </td>
                                    <td class="">7 min ago</td>
                                    <td class="">
                                        <a href="#" class=" text-hover-primary">Albert Flores</a>
                                    </td>
                                    <td class="">$630.00</td>
                                    <td class="">
                                        <span class="text-gray-800 fw-boldest">$86.70</span>
                                    </td>
                                    <td class="">
                                        <span class="badge py-3 px-4 fs-7 badge-light-warning">Pending</span>
                                    </td>
                                    <td class="action-dot">
                                        <div class="rounded-circle light-blue" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <a href="">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                            <li><a class="dropdown-item" href="#">Published</a></li>
                                            <li><a class="dropdown-item" href="#">Unpublished</a></li>
                                        </ul>

                                    </td>
                                </tr>
                                <tr class="odd position-relative">
                                    <td>
                                        <a href="/metronic8/demo1/../demo1/apps/ecommerce/catalog/edit-product.html"
                                            class="text-gray-800 text-hover-primary">#XGY-346</a>
                                    </td>
                                    <td class="">7 min ago</td>
                                    <td class="">
                                        <a href="#" class=" text-hover-primary">Albert Flores</a>
                                    </td>
                                    <td class="">$630.00</td>
                                    <td class="">
                                        <span class="text-gray-800 fw-boldest">$86.70</span>
                                    </td>
                                    <td class="">
                                        <span class="badge py-3 px-4 fs-7 badge-light-success">Success</span>
                                    </td>
                                    <td class="action-dot">
                                        <div class="rounded-circle light-blue" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <a href="">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                            <li><a class="dropdown-item" href="#">Published</a></li>
                                            <li><a class="dropdown-item" href="#">Unpublished</a></li>
                                        </ul>

                                    </td>
                                </tr>
                                <tr class="odd position-relative">
                                    <td>
                                        <a href="/metronic8/demo1/../demo1/apps/ecommerce/catalog/edit-product.html"
                                            class="text-gray-800 text-hover-primary">#XGY-346</a>
                                    </td>
                                    <td class="">7 min ago</td>
                                    <td class="">
                                        <a href="#" class=" text-hover-primary">Albert Flores</a>
                                    </td>
                                    <td class="">$630.00</td>
                                    <td class="">
                                        <span class="text-gray-800 fw-boldest">$86.70</span>
                                    </td>
                                    <td class="">
                                        <span class="badge py-3 px-4 fs-7 badge-light-danger">Rejected</span>
                                    </td>
                                    <td class="action-dot">
                                        <div class="rounded-circle light-blue" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <a href="">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                            <li><a class="dropdown-item" href="#">Published</a></li>
                                            <li><a class="dropdown-item" href="#">Unpublished</a></li>
                                        </ul>

                                    </td>
                                </tr>
                                <tr class="odd position-relative">
                                    <td>
                                        <a href="/metronic8/demo1/../demo1/apps/ecommerce/catalog/edit-product.html"
                                            class="text-gray-800 text-hover-primary">#XGY-346</a>
                                    </td>
                                    <td class="">7 min ago</td>
                                    <td class="">
                                        <a href="#" class=" text-hover-primary">Albert Flores</a>
                                    </td>
                                    <td class="">$630.00</td>
                                    <td class="">
                                        <span class="text-gray-800 fw-boldest">$86.70</span>
                                    </td>
                                    <td class="">
                                        <span class="badge py-3 px-4 fs-7 badge-light-primary">Progress</span>
                                    </td>
                                    <td class="action-dot">
                                        <div class="rounded-circle light-blue" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <a href="">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                            <li><a class="dropdown-item" href="#">Published</a></li>
                                            <li><a class="dropdown-item" href="#">Unpublished</a></li>
                                        </ul>

                                    </td>
                                </tr>
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
        {{-- end --}}

        {{-- Checkbox Table --}}
        <div class="mt-3">
            <div class="card card-table-ui">
                <div class="card-header card-table-header pt-7 border-bottom-none row">
                    <!--begin::Search-->
                    <div class="position-relative my-1 col-md-4">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-2 position-absolute top-50 translate-middle-y ms-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-table-widget-4="search" class="form-control  fs-7 ps-12"
                            placeholder="Search">
                    </div>
                    <!--end::Search-->

                    <div class="col-md-8">
                        <!--begin::Filters-->
                        <div class="row">
                            <!--begin::Status-->
                            <div class="col-12 col-sm-6 mb-1">
                                <!--begin::Select-->
                                <select class="form-select fw-bolder w-auto border-none" id="status"
                                    aria-label="Floating label select example">
                                    <option selected>Show All</option>
                                    <option value="1">Shipped</option>
                                    <option value="2">Confirmed</option>
                                    <option value="3">Pending</option>
                                    <option value="4">Rejected</option>
                                </select>
                                <!--end::Select-->
                            </div>
                            <div class="col-sm-6 col-12">
                                {{-- add product button --}}
                                <a href="#" class="btn btn-sm btn-primary">Add Product</a>
                                <!--end::Status-->
                            </div>
                        </div>
                        <!--begin::Filters-->
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-3 dataTable no-footer">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px " rowspan="1" colspan="1">
                                        <div class="form-check form-check-custom form-check-solid text-gray-700 pl-0">
                                            <input class="form-check-input" type="checkbox" value="" id="all_chekcked" />
                                            <label class="form-check-label" for="all_chekcked">
                                            </label>
                                        </div>
                                    </th>
                                    <th rowspan="1" colspan="1">Order ID</th>
                                    <th rowspan="1" colspan="1">Created</th>
                                    <th rowspan="1" colspan="1">Customer</th>
                                    <th rowspan="1" colspan="1">Total</th>
                                    <th rowspan="1" colspan="1">Profit</th>
                                    <th rowspan="1" colspan="1">Status</th>
                                    <th rowspan="1" colspan="1">Action</th>

                                </tr>
                            </thead>
                            <tbody class="fw-bolder fs-5 ">
                                <tr class="odd position-relative">
                                    <td class="w-10px " rowspan="1" colspan="1">
                                        <div class="form-check form-check-custom form-check-solid text-gray-700 pl-0 ">
                                            <input class="form-check-input" type="checkbox" value="" id="checked_1" />
                                            <label class="form-check-label" for="checked_1">
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!--begin::Thumbnail-->
                                            <a href="" class="symbol symbol-50px">
                                                <div class="product-table-img">
                                                    <img src="public/assets/img/gadgets.png" alt="">
                                                </div>
                                            </a>
                                            <!--end::Thumbnail-->
                                            <div class="ms-2">
                                                <!--begin::Title-->
                                                <a href="" class="text-gray-800 text-hover-primary fs-5 fw-bolder"
                                                    data-kt-ecommerce-product-filter="product_name">Product 1</a>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </td>
                                    <td class="">7 min ago</td>
                                    <td class="">
                                        <a href="#" class=" text-hover-primary">Albert Flores</a>
                                    </td>
                                    <td class="">$630.00</td>
                                    <td class="">
                                        <span class="text-gray-800 fw-boldest">$86.70</span>
                                    </td>
                                    <td class="">
                                        <span class="badge badge-light-warning">Pending</span>
                                    </td>
                                    <td class="action-dot">
                                        <div class="rounded-circle light-blue" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <a href="">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                            <li><a class="dropdown-item" href="#">Published</a></li>
                                            <li><a class="dropdown-item" href="#">Unpublished</a></li>
                                        </ul>

                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
        {{-- end --}}
        <section><span class="img-loader"> </span> </section>

    </div>
</div>


@endsection
