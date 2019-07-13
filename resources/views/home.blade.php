@extends('layouts.master')
@section('content')
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Dashboard
                </h3>
            </div>
            <div>
           {{-- <span class="m-subheader__daterange" id="m_dashboard_daterangepicker">
                <span class="m-subheader__daterange-label">
                    <span class="m-subheader__daterange-title"></span>
                    <span class="m-subheader__daterange-date m--font-brand"></span>
                </span>
                <a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                    <i class="la la-angle-down"></i>
                </a>
            </span>--}}
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <!--Begin::Section-->
        <div class="row">
            <div class="col-xl-4">
                <!--begin:: Widgets/Quick Stats-->
                <div class="row m-row--full-height">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="m-portlet m-portlet--half-height m-portlet--border-bottom-brand ">
                            <div class="m-portlet__body">
                                <a href="{{ route('pharmacies') }}">
                                    <div class="m-widget26">
                                        <div class="m-widget26__number">
                                            {{$total_pharmacy}}
                                            <small>
                                                Pharmacy
                                            </small>
                                        </div>
                                        <div class="m-widget26__chart" style="height:90px; width: 220px;">
                                            {{--<canvas id="m_chart_quick_stats_1"></canvas>--}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="m--space-30"></div>
                        {{--<div class="m-portlet m-portlet--half-height m-portlet--border-bottom-danger ">
                            <div class="m-portlet__body">
                                <div class="m-widget26">
                                    <div class="m-widget26__number">
                                        690
                                        <small>
                                            All Orders
                                        </small>
                                    </div>
                                    <div class="m-widget26__chart" style="height:90px; width: 220px;">
                                        <canvas id="m_chart_quick_stats_2"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="m-portlet m-portlet--half-height m-portlet--border-bottom-success ">
                            <div class="m-portlet__body">
                                <a href="{{route('order_items')}}">
                                    <div class="m-widget26">
                                        <div class="m-widget26__number">
                                            {{$total_order}}
                                            <small>
                                                Order
                                            </small>
                                        </div>
                                        <div class="m-widget26__chart" style="height:90px; width: 220px;">
                                            {{--<canvas id="m_chart_quick_stats_3"></canvas>--}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="m--space-30"></div>
                        {{--<div class="m-portlet m-portlet--half-height m-portlet--border-bottom-accent ">
                            <div class="m-portlet__body">
                                <div class="m-widget26">
                                    <div class="m-widget26__number">
                                        470
                                        <small>
                                            All Comissions
                                        </small>
                                    </div>
                                    <div class="m-widget26__chart" style="height:90px; width: 220px;">
                                        <canvas id="m_chart_quick_stats_4"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                </div>
                <!--end:: Widgets/Quick Stats-->
            </div>

            <div class="col-xl-4">
                <!--begin:: Widgets/Finance Summary-->
                {{--<div class="m-portlet m-portlet--full-height m-portlet--fit ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Finance Summary
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_widget4_tab1_content" role="tab">
                                        Month
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_widget4_tab2_content" role="tab">
                                        All Time
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="m-widget12 m-widget12--chart-bottom m--margin-top-10" style="min-height: 450px">
                                    <div class="m-widget12__item">
                                    <span class="m-widget12__text1">
                                        Annual Companies Taxes EMS
                                        <br>
                                        <span>
                                            $500,000
                                        </span>
                                    </span>
                                        <span class="m-widget12__text2">
                                        Next Tax Review Date
                                        <br>
                                        <span>
                                            July 24,2017
                                        </span>
                                    </span>
                                    </div>
                                    <div class="m-widget12__item">
                                    <span class="m-widget12__text1">
                                        Avarage Product Price
                                        <br>
                                        <span>
                                            $60,70
                                        </span>
                                    </span>
                                        <div class="m-widget12__text2">
                                            <div class="m-widget12__desc">
                                                Satisfication Rate
                                            </div>
                                            <br>
                                            <div class="m-widget12__progress">
                                                <div class="m-widget12__progress-sm progress m-progress--sm">
                                                    <div class="m-widget12__progress-bar progress-bar bg-brand" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="m-widget12__stats">
                                                63%
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-widget12__chart m-portlet-fit--sides" style="height:290px;">
                                        <canvas id="m_chart_finance_summary"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane"></div>
                        </div>
                    </div>
                </div>--}}
                <!--end:: Widgets/Finance Summary-->
            </div>
            <div class="col-xl-4">
                <!--begin:: Widgets/Top Products-->
                {{--<div class="m-portlet m-portlet--full-height m-portlet--fit ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Top Products
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                                    <a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                        All
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 36.5px;"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
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
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin::Widget5-->
                        <div class="m-widget4 m-widget4--chart-bottom" style="min-height: 480px">
                            <div class="m-widget4__item">
                                <div class="m-widget4__img m-widget4__img--logo">
                                    <img src="assets/app/media/img/client-logos/logo3.png" alt="">
                                </div>
                                <div class="m-widget4__info">
                                <span class="m-widget4__title">
                                    Phyton
                                </span>
                                    <br>
                                    <span class="m-widget4__sub">
                                    A Programming Language
                                </span>
                                </div>
                                <span class="m-widget4__ext">
                                <span class="m-widget4__number m--font-brand">
                                    +$17
                                </span>
                            </span>
                            </div>
                            <div class="m-widget4__item">
                                <div class="m-widget4__img m-widget4__img--logo">
                                    <img src="assets/app/media/img/client-logos/logo1.png" alt="">
                                </div>
                                <div class="m-widget4__info">
                                <span class="m-widget4__title">
                                    FlyThemes
                                </span>
                                    <br>
                                    <span class="m-widget4__sub">
                                    A Let's Fly Fast Again Language
                                </span>
                                </div>
                                <span class="m-widget4__ext">
                                <span class="m-widget4__number m--font-brand">
                                    +$300
                                </span>
                            </span>
                            </div>
                            <div class="m-widget4__item">
                                <div class="m-widget4__img m-widget4__img--logo">
                                    <img src="assets/app/media/img/client-logos/logo4.png" alt="">
                                </div>
                                <div class="m-widget4__info">
                                <span class="m-widget4__title">
                                    Starbucks
                                </span>
                                    <br>
                                    <span class="m-widget4__sub">
                                    Good Coffee & Snacks
                                </span>
                                </div>
                                <span class="m-widget4__ext">
                                <span class="m-widget4__number m--font-brand">
                                    +$300
                                </span>
                            </span>
                            </div>
                            <div class="m-widget4__chart m-portlet-fit--sides m--margin-top-20" style="height:260px;">
                                <canvas id="m_chart_trends_stats_2"></canvas>
                            </div>
                        </div>
                        <!--end::Widget 5-->
                    </div>
                </div>--}}
                <!--end:: Widgets/Top Products-->
            </div>

        </div>
        <!--End::Section-->
    </div>
@endsection
