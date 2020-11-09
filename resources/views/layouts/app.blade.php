<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Carga') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- icons -->
    <script src="https://kit.fontawesome.com/10241fbc03.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Carga') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @auth
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            @if ( Auth::user()->rol == 'request' || Auth::user()->rol == 'admin' )
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ url('/') }}">
                                        {{ 'Formulario' }} <span class="sr-only">(current)</span>
                                    </a>
                                </li>
                            @elseif( Auth::user()->rol == 'champ' || Auth::user()->rol == 'admin' )
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ url('/champ') }}">
                                        {{ 'Champ' }}
                                    </a>
                                </li>
                            @elseif( Auth::user()->rol == 'approval' || Auth::user()->rol == 'admin' )
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/main') }}">
                                        {{ 'Aprobar' }}
                                    </a>
                                </li>
                            @elseif ( Auth::user()->rol == 'admin' )
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/register') }}">
                                        {{ 'Registrar' }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ 'Cerrar Sesión' }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')

            <script>
                function approve() {
                    document.getElementById('accept').value = "1";
                    return confirm('¿Realmente desea aprobar la solicitud?')
                }

                function reject() {
                    document.getElementById('accept').value = "0";
                    return confirm('¿Realmente desea rechazar la solicitud?')
                }
            </script>
        </main>
    </div>
</body>
</html>
