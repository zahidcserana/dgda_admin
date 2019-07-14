<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown "
     data-menu-vertical="true"data-menu-dropdown="true" data-menu-scrollable="true" data-menu-dropdown-timeout="500">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
        <li class="m-menu__item  m-menu__item--active" aria-haspopup="true" >
            <a  href="{{route('home')}}" class="m-menu__link ">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-text">
                    Dashboard
                </span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
            <a  href="#" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon flaticon-open-box"></i>
                <span class="m-menu__link-text">
                    Orders
                </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
                        <span class="m-menu__link">
                            <span class="m-menu__item-here"></span>
                            <span class="m-menu__link-text">
                                Layouts
                            </span>
                        </span>
                    </li>
                   {{-- <li class="m-menu__item " aria-haspopup="true" >
                        <a  href="{{route('orders')}}" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                Order List
                            </span>
                        </a>
                    </li>--}}

                    <li style="{{Auth::user()->user_type=='ADMIN'?'display:block':'display:none'}}" class="m-menu__item " aria-haspopup="true" >
                        <a  href="{{route('orders')}}" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                Order List
                            </span>
                        </a>
                    </li>
                    <li style="{{Auth::user()->user_type=='DGDA'?'display:block':'display:none'}}" class="m-menu__item " aria-haspopup="true" >
                        <a  href="{{route('order_items')}}" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                Order Item List
                            </span>
                        </a>
                    </li>
                    {{--
                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                        <a  href="{{route('customer_form')}}" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                Customer Add
                            </span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                        <a  href="builder.html" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                Right Sidebar
                            </span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                        <a  href="builder.html" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                Fixed Footer
                            </span>
                        </a>
                    </li>
                    --}}
                </ul>
            </div>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
            <a  href="#" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon flaticon-layers"></i>
                <span class="m-menu__link-text">
                    Pharmacy
                </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
                        <span class="m-menu__link">
                            <span class="m-menu__item-here"></span>
                            <span class="m-menu__link-text">
                                Layouts
                            </span>
                        </span>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true" >
                        <a  href="{{route('pharmacies')}}" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                Pharmacy List
                            </span>
                        </a>
                    </li>

                </ul>
            </div>
        </li>
{{--
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
            <a  href="#" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon flaticon-share"></i>
                <span class="m-menu__link-text">
                    Accounts
                </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
                        <span class="m-menu__link">
                            <span class="m-menu__item-here"></span>
                            <span class="m-menu__link-text">
                                Layouts
                            </span>
                        </span>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true" >
                        <a  href="{{route('accounts')}}" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                Accounts List
                            </span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                        <a  href="{{route('account_form')}}" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                Accounts Add
                            </span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                        <a  href="builder.html" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                Right Sidebar
                            </span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                        <a  href="builder.html" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                Fixed Footer
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover" data-redirect="true">
            <a  href="#" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon flaticon-network"></i>
                <span class="m-menu__link-text">
                    Users
                </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"  data-redirect="true">
                        <span class="m-menu__link">
                            <span class="m-menu__item-here"></span>
                            <span class="m-menu__link-text">
                                List
                            </span>
                        </span>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                        <a  href="{{ route('register') }}" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                New
                            </span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
                        <a  href="{{route('users')}}" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">
                                List
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    --}}
    </ul>
</div>
