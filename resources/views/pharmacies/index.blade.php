@extends('layouts.master')
@section('include_js')
    @parent
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/data-pharmacy.js') }}" type="text/javascript"></script>

    <style>
        .dropbtn {
            background-color: #4CAF50;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }
    </style>
@endsection
@section('content')

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Pharmacy List
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{route('pharmacies')}}" class="m-nav__link">
											<span class="m-nav__link-text">
												Pharmacies
											</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{route('home')}}" class="m-nav__link">
											<span class="m-nav__link-text">
												Back
											</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>

            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="row">
            <div class="col-xl-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div style="float: left" class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Pharmacy List
                                </h3>
                            </div>
                            <div style="float: right;padding-top: 1%;">
{{--                                <a class="btn btn-primary" href="{{route('customer_form')}}">Add New</a>--}}
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin: Search Form -->
                        {{-- <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                            <div class="row align-items-center">
                                <div class="col-xl-12 order-2 order-xl-1">
                                    <div class="form-group m-form__group row align-items-center">
                                        <div class="col-md-2">
                                            <div class="m-form__group m-form__group--inline">
                                                <div class="m-form__control">
                                                    <input type="text" class="form-control m-input"
                                                           placeholder="ID..." id="m_form_id">
                                                </div>
                                            </div>
                                            <div class="d-md-none m--margin-bottom-10"></div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="m-form__group m-form__group--inline">
                                                <div class="m-form__control">
                                                    <input type="text" class="form-control m-input"
                                                           placeholder="Invoice..." id="m_form_invoice">
                                                </div>
                                            </div>
                                            <div class="d-md-none m--margin-bottom-10"></div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="m-form__group m-form__group--inline">
                                                <div class="m-form__label">
                                                    <label>
                                                        Status:
                                                    </label>
                                                </div>
                                                <div class="m-form__control">
                                                    <select class="form-control m-bootstrap-select" id="m_form_status">
                                                        <option value="">
                                                            All
                                                        </option>
                                                        <option value="PENDING">
                                                            PENDING
                                                        </option>
                                                        <option value="COMPLETE">
                                                            COMPLETE
                                                        </option>
                                                        <option value="HOLD">
                                                            HOLD
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-md-none m--margin-bottom-10"></div>
                                        </div>

                                        <div class="col-md-2">
                                            <button class="btn btn-info">Search</button>
                                            <a onclick="location.reload();" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!--end: Search Form -->
                        <!--begin::Section-->
                        <div class="m-section">
                            <div class="m-section__content">
                                <!--begin: Datatable -->
                                <div class="m_datatable" id="ajax_data"></div>
                                <!--end: Datatable -->
                            </div>
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>

@endsection
