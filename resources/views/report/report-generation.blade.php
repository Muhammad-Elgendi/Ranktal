@extends('layouts.main')
@section('title','إعداد تقرير شامل')
@section('user-image',url('/img/user.png'))
@section('user-type','الخطة العادية')
@section('styles')
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="{{url('/css/report-generation.css')}}">
    <script>
        var reportURL = "{{ url("load-report/".$id) }}";
        var regenerateURL="{{ url("regenerate-report/".$id) }}";
    </script>
    <script type="text/javascript" src="{{url('/js/report-gen.js')}}"></script>
    <script type="text/javascript" src="{{url('/js/report-gen-change.js')}}"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>--}}
    {{--<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>--}}
    {{--<script type="text/javascript" src="{{url('/jspdf/jspdf.min.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{url('/jspdf/plugins/from_html.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{url('/jspdf/plugins/split_text_to_size.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{url('/jspdf/plugins/standard_fonts_metrics.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{url('/jspdf/plugins/ttffont.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{url('/jspdf/plugins/ttffont.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{url('/jspdf/plugins/ttfsupport.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{url('/jspdf/plugins/utf8.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{url('/jspdf/plugins/arabic.js')}}"></script>--}}
@endsection



@section('content')

    <div id="content-container">

        <nav class="navbar my-nav">
            <ul class="nav nav-pills my-nav nav-justified">
                <li><a href="#section1">نظره عامه</a></li>
                <li><a href="#section2">سيو داخلي</a></li>
                <li><a href="#off-page">سيو خارجي</a></li>
                <li><a href="#section3">سهولة الإستخدام</a></li>
                <li><a href="#section4">الموبايل</a></li>
                <li><a href="#section5">تقنيات</a></li>
                <li><a href="#section6">الزوار</a></li>
                <li><a href="#section7">تحليل الروابط</a></li>
            </ul>
        </nav>
        <div id="report-pdf" class="report-container" data-spy="scroll" data-target=".navbar" data-offset="50">
            <div id="section1" class="container-fluid">
                <div id="process-container" class="progress">
                    <div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                        0%
                    </div>
                    {{--<span>60 %</span>--}}
                </div>
                <div id="screen" class="col-xs-3 transparency">
                    {{--<div class="row">--}}
                    {{--<div>--}}
                    {{--<p class="center">جاري تحميل الصورة ...</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                    {{--<div>--}}
                    {{--<p class="center">--}}
                    {{--<img src="{{url('/img/Rolling.gif')}}"/>--}}
                    {{--</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <div>
                        <p class="center computer">
                            <img src="{{url('/img/Rolling.gif')}}" class='my-img loading'>
                        </p>
                    </div>
                </div>
                <div class="col-xs-7">
                    <div id="url-container">
                        <a id="url" href="#" target="_blank"></a>
                    </div>
                    <p >الوقت<strong class="my-time-dashboard" id="date">جاري التحميل ...</strong></p>
                    <div class="progressBox margin-bottom">
                        <span class="scoreProgress-label passedBox my-indicator">الصحيح</span>
                        <div class="scoreProgress scoreProgress-xs scoreProgress-success">
                            <div id="passScore" aria-valuemax="100" aria-valuenow="2" aria-valuemin="0" role="progressbar" class="scoreProgress-bar" style="width: 2%;">
                                <span class="scoreProgress-value">2%</span>
                            </div>
                        </div>
                    </div>
                    <div class="progressBox margin-bottom">
                        <span class="scoreProgress-label errorBox my-indicator">الأخطاء</span>
                        <div class="scoreProgress scoreProgress-xs scoreProgress-danger">
                            <div id="errorScore" aria-valuemax="100" aria-valuenow="2" aria-valuemin="0" role="progressbar" class="scoreProgress-bar" style="width: 2%;">
                                <span class="scoreProgress-value">2%</span>
                            </div>
                        </div>
                    </div>
                   <div>
                       <a id="download-btn" href='javascript:;' onclick='downloadReport();' class="btn btn-success" role="button">تنزيل التقرير<i class="fa fa-download my-icon" aria-hidden="true"></i></a>
                       <a id="reanalyse-btn" href='#'  class="btn btn-warning" role="button">إعادة الفحص<i class="fa fa-refresh my-icon" aria-hidden="true"></i></a>
                   </div>
                </div>
                <div class="col-xs-2">
                    <div class="row" id="scoreRow">
                        <p id="score"><i>عدد الأخطاء</i></p>
                    </div>
                    <div class="row">
                        <p id="overallscore"><strong>0</strong></p>
                    </div>
                </div>

            </div>
            <div id="section2" class="container-fluid">
                <div id="title-section" class="transparency">
                    <h2 class="seoBox-title">وسم العنوان</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="url-section" class="transparency">
                    <h2 class="seoBox-title">الرابط</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="description-section" class="transparency">
                    <h2 class="seoBox-title">وسم الوصف</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="keywords-section" class="transparency">
                    <h2 class="seoBox-title">الكلمات المفتاحية</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="newskeywords-section" class="transparency">
                    <h2 class="seoBox-title">الكلمات المفتاحية للأخبار</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="robots-section" class="transparency">
                    <h2 class="seoBox-title">وسم Robots</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="meta-section" class="transparency">
                    <h2 class="seoBox-title">وسوم Meta</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="canonical-section" class="transparency">
                    <h2 class="seoBox-title">الرابط الأساسي Canonical</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="headings-section" class="transparency">
                    <h2 class="seoBox-title">وسوم Headings</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="texthtmlratio-section" class="transparency">
                    <h2 class="seoBox-title">نسبة النص إلي كود Html</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="altimg-section" class="transparency">
                    <h2 class="seoBox-title">النص البديل للصور</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="frames-section" class="transparency">
                    <h2 class="seoBox-title">الإطارات</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="map-section" class="transparency">
                    <h2 class="seoBox-title">خريطة الموقع</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="robotstxt-section" class="transparency">
                    <h2 class="seoBox-title">ملف robots.txt</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="structuredData-section" class="transparency">
                    <h2 class="seoBox-title">البيانات المنظمه</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="microfromats-section" class="transparency">
                    <h2 class="seoBox-title">MicroFormats</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="FormattedText-section" class="transparency">
                    <h2 class="seoBox-title">نصوص منسقه</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="Flash-section" class="transparency">
                    <h2 class="seoBox-title">مكونات Flash</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="indexability-section" class="transparency">
                    <h2 class="seoBox-title">قابلية الفهرسه</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
            </div>
            <div id="off-page" class="container-fluid">
                <div id="metrics-section" class="transparency">
                    <h2 class="seoBox-title">مقاييس الموقع</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="backlinks-section" class="transparency">
                    <h2 class="seoBox-title">الباك لينكس Backlinks</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
            </div>
            <div id="section3" class="container-fluid">
                <div id="language-section" class="transparency">
                    <h2 class="seoBox-title">اللغة</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="favicon-section" class="transparency">
                    <h2 class="seoBox-title">أيقونة الموقع</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="pageinsightDesk-section" class="transparency">
                    <h2 class="seoBox-title">إحصاءات سرعة الصفحة (سطح المكتب)</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
            </div>
            <div id="section4" class="container-fluid">
                <div id="viewport-section" class="transparency">
                    <h2 class="seoBox-title">وسم Viewport</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="screenMob-section" class="transparency">
                    <h2 class="seoBox-title">شكل الموقع في الموبايل</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="pageinsightMob-section" class="transparency">
                    <h2 class="seoBox-title">إحصاءات سرعة الصفحة (الموبايل)</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
            </div>
            <div id="section5" class="container-fluid">
                <div id="AMP-section" class="transparency">
                    <h2 class="seoBox-title">صفحة الجوّال المسرَّعة AMP</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="openGraph-section" class="transparency">
                    <h2 class="seoBox-title">بروتوكول Open Graph</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="TwitterCard-section" class="transparency">
                    <h2 class="seoBox-title">كرت Twitter</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="serverInfo-section" class="transparency">
                    <h2 class="seoBox-title">الخادم</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="doctype-section" class="transparency">
                    <h2 class="seoBox-title">نوع الصفحة</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="encoding-section" class="transparency">
                    <h2 class="seoBox-title">ترميز الصفحة</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
                <div id="redirects-section" class="transparency">
                    <h2 class="seoBox-title">تحويلات الرابط</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
            </div>
            <div id="section6" class="container-fluid">
                <div id="alexa-section" class="transparency">
                    <h2 class="seoBox-title">أليكسا Alexa</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
            </div>
            <div id="section7" class="container-fluid">
                <div id="linkanalysis-section" class="transparency">
                    <h2 class="seoBox-title">تحليل الروابط</h2>
                    <p class="center"> جاري التحميل ...
                        <img src="{{url('/img/Rolling.gif')}}">
                    </p>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
@endsection