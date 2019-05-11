@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('backlinks-checker'))
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
    table {
        border-collapse:collapse;
        table-layout:fixed;
    }
    table td {
        word-wrap:break-word;
    }

</style>
@endsection

@section('content')
<div class="container-fluid" id="printable">    
        <div class="row">
                {!! Form::open(['url' => 'report','id'=>'the-form']) !!}
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                                <p class="title">Target URL</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('page-link') ,'id'=>'target','pattern'=>'https?://.+','title'=>'Page Link begins with http:// Or https://']) }}
                                </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                    <p class="title">Source URL</p>
                    <div class="form-group" id="text-box">
                        {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('page-link') ,'id'=>'source','pattern'=>'https?://.+','title'=>'Page Link begins with http:// Or https://']) }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                           <button id="button" type="button" class="btn btn-primary form-control hidden-print" style="margin-top: 38px;"><i class="fa fa-search"></i></button>
                           <input type="submit" style="display:none;"/>
                </div>
                {!! Form::close() !!}
        </div>

            <div class="row" id="checks">
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

        $.get("{{route('lang.backlinksAjax',app()->getLocale())}}",{ target: $("#target").val(), src: $("#source").val() }, function (jsondata) {
            $("#target").attr("placeholder", $("#target").val());
            $("#source").attr("placeholder", $("#source").val());
                $.get("{{url('templates/TableComponent.hbs')}}", function (data) {
                var template=Handlebars.compile(data);      
                $("#checks").html(template(jsondata));
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





</script>

@endsection