<!doctype html>
{{-- NAVIGATION BAR --}}
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
            border-bottom: 2px solid blue;
        }
        .border-b:hover{
            border-bottom: 2px solid blue;
        }
        .strong {
            font-weight: bold;
        }
         a .readMore {
             display: none;
         }

        a .readLess {
            display: inline;
        }

        a.collapsed .readMore {
            display: inline;
        }

        a.collapsed .readLess {
            display: none;
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

                            @if (Route::is('home'))
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Categories
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" style="width:250%; " aria-labelledby="navbarDropdown">
                                        <form class="d-flex justify-content-center" action="/categories" method="POST">
                                            @csrf
                                            <div class="">
                                                <div class="form-group row"></div>

                                                <input type="checkbox" name="categories[]" value="News" {{ ($categories['News']) ? 'checked' : '' }} > News<br/>
                                                <input type="checkbox" name="categories[]" value="Showbizz/Entertainment" {{ ($categories['Showbizz/Entertainment']) ? 'checked' : '' }} > Showbizz/Entertainment<br/>
                                                <input type="checkbox" name="categories[]"  value="Royals" {{ ($categories['Royals']) ? 'checked' : '' }} > Royals<br/>
                                                <input type="checkbox" name="categories[]"  value="Food/Recipes" {{ ($categories['Food/Recipes']) ? 'checked' : '' }} > Food/Recipes<br/>
                                                <input type="checkbox" name="categories[]"  value="Lifehacks" {{ ($categories['Lifehacks']) ? 'checked' : '' }} > Lifehacks<br/>
                                                <input type="checkbox" name="categories[]"  value="Fashion" {{ ($categories['Fashion']) ? 'checked' : '' }} > Fashion<br/>
                                                <input type="checkbox" name="categories[]"  value="Beauty" {{ ($categories['Beauty']) ? 'checked' : '' }} > Beauty<br/>
                                                <input type="checkbox" name="categories[]"  value="Health" {{ ($categories['Health']) ? 'checked' : '' }} > Health<br/>
                                                <input type="checkbox" name="categories[]"  value="Family" {{ ($categories['Family']) ? 'checked' : '' }} > Family<br/>
                                                <input type="checkbox" name="categories[]"  value="House and garden" {{ ($categories['House and garden']) ? 'checked' : '' }} > House and Garden<br/>
                                                <input type="checkbox" name="categories[]"  value="Cleaning" {{ ($categories['Cleaning']) ? 'checked' : '' }} > Cleaning<br/>
                                                <input type="checkbox" name="categories[]"  value=" Lifestyle" {{ ($categories['Lifestyle']) ? 'checked' : '' }} > Lifestyle<br/>
                                                <input type="checkbox" name="categories[]" value="Cars" {{ ($categories['Cars']) ? 'checked' : '' }} > Cars<br/>
                                                <input type="checkbox" name="categories[]"  value="Crime" {{ ($categories['Crime']) ? 'checked' : '' }} > Crime<br/>

                                                <div class="form-group row mb-0">
                                                    <div class="col-md-6 offset-3 pt-3">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('Submit') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            @endif

                            <li class="{{ (request()->is('activity')) ? 'strong' : ''}}">
                               <a class="nav-link nav-link-me" href="{{ route('activity') }}">Activity</a>
                            </li>
                            <li class="{{ (request()->is('calendar')) ? 'strong' : ''}}">
                                <a class="nav-link nav-link-me" href="{{ route('calendar') }}">Calendar</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Notifications</a>
                                    <a class="dropdown-item" href="{{route('my_activity')}}">My Activity</a>
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
