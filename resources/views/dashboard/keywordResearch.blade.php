@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('keyword-research'))
@section('print-div','printable')
@section('styles')
<!-- Styles -->
<link href="{{url('typeahead/typeaheadjs.css')}}" rel="stylesheet">
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
                {!! Form::open(['id'=>'the-form']) !!}
 
                <div>
                    <input id="hl" name="hl" class="form-control" value="" type="hidden" placeholder="language code" required />
                    <input id="gl" name="gl" class="form-control" value="" type="hidden" placeholder="region code" required />
                </div>  

                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                    <p class="title">@lang('keyword')</p>
                    <div class="form-group" id="keyword">
                        {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('keyword') ,'id'=>'keywordInput','pattern'=>'.{1,}','required','title'=>'Enter your Keyword']) }}
                    </div>                            
                </div>

                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                    <p class="title">@lang('country-language')</p>  
                    <div class="form-group" id="region-box">              
                        <input id="regions" class="form-control typeahead" autocomplete="off" type="text" dir="auto" placeholder="@lang('select-country-language')" spellcheck="false">
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
    
</div>


@endsection

@section('scripts')

<script src="{{url('handlebars/handlebars-v4.1.1.js')}}" ></script>
<script src="{{url('typeahead/typeahead.bundle.min.js')}}"></script>
<script src="{{url('js/localization-countries.js')}}"></script>

<script>
  $( "#button" ).click(function() {
    if($("#the-form")[0].checkValidity()) {
  
        //disable button
        $("#button").attr("disabled", true);

        $.get("{{route('lang.keywordResearchAjax',app()->getLocale())}}",
        { keyword: $("#keywordInput").val(), country: $("#gl").val() , language: $("#hl").val() },
        function (jsondata) {
 

                // $.get("{{url('templates/panelComponent.hbs')}}", function (data) {
                // var template=Handlebars.compile(data);      
                // $("#checks").html(template(jsondata.checks));

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

</script>

@endsection