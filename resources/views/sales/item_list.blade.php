@extends('layouts.master')
@section('include_js')
@parent
<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/data-sale-item.js') }}" type="text/javascript"></script>

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

    .m-badge.m-badge--month3 {
        background-color: yellow;
        color: black;
    }

    /** blink start */
    blink {
        animation: blinker 0.6s linear infinite;
        color: #1c87c9;
    }

    blink>span.m-badge {
        min-width: 100px;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }

    .blink-one {
        animation: blinker-one 1s linear infinite;
    }

    @keyframes blinker-one {
        0% {
            opacity: 0;
        }
    }

    .blink-two {
        animation: blinker-two 1.4s linear infinite;
    }

    @keyframes blinker-two {
        100% {
            opacity: 0;
        }
    }


    /** blink end */
</style>
@endsection
@section('content')

<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Order List
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
                    <a href="{{route('orders')}}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Orders
                        </span>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="{{route('orders')}}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Back
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div>
            {{--<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                data-dropdown-toggle="hover" aria-expanded="true">
                <a href="#"
                    class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                    <i class="la la-plus m--hide"></i>
                    <i class="la la-ellipsis-h"></i>
                </a>
                <div class="m-dropdown__wrapper">
                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__content">
                                <ul class="m-nav">
                                    <li class="m-nav__section m-nav__section--first m--hide">
                                        <span class="m-nav__section-text">
                                            Quick Actions
                                        </span>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-share"></i>
                                            <span class="m-nav__link-text">
                                                Activity
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-chat-1"></i>
                                            <span class="m-nav__link-text">
                                                Messages
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-info"></i>
                                            <span class="m-nav__link-text">
                                                FAQ
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                            <span class="m-nav__link-text">
                                                Support
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                    <li class="m-nav__item">
                                        <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                                            Submit
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>--}}
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
                                Order List
                            </h3>
                        </div>
                        <div style="float: right;padding-top: 1%;">
                            {{--                                <a class="btn btn-primary" href="{{route('customer_form')}}">Add
                            New</a>--}}
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin: Search Form -->
                    <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                        <div class="row align-items-center">
                            <div class="col-xl-12 order-2 order-xl-1">
                                <div class="form-group m-form__group row align-items-center">

                                    <div class="col-md-2">
                                        <div class="m-form__group m-form__group--inline">
                                            <div class="m-form__control">
                                                <select class="form-control m-select" id="m_form_company_id">
                                                    <option value=''>- Select Company -</option>
                                                    @foreach ($medicine_company as $company)
                                                    <option value="{{ $company->id }}">{{ $company->company_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-md-none m--margin-bottom-10"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="m-form__group m-form__group--inline">
                                            <div class="m-form__control">
                                                <input type="text" class="form-control m-input"
                                                    placeholder="Medicine Name" name="medicine_name" id="medicine_name">
                                            </div>
                                        </div>
                                        <div class="d-md-none m--margin-bottom-10"></div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="m-form__group m-form__group--inline">
                                            <div class="m-form__control">
                                                <input type="text" class="form-control m-input"
                                                    placeholder="Pharmacy Name" id="m_form_pharmacy">
                                            </div>
                                        </div>
                                        <div class="d-md-none m--margin-bottom-10"></div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="m-form__group m-form__group--inline">
                                            <div class="m-form__control">
                                                <input type="text" class="form-control m-input"
                                                    placeholder="Pharmacy Licence No" id="m_form_pharmacy_licence_no">
                                            </div>
                                        </div>
                                        <div class="d-md-none m--margin-bottom-10"></div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="m-form__group m-form__group--inline">
                                            <div class="m-form__control">
                                                <input type="text" class="form-control m-input" placeholder="City Name"
                                                    id="m_form_branch_city">
                                            </div>
                                        </div>
                                        <div class="d-md-none m--margin-bottom-10"></div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="m-form__group m-form__group--inline">
                                            <div class="m-form__control">
                                                <input type="text" class="form-control m-input" placeholder="Area Name"
                                                    id="m_form_branch_area">
                                            </div>
                                        </div>
                                        <div class="d-md-none m--margin-bottom-10"></div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="m-form__group m-form__group--inline">
                                            <div class="m-form__control">
                                                <select class="form-control m-select" id="m_form_exp_type">
                                                    <option value=''>- Exp Type -</option>
                                                    <option value="1">OK</option>
                                                    <option style="background-color: orange" value="2">Expired in 1
                                                        Month</option>
                                                    <option style="background-color: yellow;" value="3">Expired in 3
                                                        Month</option>
                                                    <option style="background-color: red" value="4">Expired</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-md-none m--margin-bottom-10"></div>
                                    </div>

                                    {{--<div class="col-md-2">
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
                                        </div>--}}

                                    <div class="col-md-2">
                                        <button class="btn btn-info">Search</button>
                                        <a onclick="location.reload();" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
