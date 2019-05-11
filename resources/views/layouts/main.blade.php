<!DOCTYPE html>
<html dir="@yield('direction')" lang="{{ app()->getLocale() }}" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{url('bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{url('dist/css/skins/_all-skins.min.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{url('bower_components/morris.js/morris.css')}}">
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
    {{-- <!-- Load Bootstrap3.3.7-rtl -->
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

   
    @yield('styles')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{url('/')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>S</b>AR</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Seo</b>AR</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
              
                <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="@yield('user-image')" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="@yield('user-image')" class="img-circle" alt="User Image">

                                <p>
                                    {{ Auth::user()->name }}
                                    <small>@yield('user-type')</small>
                                </p>
                            </li>                         
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">@lang('profile')</a>
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
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                    {{-- <!-- Languages Switcher --> --}}
                  <li class="dropdown" style="direction:ltr;">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="flag-icon flag-icon-{{config('app.flags')[app()->getLocale()]}}"></span>
                        {{-- <span class="caret"></span></a> --}}
                        <ul class="dropdown-menu">
                          <li><a href="{{ route('lang.dashboard',"ar") }}"><span class="flag-icon flag-icon-sa"></span> @lang('arabic') </a></li>
                          <li><a href="{{ route('lang.dashboard',"en") }}"><span class="flag-icon flag-icon-us"></span> @lang('english')</a></li>
                        </ul>
                      </li>
                </ul>
            
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
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
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">@lang("main-menu")</li>
                <li>
                    <a href="{{route('lang.dashboard',app()->getLocale())}}">
                        <i class="fa fa-dashboard"></i> <span>@lang("dashboard")</span>
                    </a>
                    {{-- <!--  <ul class="treeview-menu">
                       <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                       <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                     </ul> --> --}}
                </li>
                <li>
                    <a href="{{route('lang.page-optimization',app()->getLocale())}}">
                        <i class="fa fa-cogs"></i> <span>@lang("page-optimization")</span>
                    </a>
                    {{-- <!--  <ul class="treeview-menu">
                       <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                       <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                     </ul> --> --}}
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
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-file-text"></i> <span>@lang("reports")</span>
                        {{--<span class="pull-right-container">--}}
              {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('reports')}}"><i class="fa fa-circle-o"></i>@lang("reports-management")</a></li>
                        <li><a href="{{url('comprehensive-reports')}}"><i class="fa fa-circle-o"></i>@lang('comprehensive-reports')</a></li>
                        <li><a href="{{url('on-page-reports')}}"><i class="fa fa-circle-o"></i>@lang('onpage-reports')</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-binoculars"></i> <span>@lang('seo-tracker')</span>
                    </a>
                    {{-- <!--  <ul class="treeview-menu">
                       <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                       <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                     </ul> --> --}}
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-line-chart"></i> <span>@lang("keywords")</span>
                    </a>
                    {{-- <!--  <ul class="treeview-menu">
                       <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                       <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                     </ul> --> --}}
                </li>
                <li>
                    <a href="{{route('lang.backlinks-checker',app()->getLocale())}}">
                        <i class="fa fa-crosshairs"></i> <span>@lang("backlinks-checker")</span>
                    </a>
                    {{-- <!--  <ul class="treeview-menu">
                       <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                       <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                     </ul> --> --}}
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

              {{-- Print --}}
                <button type="button" onclick="printDiv('@yield('print-div')')" class="btn btn-primary {{in_array(app()->getLocale(),config('app.rtl')) ? "pull-left" : "pull-right"}}"> <span class="glyphicon glyphicon-save-file"></span> @lang('print')</button> 
   
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
            <b>@lang("version")</b> 1.0
        </div>&nbsp;       
      @lang('copyright-statement').
      <strong> &copy; 2019 </strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">الأنشطة الأخيرة</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">خصم 50%</h4>

                                <p>سيكون في الرابع من إبريل</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-user bg-yellow"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                <p>New phone +1(800)555-1234</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                <p>nora@example.com</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-file-code-o bg-green"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                <p>Execution time 5 seconds</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">العمليات الجارية</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                تصميم قالب مخصوص
                                <span class="label label-danger pull-right">70%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Update Resume
                                <span class="label label-success pull-right">95%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Laravel Integration
                                <span class="label label-warning pull-right">50%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Back End Framework
                                <span class="label label-primary pull-right">68%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">الإعدادات العامة</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            إرسال تقارير الإستخدام
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            بعض المعلومات عن هذا الخيار
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            تمكين إرسال الإيميلات
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            بعض المعلومات عن هذا الخيار
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            خيار أخر
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            بعض المعلومات عن هذا الخيار
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <h3 class="control-sidebar-heading">إعادات أخري</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            خيار أخر
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            تعطيل الإشعارات
                            <input type="checkbox" class="pull-right">
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            حذف السجلات
                            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                        </label>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
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
<!-- Morris.js charts -->
<script src="{{url('bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{url('bower_components/morris.js/morris.min.js')}}"></script>
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
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('dist/js/demo.js')}}"></script>
<!-- Print File -->
<script>
function printDiv(divID) {
  //Get the HTML of div
  var divElements = document.getElementById(divID).innerHTML;
  //Get the HTML of whole page
  var oldPage = document.body.innerHTML;

  //Reset the page's HTML with div's HTML only
  document.body.innerHTML =
      "<html><head><title>@yield('title')</title></head><body>" +
      divElements + "</body>";

  //Print Page
  window.print();
//   setTimeout(function () { window.print(); }, 500);
//   window.onfocus = function () { setTimeout(function () { window.close(); }, 500); }

  //Restore orignal HTML
  document.body.innerHTML = oldPage;
}
</script>
@yield('scripts')
</body>
</html>
