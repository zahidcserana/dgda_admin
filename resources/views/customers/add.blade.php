@extends('layouts.master')
@section('content')
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Customer Details
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
                        <a href="{{route('customers')}}" class="m-nav__link">
											<span class="m-nav__link-text">
												Products
											</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{'add_customer'}}" class="m-nav__link">
											<span class="m-nav__link-text">
												New
											</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
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
                                            <a href="#"
                                               class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                                                Submit
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                                <h3 class="m-portlet__head-text">
                                    Customer Info
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form" name="data-form" method="POST" action="{{route('add_customer')}}">
                        {{ csrf_field() }}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-1 col-form-label">
                                    Name
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="text" value="" id="name" name="name">
                                </div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    Email
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="email" value="" id="email" name="email">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-tel-input" class="col-1 col-form-label">
                                    Telephone
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="tel" value="" id="phone" name="phone">
                                </div>

                                <label for="example-number-input" class="col-1 col-form-label">
                                    Mobile
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="number" value="" id="mobile" name="mobile">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-month-input" class="col-1 col-form-label">
                                    Contact Date
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="date" value="" id="contact_date" name="contact_date">
                                </div>

                                <label for="example-color-input" class="col-1 col-form-label">
                                    Address
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="text" value="" id="address" name="address">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-color-input" class="col-1 col-form-label">
                                    Company
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="text" value="" id="company" name="company">
                                </div>

                                <label for="example-color-input" class="col-1 col-form-label">
                                    Service
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="text" value="" id="service" name="service">
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-success">
                                            Submit
                                        </button>
                                        <a class="btn btn-secondary" href="{{route('customers')}}">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>

@endsection