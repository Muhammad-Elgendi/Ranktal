@extends('layouts.app')
@section('title','SEO auditor')

@section('styles')
    <style>
        @font-face {
            font-family: dubai;
            src: url({{url('fonts/dubai.ttf')}});
        }

        body {
            direction: rtl;
            font-family: 'dubai', sans-serif;
            margin: 10px 15px 0 15px;
            background-color: #FFFFFF;
        }

        .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
            float: right;
            direction: rtl;
        }

        .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
            float: right;
            direction: rtl;
        }

        .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            float: right;
            direction: rtl;
        }

        .container-fluid {
            direction: rtl;
        }

        .header-elements {
            direction: rtl;
        }

        .container {
            border: 1px solid #b1b7ba;
            margin-top: 30px;
            padding: 10px 10px 10px 10px;
        }

        h1 {
            font-size: 30px;
            padding: 3px 15px 5px 5px;
            margin: 0 auto;
            width: fit-content !important;
            float: right;
        }

        h2 {
            font-size: 20px;
            font-weight: bold;
            margin: 0 0 1rem 10px;
            width: fit-content !important;
            float: right;
        }

        .success {
            height: 40px;
            background: #e8f9e0;
            border: #91c89c solid 1px;
            border-radius: 5px;
            box-sizing: unset;
            margin-bottom: 10px;
        }

        .fail {
            height: 40px;
            background: #f9e4e1;
            border: #fca88a solid 1px;
            border-radius: 5px;
            box-sizing: unset;
            margin-bottom: 10px;
        }

        .warn {
            background: #e3e3e3;
            height: 40px;
            border: #b2b2b2 solid 1px;
            border-radius: 5px;
            box-sizing: unset;
            margin-bottom: 10px;
        }

        .big-success {
            color: #2ca02c;
            font-size: 30px;
            padding: 4px 5px 0px 0px;

        }

        .big-fail {
            color: #f44b5e;
            font-size: 30px;
            padding: 4px 5px 0px 0px;
        }

        .big-warn {
            color: #b1b7ba;
            font-size: 30px;
            padding: 4px 5px 0px 0px;
        }

        .success-mark {
            color: #2ca02c;
            font-size: 20px;
            padding-right: 5px;

        }

        .fail-mark {
            color: #f44b5e;
            font-size: 20px;
            padding-right: 5px;
        }

        .warn-mark {
            color: #b1b7ba;
            font-size: 20px;
            padding-right: 5px;
        }

        p {
            float: right;
        }

        .clear {
            clear: both;
        }

        .padding-bottom {
            padding-bottom: 25px;
        }

        .info {
            float: right;
            margin-left: 5px;
        }

        .padding-top {
            padding-top: 5px;
        }

        .my-blue {
            color: #0C5460;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
            word-wrap: break-word;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
            #overflow: hidden;
            #text-overflow: ellipsis;

        }

        .col1links {
            width: 70%;
        }

        .col2links {
            width: 20%;
        }

        .col3links {
            width: 10%;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .center {
            text-align: center;
        }

        .center-block {
            width: 50%;
            margin: 0 auto;
        }

        @media print {

        }

    </style>
@endsection

@section('content')

    <h3 class="container center">فحص عوامل الترتيب</h3>
    <!-- Url Result-->
    <div class="container">
        @if ($audit->checkUrl == true)
            <div class="success">
                <h1>رابط الصفحه</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->checkUrl == false)
            <div class="fail">
                <h1>رابط الصفحه</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                يعد وجود الكلمه المفتاحيه بإسم النطاق الخاص بموقعك أو رابط الصفحه عامل مهم يمثل نسبة 2% من العوامل التي
                يرتب بها جوجل نتائج البحث، ويجب الفصل بين الكلمات وبعضها بشرطة "-" Dash بدلا من المسافة العادية
                <br>
                مثال :
                كلمة-مفتاحيه-للموضوع-أو-المقال-أو-عنوان-الموضوع/www.example.com
            </article>
            <div class="clear padding-top">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن لا يتعدي طول الرابط 200 حرف</p>
            </div>
            <div class="clear">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن تكون حالة الرابط 200 أو 301 أو 404 أو 503</p>
            </div>
            <div class="clear padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن لا يحتوي الرابط علي مسافات</p>
            </div>
        </div>
        <div class="clear">
            <h2>الرابط</h2>
            <p>{{$audit->url}}</p>
        </div>
        <div class="clear">
            <h2>طول الرابط</h2>
            <p>{{$audit->lengthUrl}} حرف</p>
            @if ($audit->checkLengthUrl == true)
                <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
            @elseif ($audit->checkLengthUrl == false)
                <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
            @else

            @endif
        </div>
        <div class="clear">
            <h2>حالة الرابط</h2>
            <p>{{$audit->statusUrl}}</p>
            @if ($audit->checkStatusUrl == true)
                <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
            @elseif ($audit->checkStatusUrl == false)
                <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
            @else

            @endif
        </div>
        <div class="clear">
            <h2>عدد المسافات الموجودة فى الرابط</h2>
            <p>{{$audit->spacesUrl}}</p>
            @if ($audit->checkSpacesUrl == true)
                <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
            @elseif ($audit->checkSpacesUrl == false)
                <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
            @else

            @endif
        </div>
        <div class="clear">
            <h2>رابط الأرشفه</h2>
            <p><a href="{{$audit->googleCacheUrl}}">{{$audit->googleCacheUrl}}</a></p>
        </div>
        <div class="clear">
            <h2>إسم النطاق</h2>
            <p>{{$audit->domain}}</p>
        </div>
        <div class="clear padding-bottom">
            <h2>طول إسم النطاق</h2>
            <p>{{$audit->domainLength}} حرف</p>
        </div>
    </div>
    <!-- Title Result-->
    <div class="container">
        @if ($audit->checkTitle == true)
            <div class="success">
                <h1>عنوان الصفحه</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->checkTitle == false)
            <div class="fail">
                <h1>عنوان الصفحه</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                يعد عنوان الصفحه من أهم العوامل المهمه جداً ، و يقوم جوجل بإعادة كتابة هذا العنوان في حالات قليله جداً
                مثلاً إذا كان العنوان لا يناسب جملة البحث ولكن الصفحة تحتوي علي شيء يخص جملة البحث
            </article>
            <div class="clear padding-top">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن يحتوي العنوان علي أهم الكلمات المفتاحيه التي تستهدفها بهذه الصفحه</p>
            </div>
            <div class="clear">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن يكون لكل صفحه في موقعك عنوان فريد خاص بها</p>
            </div>
            <div class="clear padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن تحتوي الصفحه علي وسم عنوان واحد فقط</p>
            </div>
            <div class="clear padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن يكون طول العنوان مناسباً بحيث لا يقل عن 10 أحرف ولا يزيد عن 60 حرف</p>
            </div>
        </div>
        @if($audit->hasTitle == true)
            <div class="clear">
                <h2>العنوان</h2>
                <p>{{$audit->title}}</p>
                @if ($audit->hasTitle == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif ($audit->hasTitle == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
            <div class="clear">
                <h2>طول العنوان</h2>
                <p>{{$audit->lengthTitle}} حرف</p>
                @if ($audit->checkLengthTitle == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif ($audit->checkLengthTitle == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
            <div class="clear">
                <h2>الصفحة تحتوي علي عنوان واحد فقط</h2>
                @if (!$audit->duplicateTitle == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif (!$audit->duplicateTitle == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
        @elseif($audit->hasTitle ==false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>الصفحة لا تحتوي علي عنوان</p>
            </div>
        @else

        @endif
    </div>

    <!-- Description Result-->
    <div class="container">
        @if ($audit->checkDescription == true)
            <div class="success">
                <h1>وصف الصفحه</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->checkDescription == false)
            <div class="fail">
                <h1>وصف الصفحه</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                يعد وصف الصفحه بالانجليزيه Description meta tag من أهم وسوم Meta التي يجب عليك كتابتها بدقه فهي أول شيء
                يراه الزائر من محتوي الموقع لذا إحرص علي أن يكون جذاباً
            </article>
            <div class="clear padding-top">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن يحتوي الوصف علي أهم الكلمات المفتاحيه التي تستهدفها بهذه الصفحه</p>
            </div>
            <div class="clear">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن يكون الوصف مقروءاً للزائر وجذاباً ولا يضلل الزائر</p>
            </div>
            <div class="clear padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن تحتوي الصفحه علي وصف واحد فقط</p>
            </div>
            <div class="clear padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن يكون طول الوصف مناسباً بحيث لا يقل عن 70 حرف ولا يزيد عن 160 حرف</p>
            </div>
        </div>
        @if($audit->hasDescription ==true)
            <div class="clear">
                <h2>الوصف</h2>
                <p>{{$audit->descriptionMata}}</p>
                @if ($audit->hasDescription == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif ($audit->hasDescription == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
            <div class="clear">
                <h2>طول الوصف</h2>
                <p>{{$audit->lengthDescription}} حرف</p>
                @if ($audit->checkLengthDescription == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif ($audit->checkLengthDescription == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
            <div class="clear">
                <h2>عدد الكلمات</h2>
                <p>{{$audit->descriptionCount}}</p>
            </div>
            <div class="clear">
                <h2>الصفحة تحتوي علي وصف واحد فقط</h2>
                @if (!$audit->duplicateDescription == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif (!$audit->duplicateDescription == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
        @elseif($audit->hasDescription ==false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>الصفحة لا تحتوي علي وسم الوصف</p>
            </div>
        @else

        @endif
    </div>

    <!-- Keyword Result-->
    <div class="container">
        @if ($audit->hasKeywords == true)
            <div class="success">
                <h1>الكلمات المفتاحيه</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasKeywords == false)
            <div class="warn">
                <h1>الكلمات المفتاحيه</h1>
                <i class="fa fa-exclamation-triangle big-warn" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                يعد هذا الوسم أحد وسوم Meta ، ولقد ألغي جوجل إستخدام هذا الوسم في خورزمياته منذ فتره طويله ولكن ياهو
                مازال يستخدم هذا الوسم بنسبه ضعيفه وأيضاً بعض محركات البحث الأخري
            </article>
            <div class="clear padding-top">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>لا تحاول الإكثار من الكلمات المفتاحيه أو شبيهاتها</p>
            </div>
            <div class="clear">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن يحتوي محتوي الصفحه علي الكلمات المفتاحية المستهدفة ولكن بصورة مقروءه جيداً للزائر</p>
            </div>
            <div class="clear padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن تحتوي الصفحه علي وسم (كلمات مفتاحيه) واحد فقط</p>
            </div>
        </div>
        @if($audit->hasKeywords == true)
            <div class="clear">
                <h2>الكلمات المفتاحيه</h2>
                <p>{{$audit->keywordsMeta}}</p>
            </div>
            <div class="clear">
                <h2>طول الكلمات المفتاحيه</h2>
                <p>{{$audit->lengthKeywords}} حرف</p>
            </div>
            <div class="clear">
                <h2>عدد الكلمات</h2>
                <p>{{$audit->keywordsCount}}</p>
            </div>
            <div class="clear">
                <h2>الصفحة تحتوي علي وسم واحد فقط</h2>
                @if (!$audit->duplicateKeywords == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif (!$audit->duplicateKeywords == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
        @elseif ($audit->hasKeywords == false)
            <div class="clear padding-bottom">
                <h2>ملحوظة</h2>
                <p>الصفحة لا تحتوي علي وسم الكلمات المفتاحية ولقد ألغي جوجل أهمية هذا الوسم ولكن ياهو ومحركات البحث
                    الأخري مازالت تستخدمه في خوارزمياتها</p>
            </div>
        @else

        @endif
    </div>

    <!-- NewsKeyword Result-->
    <div class="container">
        @if ($audit->hasNews_keywords == true)
            <div class="success">
                <h1>الكلمات المفتاحيه للأخبار</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasNews_keywords == false)
            <div class="warn">
                <h1>الكلمات المفتاحيه للأخبار</h1>
                <i class="fa fa-exclamation-triangle big-warn" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                بالإنجليزيه news_keywords يعد هذا الوسم أحد وسوم Meta ، وهو مهم جداً للمواقع الإخباريه و علي عكس وسم
                (الكلمات المفتاحية) مازال جوجل يستخدم هذا الوسم ولكن بمواقع الأخبار فقط
            </article>
            <div class="clear padding-top">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>لا تحاول الإكثار من الكلمات المفتاحيه أو شبيهاتها</p>
            </div>
            <div class="clear">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن يحتوي محتوي الصفحه علي الكلمات المفتاحية المستهدفة ولكن بصورة مقروءه جيداً للزائر</p>
            </div>
            <div class="clear padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن تحتوي الصفحه علي وسم واحد فقط</p>
            </div>
            <div class="clear padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يجب أن تستخدم هذا الوسم في صفحات الأخبار فقط</p>
            </div>
        </div>
        @if($audit->hasNews_keywords == true)
            <div class="clear">
                <h2>الكلمات المفتاحيه للأخبار</h2>
                <p>{{$audit->news_keywordsMeta}}</p>
            </div>
            <div class="clear">
                <h2>طول الكلمات المفتاحيه</h2>
                <p>{{$audit->lengthNews_keywords}} حرف</p>
            </div>
            <div class="clear">
                <h2>عدد الكلمات</h2>
                <p>{{$audit->news_keywordsCount}}</p>
            </div>
            <div class="clear">
                <h2>الصفحة تحتوي علي وسم واحد فقط</h2>
                @if (!$audit->duplicateNews_keywords == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif (!$audit->duplicateNews_keywords == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
        @elseif ($audit->hasNews_keywords == false)
            <div class="clear padding-bottom">
                <h2>ملحوظة</h2>
                <p>هذا الوسم مهم جداً للمواقع الإخبارية وصفحات الأخبار فقط وأول من إستخدمه محرك بحث جوجل</p>
            </div>
        @else

        @endif
    </div>

    <!-- Robots Result-->
    <div class="container">
        @if ($audit->hasRobots == true)
            <div class="success">
                <h1>وسم Robots</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasRobots == false)
            <div class="warn">
                <h1>وسم Robots</h1>
                <i class="fa fa-exclamation-triangle big-warn" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                يعد وسم Meta Robots بديلاً عن ملف Robots الموجود في المجلد الرئيسي للموقع حيث بإمكانك إخبار محركات البحث
                برغبتك في فهرسة صفحه معينه وتتبعها أو أحد هذين الخيارين فقط أو علي العكس يمكنك إجبار عناكب محركات البحث
                علي عدم فهرسة وتتبع صفحات معينه
            </article>
            <div class="clear padding-top padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>يمكنك إخبار محركات البحث بشأن هذه الصفحه إما تسمح بفهرستها و تتبعها أو تتبعها فقط وعدم فهرستها أو
                    فهرستها فقط </p>
            </div>
        </div>
        @if($audit->hasRobots == true)
            <div class="clear padding-bottom">
                <h2>محتوي الوسم</h2>
                <p>{{$audit->robotsMeta}}</p>
            </div>
        @elseif ($audit->hasRobots == false)
            <div class="clear padding-bottom">
                <h2>ملحوظة</h2>
                <p>هذا الوسم يحدد كيف تريد محركات البحث أن تفعل تجاة هذة الصفحة</p>
            </div>
        @else

        @endif
    </div>

    <!-- View Port Result-->
    <div class="container">
        @if ($audit->hasViewport == true)
            <div class="success">
                <h1>وسم Viewport</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasViewport == false)
            <div class="warn">
                <h1>وسم Viewport</h1>
                <i class="fa fa-exclamation-triangle big-warn" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                هذا الوسم ليس له علاقه بالسيو أو بتحسين محركات البحث ولكنه يحدد كيف يعرض المتصفح الصفحه علي أجهزة
                الهواتف الذكيه ويؤثر علي تجربة المستخدم
            </article>
            <div class="clear padding-top padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>قد يكون عدم وجود هذا الوسم يؤدي إلي تجربة مستخدم سيئه</p>
            </div>
        </div>
        @if($audit->hasViewport == true)
            <div class="clear padding-bottom">
                <h2>محتوي الوسم</h2>
                <p>{{$audit->viewportMeta}}</p>
            </div>
        @elseif ($audit->hasViewport == false)
            <div class="clear padding-bottom">
                <h2>ملحوظة</h2>
                <p>هذا الوسم ليس له علاقة بالسيو ولكنه يتحكم في كيفية عرض الصفحة علي أجهزة الهواتف الذكية</p>
            </div>
        @else

        @endif
    </div>

    <!-- Meta Result-->
    <div class="container">
        @if (isset($audit->metas) == true)
            <div class="success">
                <h1>وسوم Meta</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif (is_null($audit->metas) == true)
            <div class="fail">
                <h1>وسوم Meta</h1>
                <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                تعد وسوم Meta أحد الأشياء التي تقرأها جميع الروبوتات بما فيها محركات البحث و روبوتات تطبيقات أخري
            </article>
        </div>
        @if(empty($audit->metas) != true)
            @foreach($audit->metas as $metaName =>$meta)
                <div class="clear padding-bottom">
                    <h2>{{$metaName}}</h2>
                    <p>{{$meta}}</p>
                </div>
            @endforeach

        @elseif (empty($audit->metas) == true)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>لم نجد في هذة الصفحة أي وسم من وسوم Meta</p>
            </div>
        @else

        @endif
    </div>

    <!-- Canonical Result-->
    <div class="container">
        @if ($audit->hasCanonical == true)
            <div class="success">
                <h1>رابط العنوان الأساسي Canonical</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasCanonical == false)
            <div class="fail">
                <h1>رابط العنوان الأساسي Canonical</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                تعد أهمية هذا الوسم في أنه يخبر روبوتات محركات البحث بالرابط الأساسي للصفحه أو المقاله وهذا يزيل إمكانية
                أن يتعرض موقعك لمشكلة تكرار المحتوي
            </article>
        </div>
        @if($audit->hasCanonical == true)
            <div class="clear padding-bottom">
                <h2>الرابط الأساسي</h2>
                <p>{{$audit->canonical}}</p>
            </div>
        @elseif ($audit->hasCanonical == false)
            <div class="clear padding-bottom">
                <h2>ملحوظة</h2>
                <p>عدم وجود هذا الوسم بصفحات موقعك يعرض موقعك لمشكلة تكرار المحتوي ولا سيما لو كانت الصفحة تستقبل
                    متغيرات</p>
            </div>
        @else

        @endif
    </div>

    <!-- TextHtmlRatio Result-->
    <div class="container">
        @if ($audit->checkTextHtmlRatio == true)
            <div class="success">
                <h1>نسبة النص إلي كود Html</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->checkTextHtmlRatio == false)
            <div class="fail">
                <h1>نسبة النص إلي كود Html</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                هذه النسبه ليست عاملاً أساسياً في ترتيب نتائج البحث ولكنها تساهم في تحسين عوامل أخري
            </article>
            <div class="clear padding-top padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>نسبة النص إلي كود Html التي يوصي بها هي نسبة مابين 25% و 70%</p>
            </div>
        </div>
        <div class="clear">
            <h2>نسبة النص إلي كود Html</h2>
            <p>{{$audit->ratio}} %</p>
            @if ($audit->checkTextHtmlRatio == true)
                <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
            @elseif ($audit->checkTextHtmlRatio == false)
                <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
            @else

            @endif
        </div>
    </div>

    <!-- Language Result-->
    <div class="container">
        @if ($audit->hasLanguage == true)
            <div class="success">
                <h1>اللغه</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasLanguage == false)
            <div class="fail">
                <h1>اللغه</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article></article>
            <div class="clear padding-top padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>تحديد لغة الصفحة في كود Html للمواقع متعددة اللغات مهم جداً</p>
            </div>
            <div class="clear padding-top padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>تحديد لغة الصفحة في رابط الصفحه للمواقع متعددة اللغات مهم جداً</p>
            </div>
        </div>
        @if($audit->hasLanguage == true)
            <div class="clear">
                <h2>لغة الصفحة</h2>
                <p>{{$audit->language}}</p>
                @if ($audit->hasLanguage == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif ($audit->hasLanguage == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
        @elseif($audit->hasLanguage == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>من المستحسن أن تحدد لغة الصفحه</p>
            </div>
        @else
        @endif
    </div>

    <!-- DocType Result-->
    <div class="container">
        @if ($audit->hasDocType == true)
            <div class="success">
                <h1>نوع الصفحه</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasDocType == false)
            <div class="fail">
                <h1>نوع الصفحه</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article></article>
            <div class="clear padding-top padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>تحديد نوع الصفحه يساعد المتصفح علي عرض الصفحه بالصوره المطلوبه</p>
            </div>

        </div>
        @if($audit->hasDocType == true)
            <div class="clear">
                <h2>نوع الصفحه</h2>
                <p>{{$audit->docType}}</p>
                @if ($audit->hasDocType == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif ($audit->hasDocType == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
        @elseif($audit->hasDocType == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>من المستحسن أن تحدد نوع الصفحه</p>
            </div>
        @else
        @endif
    </div>

    <!-- Encoding Result-->
    <div class="container">
        @if ($audit->hasEncoding == true)
            <div class="success">
                <h1>ترميز الصفحه</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasEncoding == false)
            <div class="fail">
                <h1>ترميز الصفحه</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article></article>
            <div class="clear padding-top padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>تحديد ترميز الصفحه يساعد المتصفح علي عرض الصفحه بدون تعقيدات ويقوي السيو</p>
            </div>

        </div>
        @if($audit->hasEncoding == true)
            <div class="clear">
                <h2>ترميز الصفحه</h2>
                <p>{{$audit->encoding}}</p>
                @if ($audit->hasEncoding == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif ($audit->hasEncoding == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
        @elseif($audit->hasEncoding == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>من المستحسن أن تحدد ترميز الصفحه</p>
            </div>
        @else
        @endif
    </div>

    <!-- Server info Result-->
    <div class="container">

        <div class="warn">
            <h1>معلومات عن الخادم</h1>
            <i class="fa fa-exclamation-triangle big-warn" aria-hidden="true"></i>
        </div>
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article></article>
            <div class="clear padding-top padding-bottom">
                <p>هذه بعض المعلومات التي لدينا عن الخادم الذي يستضيف موقعك</p>
            </div>

        </div>
        @if ($audit->hasIpAddress == true)
            <div class="clear padding-bottom">
                <h2>عنوان IP</h2>
                <p>{{$audit->IpAddress}}</p>
            </div>
        @endif
        @if ($audit->hasCountry == true)
            <div class="clear padding-bottom">
                <h2>بلد الخادم</h2>
                <p>{{$audit->country}}</p>
            </div>
        @endif
        @if ($audit->hasCity == true)
            <div class="clear padding-bottom">
                <h2>مدينة الخادم</h2>
                <p>{{$audit->city}}</p>
            </div>
        @endif
    </div>

    <!-- Heading Result-->
    <div class="container">

        @if ($audit->hasGoodHeadings && !$audit->hasManyH1 == true)
            <div class="success">
                <h1>وسوم Headings</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasGoodHeadings && !$audit->hasManyH1 == false)
            <div class="fail">
                <h1>وسوم Headings</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>يعد وسوم Headings بالإنجليزيه
                Headings Tags
                من أهم الوسوم التي تهتم بها محركات البحث لذا إحرص علي إستخدام الكلمات المفتاحية المستهدفة بين هذه الوسوم
            </article>
            <div class="clear padding-top padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>إستخدم كلاً من الوسوم الأتيه H1 و H2 و H3 علي الأقل مره واحده</p>
            </div>
            <div class="clear padding-top padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>إستخدم وسم H1 مره واحده في كل صفحه</p>
            </div>

        </div>
        @if($audit->hasH1 == true)
            <div class="clear">
                <h2>عدد وسوم H1</h2>
                <p>{{$audit->countH1}}</p>
                @if (!$audit->hasManyH1 == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif (!$audit->hasManyH1 == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
            <div class="clear padding-bottom">
                <h2>وسوم H1</h2>
                @foreach($audit->h1 as $h1)
                    <ul>{{$h1}}</ul>
                @endforeach
            </div>
        @endif
        @if($audit->hasH2 == true)
            <div class="clear">
                <h2>عدد وسوم H2</h2>
                <p>{{$audit->countH2}}</p>
            </div>
            <div class="clear padding-bottom">
                <h2>وسوم H2</h2>
                @foreach($audit->h2 as $h2)
                    <ul>{{$h2}}</ul>
                @endforeach
            </div>
        @endif
        @if($audit->hasH3 == true)
            <div class="clear">
                <h2>عدد وسوم H3</h2>
                <p>{{$audit->countH3}}</p>
            </div>
            <div class="clear padding-bottom">
                <h2>وسوم H3</h2>
                @foreach($audit->h3 as $h3)
                    <ul>{{$h3}}</ul>
                @endforeach
            </div>
        @endif
        @if($audit->hasH4 == true)
            <div class="clear">
                <h2>عدد وسوم H4</h2>
                <p>{{$audit->countH4}}</p>
            </div>
            <div class="clear padding-bottom">
                <h2>وسوم H4</h2>
                @foreach($audit->h4 as $h4)
                    <ul>{{$h4}}</ul>
                @endforeach
            </div>
        @endif
        @if($audit->hasH5 == true)
            <div class="clear">
                <h2>عدد وسوم H5</h2>
                <p>{{$audit->countH5}}</p>
            </div>
            <div class="clear padding-bottom">
                <h2>وسوم H5</h2>
                @foreach($audit->h5 as $h5)
                    <ul>{{$h5}}</ul>
                @endforeach
            </div>
        @endif
        @if($audit->hasH6 == true)
            <div class="clear">
                <h2>عدد وسوم H6</h2>
                <p>{{$audit->countH6}}</p>
            </div>
            <div class="clear padding-bottom">
                <h2>وسوم H6</h2>
                @foreach($audit->h6 as $h6)
                    <ul>{{$h6}}</ul>
                @endforeach
            </div>
        @endif
    </div>


    <!-- Img Result-->
    <div class="container">
        @if ($audit->hasGoodImg == true)
            <div class="success">
                <h1>النص البديل للصور</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasGoodImg ==false)
            <div class="fail">
                <h1>النص البديل للصور</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>يعد النص البديل للصور بالإنجليزية alt attribute in img tag
                طريقه لعرض صور معينه في نتائج بحث جمله معينه ، لذا ننصحك بأن يحتوي موقعك علي صور خاصه بك أو صور لديك حق
                نشرها و كتابة كلمات مفتاحيه واصفه للصور كنص بديل للصوره
            </article>
            <div class="clear padding-top padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>لا تستخدم صور بدون نص بديل alt attribute</p>
            </div>
            <div class="clear padding-top padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>ننصح أن يكون النص البديل يحتوي علي الكلمات المفتاحيه الخاصه بالصوره التي تستهدف الظهور في نتائج البحث
                    بها</p>
            </div>
        </div>
        <div class="clear">
            <h2>عدد الصور بالصفحه</h2>
            <p>{{$audit->imgCount}}</p>
            @if ($audit->hasImg == true)
                <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
            @elseif ($audit->hasImg == false)
                <i class="fa fa-times-circle warn-mark" aria-hidden="true"></i>
            @else

            @endif
        </div>
        <div class="clear">
            <h2>عدد الصور التي تحتوي علي نص بديل</h2>
            <p>{{$audit->altCount}}</p>
            @if ($audit->hasAlt == true)
                <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
            @elseif ($audit->hasAlt == false)
                <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
            @else

            @endif
        </div>
        <div class="clear">
            <h2>عدد الصور التي لا تحتوي علي نص بديل</h2>
            <p>{{$audit->emptyAltCount}}</p>
            @if (!$audit->hasEmptyAlt == true)
                <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
            @elseif (!$audit->hasEmptyAlt == false)
                <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
            @else

            @endif
        </div>
        @if(!empty($audit->alt))
            <div class="clear padding-bottom">
                <h2>النصوص البديله</h2>
                @foreach((array)$audit->alt as $alt)
                    <ul>{{$alt}}</ul>
                @endforeach
            </div>
        @endif
        @if(!empty($audit->emptyAlt))
            <div class="clear padding-bottom">
                <h2>الصور التي لا تحتوي علي نصوص بديله</h2>
                @foreach((array)$audit->emptyAlt as $emptyAlt)
                    <a href="{{$emptyAlt['src']}}" target="_blank">رقم {{$emptyAlt['num']}}</a>
                @endforeach
            </div>
        @endif
    </div>

    <!-- frames Result-->
    <div class="container">
        @if ((!$audit->hasIFrame && !$audit->hasFrameSet && !$audit->hasFrame) == true)
            <div class="success">
                <h1>الإطارات</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ((!$audit->hasIFrame && !$audit->hasFrameSet && !$audit->hasFrame) == false)
            <div class="fail">
                <h1>الإطارات</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>تعد جميع وسوم الإطارات سواءاً frame أو frameset أو iframe وسوماً حساسه ويجب إستخدامها بحرص لأن
                الإستخدام الخاطيء لهذه الوسوم يضعف السيو حيث أن محركات البحث لا تستطيع فهرسة الصفحات التي تحتوي علي
                إطارات لأنها لا تتبع النسق المعروف للمواقع
            </article>
            <div class="clear padding-top">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>لا تضع أحد مكونات الصفحه داخل هذه الأوسمه</p>
            </div>
            <div class="clear padding-bottom">
                <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>
                <p>إستخدام هذة الإطارات بطريقة صحيحه مثل إدراج أحد المكونات الخارجيه من مواقع أخري لا تضر</p>
            </div>
        </div>
        <div class="clear">
            <h2>عدد وسوم frame</h2>
            <p>{{$audit->frameCount}}</p>
            @if (!$audit->hasFrame == true)
                <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
            @elseif (!$audit->hasFrame == false)
                <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
            @else

            @endif
        </div>
        <div class="clear">
            <h2>عدد وسوم iframe</h2>
            <p>{{$audit->iFrameCount}}</p>
            @if (!$audit->hasIFrame == true)
                <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
            @elseif (!$audit->hasIFrame == false)
                <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
            @else

            @endif
        </div>
        <div class="clear">
            <h2>عدد وسوم frameSet</h2>
            <p>{{$audit->frameSetCount}}</p>
            @if (!$audit->hasFrameSet == true)
                <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
            @elseif (!$audit->hasFrameSet == false)
                <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
            @else

            @endif
        </div>
    </div>

    <!-- AMP Result-->
    <div class="container">
        @if ($audit->hasAmpLink == true)
            <div class="success">
                <h1>صفحة الجوّال المسرَّعة</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasAmpLink == false)
            <div class="fail">
                <h1>صفحة الجوّال المسرَّعة</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                تمثل صفحة الجوّال المسرَّعة بالإنجليزيه Accelerated Mobile Pages (التي يُشار إليها اختصارًا بـ AMP)
                صفحات ويب مصمَّمة وفقًا لمواصفات البرامج المفتوحة المصدر. ويتم تخزين صفحات AMP التي تم التحقق من صحتها
                في ذاكرة التخزين المؤقت لصفحات AMP من Google؛ وهو ما يتيح عرضها بشكل أسرع.
            </article>
        </div>
        @if($audit->hasAmpLink == true)
            <div class="clear">
                <h2>رابط صفحة الجوّال المسرَّعة</h2>
                <p>{{$audit->ampLink}}</p>
                @if (!$audit->hasFrame == true)
                    <i class="fa fa-check-circle-o success-mark" aria-hidden="true"></i>
                @elseif (!$audit->hasFrame == false)
                    <i class="fa fa-times-circle fail-mark" aria-hidden="true"></i>
                @else

                @endif
            </div>
        @elseif($audit->hasAmpLink == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>هذه الصفحة لا تحتوي علي رابط لصفحة الجوّال المسرَّعة</p>
            </div>
        @else

        @endif
    </div>

    <!-- openGraph Result-->
    <div class="container">
        @if ($audit->hasOG == true)
            <div class="success">
                <h1>بروتوكول Open Graph</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasOG == false)
            <div class="fail">
                <h1>بروتوكول Open Graph</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                بروتوكول Open Graph يتيح للصفحات أن تمتلك نفس الوطائف التي تمتلكها كائنات facebook
                ، فإذا أردت أن تظهر روابط موقعك بشكل جيد داخل facebook فعليك إستخدام هذا البروتوكول
            </article>
        </div>
        @if($audit->hasOG == true)
            @foreach($audit->openGraph as $property => $og)
                <div class="clear padding-bottom">
                    <h2>{{$property}}</h2>
                    <p>{{$og}}</p>
                </div>
            @endforeach
        @elseif($audit->hasOG == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>هذه الصفحة لا تحتوي علي بروتوكول Open Graph</p>
            </div>
        @else

        @endif
    </div>


    <!-- TwitterCard Result-->
    <div class="container">
        @if ($audit->hasTwitterCard == true)
            <div class="success">
                <h1>كرت Twitter</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasTwitterCard == false)
            <div class="fail">
                <h1>كرت Twitter</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                كرت Twitter بالإنجليزيه Twitter Cardيتيح للصفحات أن تضيف عنوان و وصف و صوره للرابط داخل موقع Twitter
            </article>
        </div>
        @if($audit->hasTwitterCard == true)
            @foreach($audit->twitterCard as $property => $tc)
                <div class="clear padding-bottom">
                    <h2>{{$property}}</h2>
                    <p>{{$tc}}</p>
                </div>
            @endforeach
        @elseif($audit->hasTwitterCard == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>هذه الصفحة لا تحتوي علي كرت Twitter</p>
            </div>
        @else

        @endif
    </div>

    <!-- favicon Result-->
    <div class="container">
        @if ($audit->hasFavicon == true)
            <div class="success">
                <h1>أيقونة الموقع</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasFavicon == false)
            <div class="fail">
                <h1>أيقونة الموقع</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                من المهم أن يكون لموقعك أيقونه أو شعار يميز صفحات موقعك عن غيرها أثناء تصفح الزائر لموقعك فهذا يؤثر علي
                تجربة المستخدم وإنطباعه عن موقعك
            </article>
        </div>
        @if($audit->hasFavicon == true)
            <div class="clear">
                <h2>أيقونة الموقع</h2>
                <img src="{{$audit->favicon}}" alt="site logo">
            </div>
        @elseif($audit->hasFavicon == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>لم نجد أيقونه لهذا الموقع</p>
            </div>
        @else

        @endif
    </div>

    <!-- SiteMap Result-->
    <div class="container">
        @if ($audit->hasSiteMap == true)
            <div class="success">
                <h1>خريطة الموقع</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasSiteMap == false)
            <div class="fail">
                <h1>خريطة الموقع</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                تكمن فائدة خريطة الموقع في أنها تخبر محركات البحث بهيكلة الموقع الخاص بك و بهذا يسهل علي محركات البحث
                معرفة الصفحات الجديده بموقعك و فهرستها
            </article>
        </div>
        @if($audit->hasSiteMap == true)
            <div class="clear">
                <h2>خريطة الموقع</h2>
                @foreach((array) $audit->siteMap as $map )
                    <ul>{{$map}}</ul>
                @endforeach
            </div>

        @elseif($audit->hasSiteMap == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>لم نجد خرائط لهذا الموقع</p>
            </div>
        @else

        @endif
    </div>

    <!-- robots Result-->
    <div class="container">
        @if ($audit->hasRobotsFile == true)
            <div class="success">
                <h1>ملف robots.txt</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasRobotsFile == false)
            <div class="fail">
                <h1>ملف robots.txt</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                تكمن أهمية ملف robots.txt في أنه يخبر عناكب محركات البحث بالصفحات التي تود فهرستها والصفحات التي لا تود
                فهرستها كما يتيح لك طريقة لتحديد مكان خرائط الموقع
            </article>
        </div>
        @if($audit->hasRobotsFile == true)
            <div class="clear padding-bottom">
                <h2>رابط الملف</h2>
                <p>{{$audit->robotsFile}}</p>
            </div>

        @elseif($audit->hasRobotsFile == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>لم نجد ملف robots.txt الخاص بموقعك</p>
            </div>
        @else

        @endif
    </div>


    <!-- structuredData Result-->
    <div class="container">
        @if ($audit->hasStructuredData == true)
            <div class="success">
                <h1>البيانات المنظمه</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasStructuredData == false)
            <div class="fail">
                <h1>البيانات المنظمه</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                يعد استخدام بيانات الترميز على صفحات الويب طريقة فعالة لزيادة ظهورك لمحركات البحث والحصول على نسب نقر و
                ظهور أعلى، مما قد يؤدي بدوره إلى ترتيب أفضل.
            </article>
        </div>
        @if($audit->hasStructuredData == true)
            <div class="clear">
                <h2>نوع البيانات</h2>
                @if($audit->hasMicroData == true)
                    <ul>بيانات مصغره بالإنجليزيه Micro Data</ul>
                @elseif($audit->hasRDFa == true)
                    <ul>بيانات RDFa</ul>
                @elseif($audit->hasJson == true)
                    <ul>بيانات Json</ul>
                @endif
            </div>

        @elseif($audit->hasStructuredData == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>لم نجد أي نوع من البيانات المنظمه في هذه الصفحه</p>
            </div>
        @else

        @endif
    </div>

    <!-- microfromats Result-->
    <div class="container">
        @if ($audit->hasMicroFormat == true)
            <div class="success">
                <h1>MicroFormats</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasMicroFormat == false)
            <div class="fail">
                <h1>MicroFormats</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                MicroFormats هي مجموعة من البنايات الصغيره ، وتنسيقات البيانات المفتوحة المصدر المصممه علي معايير واسعة
                الإستخدام ، تستخدم لتنظيم البيانات المرسله لمحركات البحث بصوره أكثر فعاليه.
            </article>
        </div>
        @if($audit->hasMicroFormat == true)
            <div class="clear">
                <p>لقد وجدنا بعض البيانات المنظمه تبعاً لموقع microformats.org</p>
            </div>

        @elseif($audit->hasMicroFormat == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>لم نجد أي نوع من البيانات المنظمه تبعاً لموقع microformats.org في هذه الصفحه</p>
            </div>
        @else

        @endif
    </div>

    <!-- FormattedText Result-->
    <div class="container">
        @if ($audit->hasFormattedText == true)
            <div class="success">
                <h1>نصوص منسقه</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->hasFormattedText == false)
            <div class="fail">
                <h1>نصوص منسقه</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>
                لا بد أن تحتوي صفحة الويب علي نصوص منسقه وننصحك أن تنسق الكلمات المفتاحيه التي تستهدفها
            </article>
        </div>
        @if($audit->hasFormattedText == true)
            @if(!empty($audit->strongItems))
                <div class="clear">
                    <h2>نصوص Strong</h2>
                    @foreach((array) $audit->strongItems as $item)
                        <ul>{{$item}}</ul>
                    @endforeach
                </div>
            @elseif(!empty($audit->emItems))
                <div class="clear">
                    <h2>نصوص em</h2>
                    @foreach((array) $audit->emItems as $item)
                        <ul>{{$item}}</ul>
                    @endforeach
                </div>
            @elseif(!empty($audit->iItems))
                <div class="clear">
                    <h2>نصوص i</h2>
                    @foreach((array) $audit->iItems as $item)
                        <ul>{{$item}}</ul>
                    @endforeach
                </div>
            @elseif(!empty($audit->bItems))
                <div class="clear">
                    <h2>نصوص b</h2>
                    @foreach((array) $audit->bItems as $item)
                        <ul>{{$item}}</ul>
                    @endforeach
                </div>
            @endif
        @elseif($audit->hasFormattedText == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>لم نجد أي نص منسق في هذه الصفحه</p>
            </div>
        @else

        @endif
    </div>


    <!-- Flash Result-->
    <div class="container">
        @if (!$audit->hasFlash == true)
            <div class="success">
                <h1>مكونات Flash</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif (!$audit->hasFlash == false)
            <div class="fail">
                <h1>مكونات Flash</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>يعد الفلاش من المكونات الغير قابله للفهرسه ولذلك لا ننصح بإستخدامه داخل صفحات الويب</article>
        </div>
        @if(!$audit->hasFlash == true)
            <div class="clear padding-bottom">
                <p>لم نجد مكونات تستخدم flash بداخل الصفحه</p>
            </div>

        @elseif(!$audit->hasFlash == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>وجدنا بعض المكونات التي تعمل بتقنية flash بهذه الصفحه</p>
            </div>
        @else

        @endif
    </div>

    <!-- indexability Result-->
    <div class="container">
        @if ($audit->isIndexAble == true)
            <div class="success">
                <h1>الصفحه قابله للفهرسه</h1>
                <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>
            </div>
        @elseif ($audit->isIndexAble == false)
            <div class="fail">
                <h1>الصفحه قابله للفهرسه</h1>
                <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>
            </div>
        @else

        @endif
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>هذا الإختبار يعرض لك قابلية هذة الصفحه للفهرسه علماً بأن هذا الإختبار لا يشمل الصفحات الموجوده في
                ملف robots.txt
            </article>
        </div>
        @if($audit->isIndexAble == true)
            <div class="clear padding-bottom">
                <p>لم نجد في الصفحه وسوم تمنع فهرسة الصفحه</p>
            </div>

        @elseif($audit->isIndexAble == false)
            <div class="clear padding-bottom">
                <h2>خطأ</h2>
                <p>وجدنا بعض الوسوم التي تمنع فهرسة الصفحه</p>
            </div>
        @else

        @endif
    </div>

    <!-- URl redirect Result-->
    <div class="container">

        <div class="warn">
            <h1>تحويلات الرابط</h1>
            <i class="fa fa-exclamation-triangle big-warn" aria-hidden="true"></i>
        </div>
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>إليك قائمه بعمليات التحويلات بكود الحاله التي صارت علي الرابط الخاص بالصفحه</article>
        </div>

        <div class="col-lg-3">
            @foreach((array)$audit->redirectStatus as $status)
                <p class="clear my-blue">{{$status}}</p>
            @endforeach
        </div>
        <div class="col-lg-9">
            @foreach((array)$audit->URLRedirects as $redirect)
                <p class="clear">{{$redirect}}</p>
            @endforeach
        </div>
        <div class="clear"></div>
    </div>

    <!-- URls analysis Result-->
    <div class="container">

        <div class="warn">
            <h1>تحليل الروابط</h1>
            <i class="fa fa-exclamation-triangle big-warn" aria-hidden="true"></i>
        </div>
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <strong>معلومه</strong>
            <article>معلومات مهمه عن الروابط داخل صفحة الويب</article>
        </div>

        @isset($audit->defaultRel)
            <div class="clear padding-bottom">
                <h2>نوع الرابط الإفتراصي</h2>
                <p>{{$audit->defaultRel}}</p>
            </div>
        @endisset

        <div class="clear padding-bottom">
            <h2>عدد الروابط في الصفحه</h2>
            <p>{{$audit->anchorCount}}</p>
        </div>

        <table>
            <thead>
            <tr>
                <th class="col1links">الرابط</th>
                <th class="col2links">نص الرابط</th>
                <th class="col3links">نوع الرابط</th>
            </tr>
            </thead>
            <tbody>
            @for ($i = 0; $i < count($audit->aHref); $i++)
                <tr>
                    <td class="col1links">{{$audit->aHref[$i]}}</td>
                    <td class="col1links">{{$audit->aText[$i]}}</td>
                    <td class="col3links">{{$audit->aStatus[$i]}}</td>
                </tr>
            @endfor
            </tbody>
        </table>
        <div class="clear"></div>
    </div>
    <hr>
    <h3 class="container center">معلومات عن الموقع</h3>

    <!-- Alexa -->

    <div class="container">

        @if($audit->hasPageRank)
            <div class="clear padding-bottom">
                <h2>ترتيب الصفحه PageRank</h2>
                <p>{{$audit->pageRank}}</p>
            </div>
        @endif

        @if($audit->hasRankSignalsUniqueDomainLinksCount)
            <div class="clear padding-bottom">
                <h2>عدد المواقع التي تشير لموقعك</h2>
                <p>{{$audit->rankSignalsUniqueDomainLinksCount}}</p>
            </div>
        @endif

        @if($audit->hasGlobalAlexaRank)
            <div class="clear padding-bottom">
                <h2>الترتيب العالمي</h2>
                <p>{{$audit->globalAlexaRank}}</p>
            </div>
        @endif

        @if($audit->hasRankSignalsTotalBackLinks)
            <div class="clear padding-bottom">
                <h2>عدد الروابط الخلفيه BackLinks</h2>
                <p>{{$audit->rankSignalsTotalBackLinks}}</p>
            </div>
        @endif

        @if($audit->hasAlexaReach)
            <div class="clear padding-bottom">
                <h2>عدد الزوار</h2>
                <p>{{$audit->alexaReach}}</p>
            </div>
        @endif

        @if($audit->hasCountryRank)
            <div class="clear padding-bottom">
                <h2>الترتيب المحلي</h2>
                <p>{{$audit->countryRank}}</p>
            </div>
        @endif

        @if($audit->hasAlexaBackLinksCount)
            <div class="clear padding-bottom">
                <h2>عدد الروابط الخلفيه في Alexa</h2>
                <p>{{$audit->alexaBackLinksCount}}</p>
            </div>
        @endif

        @if($audit->hasRankDelta)
            <div class="clear padding-bottom">
                <h2>مقدار التغير في الترتيب</h2>
                <p>{{$audit->rankDelta}}</p>
            </div>
        @endif

        @if($audit->hasCountryName)
            <div class="clear padding-bottom">
                <h2>بلد الموقع</h2>
                <p>{{$audit->countryName}}</p>
            </div>
        @endif

        @if($audit->hasCountryCode)
            <div class="clear padding-bottom">
                <h2>كود البلد</h2>
                <p>{{$audit->countryCode}}</p>
            </div>
        @endif

        {{--Backlinks table(Still working)

        @if($audit->hasAlexaBackLinks && $audit->hasOlpLinks && $audit->hasMozLinks)

          <table>
          <tr>
              <th>الرابط</th>
          </tr>

                <tr>
                    <td>{{$audit->aHref[$i]}}</td>
                    <td>{{$audit->aText[$i]}}</td>
                    <td>{{$audit->aStatus[$i]}}</td>
                </tr>
          </table>

        @endif
        --}}

    </div>


@endsection
