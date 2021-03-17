<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .nav-link {
            padding: 1em 0.5em;
            color: #0b057a;
        }
        .nav-link:hover {
            background-color: #0b057a;
            color: #fff;
        }
        .strong {
            font-weight: bold;
        }

    </style>

</head>
<body>
    <div id="app">
        <div class="bg-img">
        <nav id="navigation" class="navbar navbar-inner navbar-expand-sm shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span><img src="https://img.icons8.com/fluent-systems-regular/24/000000/menu--v3.png"/></span>
                </button>
                <a class="d-sm-none" href="/" style="margin-right: 8px">
                    <img src="/pics/pijper-logo.png" width="50" height="50">
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <a class="d-none d-md-block" href="/" style="margin-right: 8px">
                        <img src="/pics/pijper-logo.png" width="50" height="50">
                    </a>
                    <h1 style="font-family: Open Sans" class="d-none d-md-block font-weight-lighter">|</h1>
                    <h6 class="d-none d-md-block" style="padding-top: 5px; margin-left: 5px;">PM Social Wall</h6>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="{{ route('login') }}" role="button">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-light ml-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="{{ (request()->is('home')) ? 'strong' : ''}}">
                                <a class="nav-link nav-link-me" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="{{ (request()->is('#')) ? 'strong' : ''}}">
                                <a class="nav-link nav-link-me" href="#">Trending</a>
                            </li>
                            <li class="{{ (request()->is('activity')) ? 'strong' : ''}}">
                                <a class="nav-link nav-link-me" href="{{ route('activity') }}">Activity</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Notifications</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        </div>

        <main class="">
            @yield('content')
        </main>
    </div>
</body>
</html>
