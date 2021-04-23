<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8"/>
        {{-- Title Section --}}
        <title>{{ config('app.name', 'Carga-Comat') }}</title>
        {{-- Meta Data --}}
        <meta name="description" content="@yield('page_description', $page_description ?? '')"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="env" content="{{ config('app.env', 'develop') }}">
        {{-- Favicon --}}
        <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
        {{-- Fonts --}}
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=layout.resources.fonts.google.families">
        <!--begin::Page Custom Styles(used by this page)-->
        <link href="{{ asset('css/pages/login/classic/login-4.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Page Custom Styles-->
        {{-- Global Theme Styles (used by all pages) --}}
        <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

        <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    </head>

    <!--begin::Body-->
    <body id="kt_body" class="header-fixed header-mobile-fixed page-loading">
        <!--begin::Main-->
        <!--begin::Header Mobile-->
        <div id="kt_header_mobile" class="header-mobile bg-primary header-mobile-fixed">
            <!--begin::Logo-->
            <a href="{{ url('/') }}">
                <img alt="Logo" src="{{ asset('media/logos/vb-logo-white.png') }}" class="max-h-30px" />
            </a>
            <!--end::Logo-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
                    <span></span>
                </button>
                <button class="btn p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                    <span class="svg-icon svg-icon-xl">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                </button>
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header Mobile-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="d-flex flex-row flex-column-fluid page">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    <!--begin::Header-->
                    <div id="kt_header" class="header flex-column header-fixed">
                        <!--begin::Top-->
                        <div class="header-top">
                            <!--begin::Container-->
                            <div class="container">
                                <!--begin::Left-->
                                <div class="d-none d-lg-flex align-items-center mr-3">
                                    <!--begin::Logo-->
                                    <a href="{{ url('/') }}" class="mr-20">
                                        <img alt="Logo" src="{{ asset('media/logos/vb-logo-white.png') }}" class="max-h-35px" />
                                    </a>
                                    <!--end::Logo-->                                  
                                </div>
                                <!--end::Left-->
                                <!--begin::Topbar-->
                                <div class="topbar">                                
                                    <!--begin::User-->
                                    <div class="topbar-item">
                                        <div class="btn btn-icon w-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                                            <div class="d-flex flex-column text-right pr-3">
                                                <span class="text-white font-weight-bolder font-size-sm d-none d-md-inline">{{ Auth::user()->name }}</span>
                                                <span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-md-inline">
                                                     @if ( isset(Auth::user()->rol) && Auth::user()->rol == 'viva')
                                                        {{ 'Comat' }}
                                                    @else
                                                        {{ 'Carga' }}
                                                    @endif
                                                </span>
                                                <div class="btn-hover-transparent-white">
                                                    <a class="text-white opacity-50 font-weight-bold font-size-sm d-none d-md-inline" href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();">
                                                        {{ 'Cerrar Sesión' }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                            <span class="symbol symbol-35">
                                                <span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30">
                                                    <img src="{{ asset('media/svg/misc/015-telegram.svg') }}" class="h-50 align-self-center" alt="">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <!--end::User-->
                                </div>
                                <!--end::Topbar-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Top-->
                        <!--begin::Bottom-->
                        <div class="header-bottom">
                            <!--begin::Container-->
                            <div class="container">
                                <!--begin::Header Menu Wrapper-->
                                <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                                    <!--begin::Header Menu-->
                                    <div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
                                        <!--begin::Header Nav-->
                                        @auth
                                        <ul class="menu-nav">
                                            @if ( Auth::user()->rol == 'admin' )
                                                <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here" data-menu-toggle="hover" aria-haspopup="true">
                                                    <a class="menu-link" href="{{ url('/register') }}">
                                                        <span class="menu-text">{{ 'Registrar' }}</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here" data-menu-toggle="hover" aria-haspopup="true">
                                                    <a class="menu-link" href="{{ url('/users') }}">
                                                        <span class="menu-text">{{ 'Usuarios' }}</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here" data-menu-toggle="hover" aria-haspopup="true">
                                                    <a class="menu-link" href="{{ url('/emails') }}">
                                                        <span class="menu-text">{{ 'Correos' }}</span>
                                                    </a>
                                                </li>
                                            @endif

                                            @if (Auth::user()->rol == 'viva')
                                                <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="hover" aria-haspopup="true">
                                                    <a class="menu-link" href="{{ url('/viva_requests') }}">
                                                        <span class="menu-text">{{ 'Mis solicitudes' }}</span> 
                                                        
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here" data-menu-toggle="hover" aria-haspopup="true">
                                                    <a class="menu-link" href="{{ url('/uploads') }}">
                                                        <span class="menu-text">{{ 'Solicitar' }}</span> 
                                                        
                                                    </a>
                                                </li>
                                            @endif

                                            @if( Auth::user()->rol == 'aerocharter')
                                                    <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here" data-menu-toggle="hover" aria-haspopup="true">
                                                        <a class="menu-link" href="{{ url('/aerocharter_requests') }}">
                                                            <span class="menu-text">{{ 'Mis solicitudes' }}</span>
                                                        </a>
                                                    </li>
                                                    <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here" data-menu-toggle="hover" aria-haspopup="true">
                                                        <a class="menu-link" href="{{ url('/aerocharter') }}">
                                                            <span class="menu-text">{{ 'SFTP' }}</span>
                                                        </a>
                                                    </li>
                                            @endif

                                            @if( Auth::user()->rol == 'approval')
                                                <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here" data-menu-toggle="hover" aria-haspopup="true">
                                                    <a class="menu-link" href="{{ url('/main') }}">
                                                        <span class="menu-text">{{ 'Aprobar' }}</span>
                                                    </a>
                                                </li>    
                                            @endif
                                            
                                        </ul>
                                        @endauth
                                        <!--end::Header Nav-->
                                    </div>
                                    <!--end::Header Menu-->
                                </div>
                                <!--end::Header Menu Wrapper-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Bottom-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Entry-->
                        <div class="d-flex flex-column-fluid">
                            <!--begin::Container-->
                            <div class="container">
                                <!--begin::Dashboard-->
                                @yield('content')
                                <!--end::Dashboard-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Entry-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Footer-->
                    <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                        <!--begin::Container-->
                        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <!--begin::Copyright-->
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted font-weight-bold mr-2">2020©</span>
                                <a href="https://www.vivaaerobus.com/" target="_blank" class="text-dark-75 text-hover-primary">VivaAerobus</a>
                            </div>
                            <!--end::Copyright-->
                            <!--begin::Nav-->
                            <div class="nav nav-dark order-1 order-md-2">
                                <a href="https://www.vivaaerobus.com/" target="_blank" class="nav-link pr-3 pl-0">About</a>
                                <a href="https://www.vivaaerobus.com/" target="_blank" class="nav-link px-3">Team</a>
                                <a href="https://www.vivaaerobus.com/" target="_blank" class="nav-link pl-3 pr-0">Contact</a>
                            </div>
                            <!--end::Nav-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::Main-->
        <script>
            function approve() {
                document.getElementById('accept').value = "1";
            }

            function reject() {
                document.getElementById('accept').value = "0";
            }

            function populate() {
                document.getElementById('std').value  = $('#flight_number').find("option:selected").attr("Dep");
                document.getElementById('from').value = $('#flight_number').find("option:selected").attr("PortFrom");
                document.getElementById('to').value   = $('#flight_number').find("option:selected").attr("PortTo");
                document.getElementById('rego').value = $('#flight_number').find("option:selected").attr("Rego");
            }

            function form1() {
                let tag = '<div class="mx-auto w-75 card">';
                    tag += '<center><textarea name="message_approval" rows="5" maxlength="255" required></textarea></center>';
                    tag += '<br>';
                    tag += '<table class="table">';
                    tag += '<thead>';
                    tag += '<tr>';
                    tag += '<td></td>';
                    tag += '<td><center><button type="submit" class="btn btn-primary" onclick="approve()"> Aprobar </button></center></td>';
                    tag += '<td><center><button type="submit" class="btn btn-danger" onclick="reject()"> Rechazar </button></center></td>';
                    tag += '<td></td>';
                    tag += '</tr>';
                    tag += '</thead>';
                    tag += '</table>';
                    tag += '</div>';

                    $("#bUpd").html("");
                    $("#form1").append(tag);
            }
        </script>
        
        <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#0BB783", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#D7F9EF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
        <script src="{{ asset('plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
        <script src="{{ asset('js/scripts.bundle.js') }}"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
    <!--end::Body-->

</html>
