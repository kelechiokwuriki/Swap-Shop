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
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{-- <link href="https://getbootstrap.com/docs/4.0/examples/dashboard/dashboard.css" rel="stylesheet"> --}}

    {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> --}}

    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('custom.css') }}" rel="stylesheet" type="text/css" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">


        <nav class="navbar sticky-top navbar-expand-md navbar-light bg-white shadow-sm">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                @if(Auth::check())


                    <!--only show navigation if user has accepted terms of service-->
                    @if(Auth::user()->accepted_terms_of_service !== null)

                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a href="/home" class="nav-link"><i class="fas fa-home pr-1"></i>Home</a>
                            </li>
                            <li class="nav-item active">
                                <a href="/listings" class="nav-link"><i class="far fa-list-alt pr-1"></i>Listings</a>
                            </li>
                            <li class="nav-item active">
                                <a href="/events" class="nav-link"><i class="far fa-calendar-alt pr-1"></i>Events</a>
                            </li>
                            @if(Auth::user()->hasRole('admin'))
                                <li class="nav-item active">
                                    <a href="{{ route('admin.index') }}" class="nav-link"><i class="fas fa-tachometer-alt pr-1"></i>Admin Dashboard</a>
                                </li>
                            @endif

                        </ul>

                    @endif
                    <!--end terms of service checker-->

                @endif

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right dropitem" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <!--only show navigation if user has accepted terms of service-->

                                @if(Auth::user()->accepted_terms_of_service !== null)


                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        Profile
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                @endif

                                <!--end terms of service checker-->

                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>



        <main id="main" class="py-4">

            @yield('content')
        </main>
    </div>

    <script>
        window.Laravel = {!!json_encode([
            "apiToken" => auth()->user()->api_token ?? null
        ]) !!};
    </script>
</body>
</html>
