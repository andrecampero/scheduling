<!DOCTYPE html>

<html lang="pt-br">

<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>Sheculing</title>
    <meta name="description" content="Actions example page">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!--end::Web font -->

    <!--end::Web font -->

    <!--begin::Base Styles -->
	<link href="{{url('assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('assets/vendors/custom/datatables/buttons.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{url('assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('assets/demo/default/base/scheduling.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('assets/datetime/css/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>

    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-37564768-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">

@include('layout.header')
<!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

        <!-- BEGIN: Left Aside -->
        <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
            <i class="la la-close"></i>
        </button>
        <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

            <!-- BEGIN: Aside Menu -->
            <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
                <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="{{route('home')}}" class="m-menu__link ">
                            <i class="m-menu__link-icon flaticon-line-graph"></i>
                            <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">Home</span>
											
										</span>
									</span>
                        </a>
                    </li>
                    @if(isset($menus))
                        @foreach($menus as $menu)
                            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"
                                m-menu-submenu-toggle="hover">
                                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                    <i class="m-menu__link-icon {{$menu->icon ? $menu->icon : ''}}"></i>
                                    <span class="m-menu__link-text">{{$menu->name}}</span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>

                                <div class="m-menu__submenu ">
                                    <span class="m-menu__arrow"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
											<span class="m-menu__link">
												<span class="m-menu__link-text">Base</span>
											</span>
                                        </li>
                                        @if(count($menu->submenus) > 0)
                                            @foreach($menu->submenus as $submenu)
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a href="{{isset($submenu->url) ? route($submenu->url) : route('home')}}"
                                                       class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{$submenu->name}}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <!-- END: Aside Menu -->
        </div>

        <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="m-content">
                @yield('content')

            </div>
        </div>
    </div>

    <!-- end:: Body -->


</div>

<!-- end:: Page -->


<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>

<!-- end::Scroll Top -->

<div class="modal fade show" id="on_confirm" tabindex="-1" role="dialog" aria-labelledby="on_errorModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('titles.error')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="description_error"></p>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="image-gallery-title"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                            class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="image-gallery-image" class="img-responsive col-md-12" src="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i
                            class="fa fa-arrow-left"></i>
                </button>

                <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i
                            class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<input type="hidden" id="basepath" value="{{ url('/') }}">

<!--begin::Base Scripts -->

<script src="{{ url('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>

<!--end::Base Scripts -->

<!--begin::Page Resources -->
<script src="{{ url('/assets/demo/default/custom/header/actions.js')}}" type="text/javascript"></script>

<!--end::Page Resources -->

<!--begin:: Data Tables -->
<script src="{{url('assets/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script src="{{url('assets/vendors/custom/datatables/dataTables.buttons.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>

<!--end:: Data Tables -->
<script src="{{url('assets/app/js/axios.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/datetime/js/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
<script src="{{url('assets/datetime/js/locales/bootstrap-datetimepicker.pt-BR.js')}}"
        type="text/javascript" charset="UTF-8"></script>
<script src="{{url('assets/app/js/dashboard.js')}}" type="text/javascript"></script>
<script src="{{url('assets/app/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/demo/default/custom/components/base/sweetalert2.js')}}" type="text/javascript"></script>
<script src="{{url('assets/app/js/bootstrap-typeahead.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/app/js/jquery.mask.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/app/js/jquery.maskWeight.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/app/js/form.js')}}" type="text/javascript"></script>

@stack('scripts')
</body>
<!--<script>
$(document).ready(function() {
	$("#m_aside_left_close_btn").click();
});
</script>-->
<!-- end::Body -->
</html>
