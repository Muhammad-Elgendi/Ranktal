@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('page-optimization'))
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
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                                <p class="title">@lang('page-link')</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('page-link') ,'id'=>'urlInput','pattern'=>'https?://.+','required','title'=>'Page Link begins with http:// Or https://']) }}
                                </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                                <p class="title">@lang('keyword')</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('keyword') ,'id'=>'keywordInput','pattern'=>'.{1,}','required','title'=>'Enter your Keyword']) }}
                                </div>                            
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                           <button id="button" type="button" class="btn btn-primary form-control hidden-print" style="margin-top: 38px;">@lang('optimize') <i class="fa fa-cogs"></i></button>
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