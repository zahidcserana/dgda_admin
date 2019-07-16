@extends('layouts.master')
@section('include_js')
    @parent

@endsection

@section('content')
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Order Details
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
                        <a href="{{route('order_edit',$order['id'])}}" class="m-nav__link">
											<span class="m-nav__link-text">
												Details
											</span>
                        </a>
                    </li>
                </ul>
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
                                    Order Info
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form" name="data-form" method="POST" action="{{route('order_edit',$order['id'])}}">
                        {{ csrf_field() }}
                        <div class="m-portlet__body">
                            <input type="hidden" id="userId" value="{{$order['id']}}">

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">
                                    Pharmacy Invoice
                                </label>
                                <div class="col-4">
                                    <input class="form-control m-input" type="text" value="{{$order['invoice']}}"
                                           id="pharmacy_invoice" name="pharmacy_invoice">
                                </div>
                                <label for="example-search-input" class="col-2 col-form-label">
                                    Company Invoice
                                </label>
                                <div class="col-4">
                                    <input class="form-control m-input" type="text" value="{{$order['company_invoice']}}"
                                           id="company_invoice" name="company_invoice">
                                </div>
                            </div>
                            <div class="form-group m-form__group row"  style="font-weight: bold">
                                <div for="example-text-input" class="col-3 col-form-label">
                                    Medicine Name
                                </div>
                                <div for="example-text-input" class="col-2 col-form-label">
                                    Quantity
                                </div>
                                <div for="example-text-input" class="col-2 col-form-label">
                                    Price
                                </div>
                                <div for="example-text-input" class="col-2 col-form-label">
                                    Exp Date
                                </div>
                                <div for="example-text-input" class="col-2 col-form-label">
                                    Batch
                                </div>
                            </div>
                            @foreach($order['order_items'] as $item)
                                <div class="form-group m-form__group row">
                                    <div for="example-text-input" class="col-3 col-form-label">
                                       {{$item['medicine']['brand_name']}}
                                        <input class="form-control m-input" type="hidden" value="{{$item['id']}}"
                                               id="item_id" name="item_id">
                                    </div>

                                    <div class="col-2">
                                        <input class="form-control m-input" type="text" value="{{$item['quantity']}}"
                                               id="quantity" name="quantity">
                                    </div>

                                    <div class="col-2">
                                        <input class="form-control m-input" type="text" value="{{$item['unit_price']}}"
                                               id="unit_price" name="unit_price">
                                    </div>

                                    <div class="col-2">
                                        <input class="form-control m-input" type="date" value="{{$item['exp_date']}}"
                                               id="exp_date" name="exp_date">
                                    </div>

                                    <div class="col-2">
                                        <input class="form-control m-input" type="text" value="{{$item['batch_no']}}"
                                               id="batch_no" name="batch_no">
                                    </div>
                                </div>
                            @endforeach



                            {{--



                            <div class="form-group m-form__group row">
                                <label for="example-tel-input" class="col-1 col-form-label">
                                    Telephone
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="tel" value="{{$order->phone}}" id="phone" name="phone">
                                </div>

                                <label for="example-number-input" class="col-1 col-form-label">
                                    Mobile
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="number" value="{{$order->mobile}}" id="mobile" name="mobile">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-month-input" class="col-1 col-form-label">
                                    Contact Date
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="date" value="{{$order->contact_date}}" id="contact_date" name="contact_date">
                                </div>

                                <label for="example-color-input" class="col-1 col-form-label">
                                    Address
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="text" value="{{$order->address}}" id="address" name="address">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-color-input" class="col-1 col-form-label">
                                    Company
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="text" value="{{$order->company}}" id="company" name="company">
                                </div>

                                <label for="example-color-input" class="col-1 col-form-label">
                                    Service
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="text" value="{{$order->service}}" id="service" name="service">
                                </div>
                            </div>--}}
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-success">
                                            Submit
                                        </button>
                                        <a class="btn btn-secondary" href="{{route('orders')}}">Cancel</a>
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
