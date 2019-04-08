@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('page-optimization'))
@section('user-image',url('/img/user.png'))
@section('user-type',__('pro-plan'))
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
</style>
@endsection

@section('content')
<div class="container-fluid">    
        <div class="row">
                {!! Form::open(['url' => 'report']) !!}
                <div class="col-lg-5 col-xs-12">
                                <p class="title">@lang('page-link')</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('page-link') ,'id'=>'urlInput']) }}
                                </div>
                </div>
                <div class="col-lg-5 col-xs-12">
                                <p class="title">@lang('keyword')</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('keyword') ,'id'=>'keywordInput']) }}
                                </div>                            
                </div>
                <div class="col-lg-2 col-xs-12">
                           <button id="button" type="button" class="btn btn-primary form-control" style="margin-top: 38px;"><i class="fa fa-search"></i></button>
                </div>
                {!! Form::close() !!}
        </div>

        <div class="row" id="checks"></div>

</div>


@endsection

@section('scripts')

<script>
$('.panel-default').on('click', function(e) {
    $(e.target).find("span.clickable").toggleClass('glyphicon-chevron-up glyphicon-chevron-down',200, "easeOutSine" );
});
</script>

<script src="{{url('handlebars/handlebars-v4.1.1.js')}}" ></script>

<script>
  $( "#button" ).click(function() {

  $.get("{{route('optimizerAjax')}}",{ u: $("#urlInput").val(), k: $("#keywordInput").val() }, function (jsondata) {
    console.log(jsondata);

    $.get("{{url('templates/panelComponent.hbs')}}", function (data) {
      var template=Handlebars.compile(data);
      $("#checks").html(template(jsondata));
    }, 'html')
    
  },'json')
});
</script>

@endsection