<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kotobi') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Kotobi') }}
                </a>

                @if(Auth::check())
                <ul class="navbar-nav mr-auto">
                    @if(Auth::user()->is_admin)
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/admin/users') }}">
                                Users
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/book') }}">
                                Books
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/category') }}">
                                Categories
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/book/chart') }}">
                                Books Profit
                            </a>
                        </li>
                    @else
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/') }}">
                                My Books
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/') }}">
                                Favourite Books
                            </a>
                        </li>
                    @endif
                </ul>
                @endif
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

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
                                Welcome {{ Auth::user()->username }} <span class="caret"></span>
                                @if(Auth::user()->avatar  != null)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="border border-success rounded-circle" width="45px" height="45px" alt="...">
                                @else
                                    <img src="{{ asset('images/' . 'default.jpg') }}" class="border border-success rounded-circle" width="45px" height="45px" alt="...">
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
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
        </main>
    </div>
    @stack('scripts')
</body>

</html>