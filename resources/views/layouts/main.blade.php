<!DOCTYPE html>
<html dir="@yield('direction')" lang="{{ app()->getLocale() }}" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') &#8211; {{ucfirst(config('app.name'))}}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TRPFQH5');</script>
    <!-- End Google Tag Manager -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{url('bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('dist/css/AdminLTE.min.css')}}">

    {{-- 

        ! Note

        <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. 
        To load all skins load _all-skins.min.css from skins folder
        But I am using skin-blue-light.css--> 
        
    --}}
    <!-- AdminLTE blue-light skin -->
    <link rel="stylesheet" href="{{url('dist/css/skins/skin-blue-light.css')}}">


    <!-- jvectormap -->
    <link rel="stylesheet" href="{{url('bower_components/jvectormap/jquery-jvectormap.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet"
          href="{{url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{url('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">

    @if (in_array(app()->getLocale(),config('app.rtl')))

    {{-- <!-- Load Bootstrap3.3.7-rtl (bootstrap rtl older version) -->
    <link rel="stylesheet" href="{{url('bower_components/bootstrap-3.3.7-rtl/css/bootstrap.min.css')}}"> --}}

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{url('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
      
    <!-- Load bootstrap-rtl-ondemand -->
    <link rel="stylesheet" href="{{url('bower_components/bootstrap-rtl-ondemand/dist/css/bootstrap-rtl-ondemand.min.css')}}">

    <!-- AdminLTE-RTL style -->
    <link rel="stylesheet" href="{{url('dist/css/rtl.css')}}">
    @else
      <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="{{url('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    @endif

    <!-- flag-icon -->
    <link rel="stylesheet" href="{{url('bower_components/flag-icon-css/css/flag-icon.min.css')}}">

   <!-- App stylesheet -->
   <link rel="stylesheet" href="{{url('css/main.css')}}">

    <!-- favicon -->
    <link rel="icon" href="{{url('img/favicon.ico')}}">
    
    @yield('styles')

    <meta name="robots" content="noindex">
</head>

    {{--
    Skins

    Skins can be found in the dist/css/skins folder.
    Choose the skin file that you want and then add the appropriate class to the body tag 
    to change the template's appearance.
    Here is the list of available skins: 

    skin-blue	
    skin-blue-light	
    skin-yellow	
    skin-yellow-light	
    skin-green	
    skin-green-light	
    skin-purple	
    skin-purple-light	
    skin-red	
    skin-red-light	
    skin-black	
    skin-black-light
    
    --}}

<body class="hold-transition skin-blue-light sidebar-mini">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TRPFQH5"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{route('lang.dashboard', app()->getLocale())}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">
                <i class="fa fa-location-arrow"></i>
            </span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <i class="fa fa-location-arrow"></i>
                {{ucfirst(config('app.name'))}}
            </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                {{-- <!-- Languages Switcher --> --}}
                @if(!((Auth::check() && isset(Auth::user()->language))))
                    <li class="dropdown" style="direction:ltr;">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="flag-icon flag-icon-{{config('app.flags')[app()->getLocale()]}}"></span>
                        {{-- <span class="caret"></span></a> --}}
                        <ul class="dropdown-menu">
                        {{-- Dynamic detect localization of current path --}}
                        @if(in_array(substr(Request::path(),0,2),config('app.locales')))
                            <li><a href="{{ url('ar/'.substr(Request::path(),3)) }}"><span class="flag-icon flag-icon-sa"></span> @lang('arabic') </a></li>
                            <li><a href="{{ url('en/'.substr(Request::path(),3))  }}"><span class="flag-icon flag-icon-us"></span> @lang('english')</a></li>
                        @else
                            <li><a href="{{ url('ar/'.Request::path()) }}"><span class="flag-icon flag-icon-sa"></span> @lang('arabic') </a></li>
                            <li><a href="{{ url('en/'.Request::path())  }}"><span class="flag-icon flag-icon-us"></span> @lang('english')</a></li>
                        @endif
                        </ul>
                    </li>
                @endif
                                   
                <!-- User Account: style can be found in dropdown.less -->
                @auth
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ Auth::user()->photo }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ Auth::user()->photo }}" class="img-circle" alt="User Image">

                                <p>
                                    {{ Auth::user()->name }}    
                                    <small>
                                        @if(isset(Auth::user()->company))
                                            <i class="fa fa-building" aria-hidden="true"></i>
                                            {{ Auth::user()->company }} 
                                        @endif
                                    </small>                                
                                    <small>
                                        @if(empty(Auth::user()->plan) || Auth::user()->plan == "Trial" )
                                        @lang('Trial')
                                        @else
                                        {{ __(Auth::user()->plan) }}
                                        @endif
                                    </small>
                                </p>
                            </li>                         
                            <!-- Menu Footer-->
                            <li class="user-footer">

                                {{-- settings button --}}
                                <div class="pull-right">
                                    <a href="{{ route('lang.settings', app()->getLocale()) }}" class="btn btn-default btn-flat">@lang('settings')</a>
                                </div>
                                
                                <div class="pull-left">
                                    <a href="{{ route('lang.logout', app()->getLocale()) }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                       class="btn btn-default btn-flat">@lang('logout')</a>
                                    <form id="logout-form" action="{{ route('lang.logout', app()->getLocale()) }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                    @endauth
                    <!-- Control Sidebar Toggle Button -->
                    {{-- <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li> --}}
                   
                </ul>
            
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            {{-- <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-right image">
                    <img src="@yield('user-image')" class="img-circle" alt="User Image">
                </div>
                
              <div class="pull-right info" style="{{in_array(app()->getLocale(),config('app.rtl')) ? "overflow: hidden;
                  width: 124px;" : "left:0;overflow: hidden;width: 162px;"}}">
                    <p>{{ Auth::user()->name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i>@lang('online')</a>
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="@lang('search-placeholder') ...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form --> --}}
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li>
                    <a href="{{route('lang.dashboard',app()->getLocale())}}">
                        <i class="fa fa-dashboard"></i> <span>@lang("dashboard")</span>
                    </a>                   
                </li>

                <li class="header">@lang("on-page-tools")</li>
           
                <li>
                    <a href="{{route('lang.page-optimization',app()->getLocale())}}">
                        <i class="fa fa-cogs"></i> <span>@lang("page-optimization")</span>
                    </a>                
                </li>
                <li>
                    <a href="{{route('lang.seo-audit',app()->getLocale())}}">
                        <i class="fa fa-calendar-check-o"></i> <span>@lang('seo-audit')</span>
                    </a>            
                </li>
                {{--<li>--}}
                {{--<a href="#">--}}
                {{--<i class="fa fa-file-text"></i> <span>إعداد التقارير</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                {{--<li class="active"><a href="{{url('reports')}}"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>--}}
                {{--<li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>--}}
                {{--</ul>--}}
                {{--</li>--}}
                <li>
                    <a href="{{route('lang.on-demand-crawl',app()->getLocale())}}">
                        <i class="fa fa-bug"></i> <span>@lang('on-demand-crawl')</span>
                    </a>     
                </li>
                
                <li>
                    <a href="{{route('lang.seo-campaigns',app()->getLocale())}}">
                        <i class="fa fa-bullhorn"></i> <span>@lang('seo-campaigns')</span>
                    </a>
                    @auth
                    <ul class="treeview-menu">
                        @foreach(Auth::user()->campaigns as $campaign)
                            <li><a href="{{route('lang.seo-campaign-view',['lang'=> app()->getLocale(),'id'=> $campaign->id])}}"><i class="fa fa-bullhorn"></i>{{$campaign->name}}</a></li>
                        @endforeach
                        <li><a href="{{route('lang.seo-campaign-create',app()->getLocale())}}"><i class="fa fa-plus"></i>@lang('create-campaign')</a></li>
                     </ul>
                     @endauth
                </li>
              

                {{-- Old seo report tool --}}
                {{-- <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text"></i> <span>@lang("reports")</span>
                            {{--<span class="pull-right-container">--}}
                  {{--<i class="fa fa-angle-left pull-right"></i>--}}
                {{--</span>--}}
                        {{-- </a> 
                        <ul class="treeview-menu">
                            <li><a href="{{url('reports')}}"><i class="fa fa-circle-o"></i>@lang("reports-management")</a></li>
                            <li><a href="{{url('comprehensive-reports')}}"><i class="fa fa-circle-o"></i>@lang('comprehensive-reports')</a></li>
                            <li><a href="{{url('on-page-reports')}}"><i class="fa fa-circle-o"></i>@lang('onpage-reports')</a></li>
                        </ul>
                    </li>      --}}

                {{-- Keywords tools --}}
                {{-- <li class="header">@lang("keywords")</li>
                <li>
                    <a href="{{route('lang.keyword-tracker',app()->getLocale())}}">
                        <i class="fa fa-line-chart"></i> <span>@lang("keywords-tracker")</span>
                    </a> --}}
                    {{-- <!--  <ul class="treeview-menu">
                       <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                       <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                     </ul> --> --}}
                {{-- </li>
                <li>
                    <a href="{{route('lang.keyword-research',app()->getLocale())}}">
                        <i class="fa fa-bolt"></i> <span>@lang('keyword-research')</span>
                    </a> --}}
                    {{-- <!--  <ul class="treeview-menu">
                       <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                       <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                     </ul> --> --}}
                {{-- </li> --}}

                {{-- Backlinks  --}}
                {{-- <li class="header">@lang("backlinks")</li>
                <li>
                    <a href="{{route('lang.backlinks-checker',app()->getLocale())}}">
                        <i class="fa fa-crosshairs"></i> <span>@lang("backlinks-checker")</span>
                    </a>              
                </li>   --}}
            
                <li class="header">@lang("support")</li>       
                <li>
                        <a href="{{config('app.homepage')}}/contact-us" target="_blank">
                            <i class="fa fa-life-ring"></i> <span>@lang("help-desk")</span>
                        </a>                     
                    </li>     
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
       
              <h1>@yield('title')</h1>
              {{-- <!-- <small>Control panel</small> --> --}}
        
              {{-- <!--       <ol class="breadcrumb">
                      <li><a href="#"><i class="fa fa-dashboard"></i> الرئيسيه</a></li>
                      <li class="active">لوحة التحكم</li>
                    </ol> --> --}}

              {{-- Buttons Section --}}
              <div id="btns-section" class="{{in_array(app()->getLocale(),config('app.rtl')) ? "pull-left" : "pull-right"}}">  
                <button type="button" onclick="printDiv('@yield('print-div')')" id="print-btn" style="display:none;" class="btn btn-primary"> <i class="fa fa-print"></i> @lang('print')</button> 
              </div>

            <div class="clearfix"></div>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-left hidden-xs">
            <b>@lang("version")</b> 1.1
        </div>&nbsp;       
      @lang('copyright-statement').
      <strong> &copy; 2021 </strong>
    </footer>
    {{-- <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar --> --}}
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{url('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{url('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{url('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{url('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{url('bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{url('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{url('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('dist/js/adminlte.min.js')}}"></script>
<script>
function printDiv(divID) {
  //Get the HTML of div
  var divElements = document.getElementById(divID).innerHTML;
  //Get the HTML of whole page
  var oldPage = document.body.innerHTML;

  //Reset the page's HTML with div's HTML only
  document.body.innerHTML =
      "<html><head><title>@yield('title')</title></head><body><div style=\"margin: 0 15px 0 15px;\">" +
      divElements + "</div></body>";

  //Print Page
  window.print();
//   setTimeout(function () { window.print(); }, 500);
//   window.onfocus = function () { setTimeout(function () { window.close(); }, 500); }

  //Restore orignal HTML
  document.body.innerHTML = oldPage;
}

/**
* jQuery polyfill to handle beforeprint/afterprint on webkit-based browsers.
*/
(function ($) {
  // TODO: for some reason events are coming twice, need to debounce them
  if ((window.onbeforeprint === undefined || window.onafterprint === undefined)
    && window.matchMedia
  ) {
    var mediaQueryList = window.matchMedia('print');
    mediaQueryList.addListener(function (mql) {
      if (mql.matches) {
        $(window).trigger('beforeprint');
      } else {
        $(window).trigger('afterprint');
      }
    });
  }
})(jQuery);

$(document).ready(function () {
    $('ul.sidebar-menu li a').each(function (index, value) {
        if($(this).attr('href') == window.location.href){
            $(this).parent().addClass('active');
        }
    });
    $('ul.sidebar-menu ul.treeview-menu li a').each(function (index, value) {
        if($(this).attr('href') == window.location.href){
            $(this).parent().addClass('active');
            $(this).parent().parent().show();
        }
    });
});


</script>
@yield('scripts')
</body>
</html>
