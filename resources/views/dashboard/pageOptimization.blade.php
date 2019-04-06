@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('page-optimization'))
@section('user-image',url('/img/user.png'))
@section('user-type',__('pro-plan'))
@section('styles')
{{--<!-- Fonts -->--}}
{{--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">--}}

<!-- Styles -->
<style>
    /* html, body { */
        /*background-color: #fff;*/
        /*color: #636b6f;*/
        /*font-family: 'Raleway', sans-serif;*/
        /*font-weight: 200;*/
        /*height: 100vh;*/
        /*margin: 0;*/

    /* } */
/* 
    .full-height {
        height: 100vh;
    }

    .full-width{
        width: 100vh;
    } */

    /* .flex-center {*/
        /*align-items: center;*/
        /*display: flex;*/
        /*justify-content: center;*/

    /*} */

    /* .position-ref {
        position: relative;
    } */

    .title {
        font-size: 20px;
        /* text-align: center; */
        /*addition to integrate*/
        color: #636b6f;
        font-weight: 200;
    }
    /*addition to integrate*/
    /*form{*/
        /*width: 100%;*/
    /*}*/

    form #text-box{
        /* width: 95vh; */
        margin: auto auto;
        /*addition to integrate*/
        /* direction: ltr; */
        font-family: 'Raleway', sans-serif;
    }

    form #button{
        /* width: 40vh; */
        margin: 15px auto;

    }

</style>
@endsection

@section('content')
<div class="container-fluid">    
        <div class="row">
                {!! Form::open(['url' => 'report']) !!}
                <div class="col-lg-5 col-xs-12">
                        {{-- <div class="flex-center position-ref full-height"> --}}
                                <p class="title">@lang('page-link')</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('page-link')]) }}
                                </div>
                            {{-- </div> --}}
                </div>
                <div class="col-lg-5 col-xs-12">
                        {{-- <div class="flex-center position-ref full-height">                              --}}
                                <p class="title">@lang('keyword')</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('keyword')]) }}
                                </div>                            
                            {{-- </div> --}}
                </div>
                <div class="col-lg-2 col-xs-12">
                    
                           <!-- Standard button -->
                           <button id="button" type="button" class="btn btn-primary form-control" style="margin-top: 38px;"><i class="fa fa-search"></i></button>
                </div>
                {!! Form::close() !!}
        </div>
</div>


@endsection

@section('scripts','')