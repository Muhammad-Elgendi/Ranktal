<!DOCTYPE html>
<html dir="{{ in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr" }}"  lang="{{ app()->getLocale() }}" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ucfirst(config('app.name'))}}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- flag-icon -->
    <link rel="stylesheet" href="{{url('bower_components/flag-icon-css/css/flag-icon.min.css')}}">

    @if(in_array(app()->getLocale(),config('app.rtl')))
  
   {{-- <!-- Load Bootstrap3.3.7-rtl -->
    <link rel="stylesheet" href="{{url('bower_components/bootstrap-3.3.7-rtl/css/bootstrap.min.css')}}"> --}}

      <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="{{url('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
      
    <!-- Load bootstrap-rtl-ondemand -->
    <link rel="stylesheet" href="{{url('bower_components/bootstrap-rtl-ondemand/dist/css/bootstrap-rtl-ondemand.min.css')}}">

  
    @else
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{url('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    @endif
    
    <link href="{{ asset('css/membership.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <!-- Branding Image -->
                <a class="{{ in_array(app()->getLocale(),config('app.rtl')) ? "navbar-brand navbar-right" : "navbar-brand" }}" href="{{ url('/') }}">
                    {{ucfirst(config('app.name'))}}
                </a>

                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>


                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('lang.login', app()->getLocale()) }}">@lang('signin')</a></li>
                            <li><a href="{{ route('lang.register', app()->getLocale()) }}">@lang('signup')</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('lang.logout', app()->getLocale()) }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            @lang('logout')
                                        </a>

                                        <form id="logout-form" action="{{ route('lang.logout', app()->getLocale()) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                        {{-- <!-- Languages Switcher --> --}}
                        <li class="dropdown" style="direction:ltr;">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="flag-icon flag-icon-{{config('app.flags')[app()->getLocale()]}}"></span>
                            {{-- <span class="caret"></span></a> --}}
                            <ul class="dropdown-menu">
                            <li><a href="{{ route('lang.home',"ar") }}"><span class="flag-icon flag-icon-sa"></span> @lang('arabic') </a></li>
                            <li><a href="{{ route('lang.home',"en") }}"><span class="flag-icon flag-icon-us"></span> @lang('english')</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
