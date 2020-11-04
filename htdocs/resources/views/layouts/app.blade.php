<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="{{ url('/') }}">
        <img class="img-fluid preloader" title="{{ config('app.name', 'Laravel') }}" src="{{ asset('img/logo.png') }}" width="150px" height="150px" />
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav px-3">
        @guest
            {{-- nothing --}}
        @else


            <li class="nav-item text-nowrap">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    Abmelden
                </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none nav-link">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</nav>
<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            @if (Auth::user() != '')
                <div class="sidebar-sticky pt-3">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Menü</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @if ($position == 'home') active @endif" href="{{ route('home') }}">
                                <span data-feather="home"></span>
                                Übersicht
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($position == 'owntimes') active @endif" href="{{ route('owntimes') }}">
                                Eigene Stunden
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($position == 'addtime') active @endif" href="{{ route('addtime') }}">
                                Neue Zeiten eintragen
                            </a>
                        </li>

                        @if (Auth::user()->admin == '1')
                            <li class="nav-item">
                                <hr>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($position == 'export') active @endif" href="{{ route('export') }}">
                                    Daten exportieren
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($position == 'adminuser') active @endif" href="{{ route('adminuser') }}">
                                    Benutzer
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </nav>
        @yield('content')
    </div>
</div>
</body>
</html>
