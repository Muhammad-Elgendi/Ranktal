<!DOCTYPE html>
<html dir="@yield('direction')" lang="{{ app()->getLocale() }}" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') &#8211; {{ucfirst(config('app.name'))}}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('bower_components/font-awesome/css/font-awesome.min.css')}}">
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

   <!-- App stylesheet -->
   <link rel="stylesheet" href="{{url('css/main.css')}}">

    @yield('styles')
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

<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{ env('HOME_PAGE') }}" class="logo">
      
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <i class="fa fa-location-arrow"></i>
                {{ucfirst(config('app.name'))}}
            </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            
      
        </nav>
    </header> 

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin: 0;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
       
            <h1>@yield('title')</h1>  

            <div class="clearfix"></div>

        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer" style="margin: 0;" >
      @lang('copyright-statement').
      <strong> &copy; 2021 </strong>
    </footer>
    {{-- <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar --> --}}
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
</body>
</html>
