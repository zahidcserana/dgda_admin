@extends('layouts.master')
@section('include_js')
    @parent
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/cropper/cropper.min.js') }}"></script>
    <script src="{{ asset('assets/cropper/cropper.css') }}"></script>
    <script type="text/javascript">
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
    <style>
        .m-widget4 .m-widget4__item .m-widget4__info {
            display: table-cell;
            width: 55%;
            padding-left: 1.2rem;
            padding-right: 1.2rem;
            font-size: 1rem;
            vertical-align: middle;
        }
    </style>
@endsection
@section('content')
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Account Details
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
                        <a href="{{route('accounts')}}" class="m-nav__link">
											<span class="m-nav__link-text">
												Accounts
											</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{'add_account'}}" class="m-nav__link">
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
                                    Account Info
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <!--begin::Form-->
                            <form class="m-form" name="data-form" method="POST" action="{{route('account_edit',$account->id)}}">
                                {{ csrf_field() }}
                                <div class="m-portlet__body">
                                    <input type="hidden" name="id" id="account_id"
                                           value="{{!empty($account->id)?$account->id:''}}">

                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-2 col-form-label">
                                            Customer
                                        </label>
                                        <div class="col-10">
                                            <select class="form-control m-input m-input--air"
                                                    id="customer_id" name="customer_id">
                                                <option value="">Select One</option>
                                                @foreach($customers as $row)
                                                    <option {{empty($account->customer_id)?'':$account->customer_id==$row->id?'selected="selected"':""}} value="{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                            </select></div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-search-input" class="col-2 col-form-label">
                                            Description
                                        </label>
                                        <div class="col-10">
                                    <textarea name="description" class="form-control md-input"
                                              data-provide="markdown" rows="10" style="resize: none;"
                                              aria-describedby="markdown-error" aria-invalid="false">
                                            {{!empty($account->description)?$account->description:''}}
                                        </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">
                                            Amount
                                        </label>
                                        <div class="col-10">
                                            <input class="form-control m-input" type="number"
                                                   value="{{!empty($account->amount)?$account->amount:''}}" id="amount"
                                                   name="amount">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-number-input" class="col-2 col-form-label">
                                            Pay
                                        </label>
                                        <div class="col-10">
                                            <input class="form-control m-input" type="number"
                                                   value="{{!empty($account->pay)?$account->pay:''}}" id="pay"
                                                   name="pay">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-number-input" class="col-2 col-form-label">
                                            Due
                                        </label>
                                        <div class="col-10">
                                            <input class="form-control m-input" type="number"
                                                   value="{{!empty($account->due)?$account->due:''}}" id="due"
                                                   name="due">
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
                                                <a class="btn btn-secondary" href="{{route('accounts')}}">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <div class="col-md-6">
                            {{--start printable area--}}
                            <div class="m-portlet m-portlet--full-height m-portlet--fit ">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text">
                                                Voucher
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="m-portlet__head-tools">
                                        <a href="{{action('AccountsController@downloadPDF')}}" class="btn btn-primary">
                                            <i class="m-nav__link-icon flaticon-download"></i>
                                            <span class="m-nav__link-text">
																					Download
																				</span>
                                        </a>
                                        {{--<ul class="m-portlet__nav">
                                            <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                                data-dropdown-toggle="hover">
                                                <a href="{{action('AccountsController@downloadPDF')}}" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                    <span class="m-nav__link-text">
																					PDF
																				</span>
                                                </a>
                                                <div class="m-dropdown__wrapper">
                                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                    <div class="m-dropdown__inner">
                                                        <div class="m-dropdown__body">
                                                            <div class="m-dropdown__content">
                                                                <ul class="m-nav">
                                                                    <li class="m-nav__item">
                                                                        <input class="btn btn-info btn-lg" type="button" onclick="printDiv('printableArea')" value="Print"/>
                                                                    </li>
                                                                    <li class="m-nav__item">
                                                                        <a href="{{action('AccountsController@downloadPDF')}}" class="m-nav__link">
                                                                            <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                            <span class="m-nav__link-text">
																					PDF
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
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>--}}
                                    </div>
                                </div>
                                <div class="m-portlet__body" id="printableArea">
                                    <div class="m-widget4 m-widget4--chart-bottom" style="min-height: 350px;font-size: initial;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="m-widget4__text">
														Date
													</span>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="m-widget4__number m--font-accent">
														{{$account->created_at}}
													</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="m-widget4__text">
														Name
													</span>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="m-widget4__number m--font-accent">
														{{$account->name}}
													</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="m-widget4__text">
														Description
													</span>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="m-widget4__number m--font-accent">
														{{$account->description}}
													</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="m-widget4__text">
														Amount
													</span>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="m-widget4__number m--font-accent">
														{{$account->amount}}
													</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="m-widget4__text">
														Pay
													</span>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="m-widget4__number m--font-accent">
														{{$account->pay}}
													</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="m-widget4__text">
														Due
													</span>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="m-widget4__number m--font-accent">
														{{$account->due}}
													</span>
                                            </div>
                                        </div>

                                        <div class="m-widget4__chart m-portlet-fit--sides m--margin-top-20 m-portlet-fit--bottom1"
                                             style="height:120px;">
                                            <div class="chartjs-size-monitor"
                                                 style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                <div class="chartjs-size-monitor-expand"
                                                     style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink"
                                                     style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                </div>
                                            </div>
                                            <canvas id="m_chart_latest_updates" width="1072" height="150"
                                                    class="chartjs-render-monitor"
                                                    style="display: block; height: 120px; width: 858px;"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--end printable area--}}
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>

@endsection