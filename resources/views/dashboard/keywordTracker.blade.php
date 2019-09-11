@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('keywords-tracker'))
@section('user-image',url('/img/user.png'))
@section('user-type',__('pro-plan'))
@section('print-div','printable')
@section('styles')
<!-- Styles -->
<style>
    .title {
        font-size: 20px;
        color: #636b6f;
        font-weight: 200;
    }
    form #text-box{
        margin: auto auto;
        font-family: 'Raleway', sans-serif;
    }
    form #button{
        margin: 15px auto;
    }
    #process-bar{
        margin: 10px;
        width: 100px;
        height: 100px;
        position: relative;
    }
    .container-border{
        border: 1px solid #ccc;   
    }
    .active-issue{
        background-color: #ccc;
        color: white;
    }
    .section-header{
        font-size: 20px;
        padding: 15px 15px 0 15px;
    }

</style>
@endsection

@section('content')
<div class="container-fluid" id="printable">    
        <div class="row">
                {!! Form::open(['url' => 'report','id'=>'the-form']) !!}
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <p class="title">@lang('page-link')</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('page-link') ,'id'=>'urlInput','pattern'=>'https?://.+','required','title'=>'Page Link begins with http:// Or https://']) }}
                                </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <p class="title">@lang('keyword')</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('keyword') ,'id'=>'keywordInput','pattern'=>'.{1,}','required','title'=>'Enter your Keyword']) }}
                                </div>                            
                </div>
                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                    <p class="title">@lang('search-engine')</p>
                    <div class="form-group" id="text-box">
                        <select id="engine" class="form-control">
                                                        
                                <option selected="selected" value="bing">bing.com</option>     

                                <option value="ae">ae - google.ae</option>                            
                                                    
                                <option value="af">af - google.com.af</option>                            
                                                        
                                <option value="al">al - google.al</option>                            
                                                        
                                <option value="am">am - google.am</option>                            
                                                        
                                <option value="ao">ao - google.co.ao</option>                            
                                                        
                                <option value="ar">ar - google.com.ar</option>                            
                                                        
                                <option value="at">at - google.at</option>                            
                                                        
                                <option value="au">au - google.com.au</option>                            
                                                        
                                <option value="az">az - google.az</option>                            
                                                        
                                <option value="ba">ba - google.ba</option>                            
                                                        
                                <option value="bd">bd - google.com.bd</option>                            
                                                        
                                <option value="be">be - google.be</option>                            
                                                        
                                <option value="bg">bg - google.bg</option>                            
                                                        
                                <option value="bh">bh - google.com.bh</option>                            
                                                        
                                <option value="bn">bn - google.com.bn</option>                            
                                                        
                                <option value="bo">bo - google.com.bo</option>                            
                                                        
                                <option value="br">br - google.com.br</option>                            
                                                        
                                <option value="bs">bs - google.bs</option>                            
                                                        
                                <option value="bw">bw - google.co.bw</option>                            
                                                        
                                <option value="by">by - google.by</option>                            
                                                        
                                <option value="bz">bz - google.com.bz</option>                            
                                                        
                                <option value="ca">ca - google.ca</option>                            
                                                        
                                <option value="cd">cd - google.cd</option>                            
                                                        
                                <option value="ch">ch - google.ch</option>                            
                                                        
                                <option value="cl">cl - google.cl</option>                            
                                                        
                                <option value="cm">cm - google.cm</option>                            
                                                        
                                <option value="co">co - google.com.co</option>                            
                                                        
                                <option value="cr">cr - google.co.cr</option>                            
                                                        
                                <option value="cv">cv - google.cv</option>                            
                                                        
                                <option value="cy">cy - google.com.cy</option>                            
                                                        
                                <option value="cz">cz - google.cz</option>                            
                                                        
                                <option value="de">de - google.de</option>                            
                                                        
                                <option value="dk">dk - google.dk</option>                            
                                                        
                                <option value="do">do - google.com.do</option>                            
                                                        
                                <option value="dz">dz - google.dz</option>                            
                                                        
                                <option value="ec">ec - google.com.ec</option>                            
                                                        
                                <option value="ee">ee - google.ee</option>                            
                                                        
                                <option value="eg">eg - google.com.eg</option>                            
                                                        
                                <option value="es">es - google.es</option>                            
                                                        
                                <option value="et">et - google.com.et</option>                            
                                                        
                                <option value="fi">fi - google.fi</option>                            
                                                        
                                <option value="fr">fr - google.fr</option>                            
                                                        
                                <option value="ge">ge - google.ge</option>                            
                                                        
                                <option value="gh">gh - google.com.gh</option>                            
                                                        
                                <option value="gr">gr - google.gr</option>                            
                                                        
                                <option value="gt">gt - google.com.gt</option>                            
                                                        
                                <option value="gy">gy - google.gy</option>                            
                                                        
                                <option value="hk">hk - google.com.hk</option>                            
                                                        
                                <option value="hn">hn - google.hn</option>                            
                                                        
                                <option value="hr">hr - google.hr</option>                            
                                                        
                                <option value="ht">ht - google.ht</option>                            
                                                        
                                <option value="hu">hu - google.hu</option>                            
                                                        
                                <option value="id">id - google.co.id</option>                            
                                                        
                                <option value="ie">ie - google.ie</option>                            
                                                        
                                <option value="il">il - google.co.il</option>                            
                                                        
                                <option value="in">in - google.co.in</option>                            
                                                        
                                <option value="is">is - google.is</option>                            
                                                        
                                <option value="it">it - google.it</option>                            
                                                        
                                <option value="jm">jm - google.com.jm</option>                            
                                                        
                                <option value="jo">jo - google.jo</option>                            
                                                        
                                <option value="jp">jp - google.co.jp</option>                            
                                                        
                                <option value="kh">kh - google.com.kh</option>                            
                                                        
                                <option value="kr">kr - google.co.kr</option>                            
                                                        
                                <option value="kw">kw - google.com.kw</option>                            
                                                        
                                <option value="kz">kz - google.kz</option>                            
                                                        
                                <option value="lb">lb - google.com.lb</option>                            
                                                        
                                <option value="lk">lk - google.lk</option>                            
                                                        
                                <option value="lt">lt - google.lt</option>                            
                                                        
                                <option value="lu">lu - google.lu</option>                            
                                                        
                                <option value="lv">lv - google.lv</option>                            
                                                        
                                <option value="ly">ly - google.com.ly</option>                            
                                                        
                                <option value="ma">ma - google.co.ma</option>                            
                                                        
                                <option value="md">md - google.md</option>                            
                                                        
                                <option value="me">me - google.me</option>                            
                                                        
                                <option value="mg">mg - google.mg</option>                            
                                                        
                                <option value="mn">mn - google.mn</option>                            
                                                        
                                <option value="mt">mt - google.com.mt</option>                            
                                                        
                                <option value="mu">mu - google.mu</option>                            
                                                        
                                <option value="mx">mx - google.com.mx</option>                            
                                                        
                                <option value="my">my - google.com.my</option>                            
                                                        
                                <option value="mz">mz - google.co.mz</option>                            
                                                        
                                <option value="na">na - google.com.na</option>                            
                                                        
                                <option value="ng">ng - google.com.ng</option>                            
                                                        
                                <option value="ni">ni - google.com.ni</option>                            
                                                        
                                <option value="nl">nl - google.nl</option>                            
                                                        
                                <option value="no">no - google.no</option>                            
                                                        
                                <option value="np">np - google.com.np</option>                            
                                                        
                                <option value="nz">nz - google.co.nz</option>                            
                                                        
                                <option value="om">om - google.com.om</option>                            
                                                        
                                <option value="pe">pe - google.com.pe</option>                            
                                                        
                                <option value="ph">ph - google.com.ph</option>                            
                                                        
                                <option value="pk">pk - google.com.pk</option>                            
                                                        
                                <option value="pl">pl - google.pl</option>                            
                                                        
                                <option value="pt">pt - google.pt</option>                            
                                                        
                                <option value="py">py - google.com.py</option>                            
                                                        
                                <option value="ro">ro - google.ro</option>                            
                                                        
                                <option value="rs">rs - google.rs</option>                            
                                                        
                                <option value="ru">ru - google.ru</option>                            
                                                        
                                <option value="sa">sa - google.com.sa</option>                            
                                                        
                                <option value="se">se - google.se</option>                            
                                                        
                                <option value="sg">sg - google.com.sg</option>                            
                                                        
                                <option value="si">si - google.si</option>                            
                                                        
                                <option value="sk">sk - google.sk</option>                            
                                                        
                                <option value="sn">sn - google.sn</option>                            
                                                        
                                <option value="sv">sv - google.com.sv</option>                            
                                                        
                                <option value="th">th - google.co.th</option>                            
                                                        
                                <option value="tn">tn - google.tn</option>                            
                                                        
                                <option value="tr">tr - google.com.tr</option>                            
                                                        
                                <option value="tt">tt - google.tt</option>                            
                                                        
                                <option value="ua">ua - google.com.ua</option>                            
                                                        
                                <option value="uk">uk - google.co.uk</option>                            
                                                        
                                <option value="us">us - google.com</option>                            
                                                        
                                <option value="uy">uy - google.com.uy</option>                            
                                                        
                                <option value="ve">ve - google.co.ve</option>                            
                                                        
                                <option value="vn">vn - google.com.vn</option>                            
                                                        
                                <option value="za">za - google.co.za</option>                            
                                                        
                                <option value="zm">zm - google.co.zm</option>                            
                                                        
                                <option value="zw">zw - google.co.zw</option>                             
                            
                        </select> 
                    </div>                            
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                           <button id="button" type="button" class="btn btn-primary form-control hidden-print" style="margin-top: 38px;"><i class="fa fa-search"></i></button>
                           <input type="submit" style="display:none;"/>
                </div>
                {!! Form::close() !!}
        </div>

        

            <div style="display:none; padding-bottom: 15px;" id="upper-board">

                <div class="row">    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="title">
                            <p class="title">@lang('page-link')</p> 
                            <a id="url-value" href=""></a>
                            
                            <p class="title">@lang('page-title')</p> 
                            <p id="title-value"></p>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="desc">
                            <p class="title">@lang('page-description')</p> 
                            <p id="desc-value"></p> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" >
                        <p class="title">@lang('keyword-found')</p> 
                        <p class="title" id="found"></p> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                        <p class="title">@lang('keyword-locations')</p> 
                        <ul id="locations"></ul> 
                    </div>             
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" id="page-score">

                        <p class="title">@lang('page-score')</p>
                        <div id="process-bar"></div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 container-border text-center" id="hurting-block">
                        <p class="title">@lang('hurt-score') <span class="glyphicon glyphicon-chevron-down" style="color:#ff4444;"></span></p>
                        <p class="title" id="hurting"></p>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 container-border text-center" id="helping-block">
                        <p class="title">@lang('help-score') <span class="glyphicon glyphicon-chevron-up" style="color:#00C851;"></span></p>
                        <p class="title" id="helping"></p>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 container-border text-center" id="issues-block">
                        <p class="title">@lang('all-issues')</p>
                        <p class="title"  id="all-issues"></p>
                    </div>
                </div>
            </div>

            <div class="row" id="checks"></div>
    
</div>


@endsection

@section('scripts')

<script src="{{url('handlebars/handlebars-v4.1.1.js')}}" ></script>
<script src="{{url('bower_components/progressbar.js/dist/progressbar.min.js')}}" ></script>

<script>
  $( "#button" ).click(function() {
    if($("#the-form")[0].checkValidity()) {
  
        //disable button
        $("#button").attr("disabled", true);

        // reset process bar,checks
        $('#checks,#process-bar').html("");

        $.get("{{route('lang.optimizerAjax',app()->getLocale())}}",{ u: $("#urlInput").val(), k: $("#keywordInput").val() }, function (jsondata) {
            $("#urlInput").attr("placeholder", $("#urlInput").val());
            $("#keywordInput").attr("placeholder", $("#keywordInput").val());

                $.get("{{url('templates/panelComponent.hbs')}}", function (data) {
                var template=Handlebars.compile(data);      
                $("#checks").html(template(jsondata.checks));
                    // update view
                    updateView(jsondata);
                    attachProcessPar(jsondata);
                }, 'html')       
        },'json')

        //Enable button
        setTimeout(function() {
            $("#button").removeAttr("disabled");
        },2500);   // enable after 2 seconds       
        
    }
    else {
        $("#the-form")[0].reportValidity();
    }
});

function updateView(jsondata){
    $('#upper-board').show();
    $('#url-value').text(jsondata.url).attr('href',jsondata.url);
    $('#title-value').text(jsondata.pageTitle);
    $('#desc-value').text(jsondata.pageDescription);
    $('#found').text(jsondata.keywordFound);
    $('#locations').html("<li>Title : "+jsondata.keywordInTitleCount+"</li>"+
                        "<li>Body : "+jsondata.keywordInBodyCount+"</li>"+
                        "<li>Meta description : "+jsondata.keywordInDescriptionCount+"</li>"+
                        "<li>Url : "+jsondata.keywordInUrlCount+"</li>"+
                        "<li>IMG Alt : "+jsondata.keywordInImgAltCount+"</li>");
                        $('#hurting').text( $('#checks .glyphicon-remove-sign').size() );

    $('#helping').text( $('#checks .glyphicon-ok-sign').size() );
    $('#all-issues').text( $('#checks .glyphicon-ok-sign').size() + $('#checks .glyphicon-remove-sign').size() );

    $('.panel-heading').on('click', function(e) {
        $(e.target).find("span.clickable").toggleClass('glyphicon-chevron-up glyphicon-chevron-down',200, "easeOutSine" );
    });

    $('#hurting-block').click(function() {
        $('.glyphicon-remove-sign').parent().parent().parent().show();
        $('.glyphicon-ok-sign').parent().parent().parent().hide();
        $( "#hurting-block" ).addClass( "active-issue" );
        $('#helping-block,#issues-block').removeClass( "active-issue" );
    });
    $('#helping-block').click(function() {
        $('.glyphicon-remove-sign').parent().parent().parent().hide();
        $('.glyphicon-ok-sign').parent().parent().parent().show();
        $( "#helping-block" ).addClass( "active-issue" );
        $('#issues-block,#hurting-block').removeClass( "active-issue" );
    });
    $('#issues-block').click(function() {
        $('.glyphicon-remove-sign').parent().parent().parent().show();
        $('.glyphicon-ok-sign').parent().parent().parent().show();
        $( "#issues-block" ).addClass( "active-issue" );
        $('#helping-block,#hurting-block').removeClass( "active-issue" );
    });
}

function attachProcessPar(jsondata){
    var bar = new ProgressBar.Circle('#process-bar', {
    color: '#636b6f',
    // This has to be the same size as the maximum width to
    // prevent clipping
    strokeWidth: 10,
    trailWidth: 4,
    easing: 'easeInOut',
    duration: 1400,
    text: {
        autoStyleContainer: false,
        value: '0'
    },   
    from: { color: '#aaa', width: 4 },
    to: { color: jsondata.score >= 70 ? "#00C851" : "#ff4444", width: 10 },
    // Set default step function for all animate calls
    step: function(state, circle) {
        circle.path.setAttribute('stroke', state.color);
        circle.path.setAttribute('stroke-width', state.width);

        var value = Math.round(circle.value() * 100);
        if (value === 0) {
            circle.setText('');
        } else {
            circle.setText(value);
        }       
    }
    });
    bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar.text.style.fontSize = '4rem';
    

    bar.animate(jsondata.score / 100);  // Number from 0.0 to 1.0
}

</script>

@endsection