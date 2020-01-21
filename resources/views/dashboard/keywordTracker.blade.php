@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('keywords-tracker'))
@section('user-image',url('/img/user.png'))
@section('user-type',__('pro-plan'))
@section('print-div','printable')
@section('styles')
<link href="{{url('typeahead/typeaheadjs.css')}}" rel="stylesheet">
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
    #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
    }
    #device{
        padding: 0;
    }

</style>
@endsection

@section('content')
<div class="container-fluid" id="printable">    
        <div class="row">
                {!! Form::open(['id'=>'the-form']) !!}
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
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <p class="title">@lang('search-engine')</p>
                    <div class="form-group" id="text-box">
                        <select id="engine" class="form-control">
                                <option selected="selected" value="bing">Bing</option>    
                                <option value="google">Google</option>  
                        </select> 
                    </div>                            
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <p class="title">@lang('device-type')</p>
                        <div class="form-group">
                            <select id="device" class="form-control">
                                    <option selected="selected" value="desktop">@lang('desktop')</option>    
                                    <option value="mobile">@lang('mobile')</option>  
                            </select> 
                        </div>                            
                    </div>
    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <p class="title">@lang('country-language')</p>  
                        <div class="form-group" id="region-box">
                            <input id="regions" class="form-control typeahead" autocomplete="off" type="text" dir="auto" placeholder="@lang('select-country-language')" spellcheck="false">
                        </div>
                    </div>

                    <div>                           
                        <input id="hl" name="hl" class="form-control" value="" type="hidden" placeholder="language code" required />
                        <input id="gl" name="gl" class="form-control" value="" type="hidden" placeholder="region code" required />
                    </div>                

                    <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                            <p class="title">@lang('search-location')</p>  
                            <div class="form-group" id="region-box">                                 
                                <input id="place" class="form-control" autocomplete="off" type="text" aria-hidden="true" placeholder="search location">
                                <label for="showMap">@lang('show-map')</label> <input id="showMap" class="showMap" type="checkbox" name="showMap">
                                <label for="latitude">@lang('latitude-longitude')</label>
                                <input id="latitude" class="location" autocomplete="off" type="text" aria-hidden="true" placeholder="latitude" dir="ltr" required />
                                - <input id="longitude" class="location" autocomplete="off" type="text" aria-hidden="true" placeholder="longitude" dir="ltr" required />
                                {{-- <input id="ie" name="ie" value="utf-8" type="hidden">
                                <input id="oe" name="oe" value="utf-8" type="hidden">
                                <input id="pws" name="pws" value="0" type="hidden"> --}}
                                <input id="uule" name="uule" value="" type="hidden">
                            </div>
                    </div>

                    <div class="col-xs-12">
                        <div id="map" style="display:none;"></div>
                    </div>
              
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                           <button id="button" type="button" class="btn btn-primary form-control hidden-print" style="margin-top: 38px;"><i class="fa fa-search"></i></button>
                           <input type="submit" style="display:none;"/>
                </div>
                {!! Form::close() !!}
        </div>
</div>


@endsection

@section('scripts')

<script src="{{url('handlebars/handlebars-v4.1.1.js')}}" ></script>
<script src="{{url('typeahead/typeahead.bundle.min.js')}}"></script>
<script src="{{url('js/localization-search-engines.js')}}"></script>



<script>
  $( "#button" ).click(function() {
    if($("#the-form")[0].checkValidity()) {
  
        //disable button
        $("#button").attr("disabled", true);

        // reset process bar,checks
        $('#checks,#process-bar').html("");

        $.get("{{route('lang.keywordTrackerAjax',app()->getLocale())}}",{
                u: $("#urlInput").val(),
                k: $("#keywordInput").val(),
                e: $('#engine').val(),
                d: $('#device').val(),
                l: $('#hl').val(),
                c: $('#gl').val(),
                uule : $('#uule').val(),
                lat: $('#latitude').val(),
                long: $('#longitude').val()
             }, function (jsondata) {
                // $.get("{{url('templates/panelComponent.hbs')}}", function (data) {
                // var template=Handlebars.compile(data);      
                // // $("#checks").html(template(jsondata.checks));
                //     // update view
                //     updateView(jsondata);               
                // }, 'html')    
                console.log(jsondata);   
        },'text')

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

</script>

@endsection