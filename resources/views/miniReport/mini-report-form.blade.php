@extends('layouts.main_v1')
@section('title','إعداد تقرير سيو داخلي')
@section('user-image',url('/img/user.png'))
@section('user-type','الخطة العادية')
@section('styles')
{{--<!-- Fonts -->--}}
{{--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">--}}

<!-- Styles -->
<style>
    html, body {
        /*background-color: #fff;*/
        /*color: #636b6f;*/
        /*font-family: 'Raleway', sans-serif;*/
        /*font-weight: 200;*/
        /*height: 100vh;*/
        /*margin: 0;*/

    }

    .full-height {
        height: 100vh;
    }

    .full-width{
        width: 100vh;
    }

    /*.flex-center {*/
        /*align-items: center;*/
        /*display: flex;*/
        /*justify-content: center;*/

    /*}*/

    .position-ref {
        position: relative;
    }

    .title {
        font-size: 20px;
        text-align: center;
        /*addition to integrate*/
        color: #636b6f;
        font-weight: 200;
    }
    /*addition to integrate*/
    /*form{*/
        /*width: 100%;*/
    /*}*/

    form #text-box{
        width: 95vh;
        margin: auto auto;
        /*addition to integrate*/
        direction: ltr;
        font-family: 'Raleway', sans-serif;
    }

    form #button{
        width: 40vh;
        margin: 15px auto;

    }

    #note-form{
        direction: rtl;
    }
    #bulk-area{
        resize: none;
    }

</style>
<script type="text/javascript" src="{{url('js/mini-report-form.js')}}"></script>
@endsection

@section('content')
<div class="flex-center position-ref full-height">

    {!! Form::open(['url' => 'on-page-report']) !!}

    <div  class="flex-center position-ref title">
        أدخل الرابط
    </div>

    <div class="form-group" id="text-box">
        {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>'h t t p : / / y o u r s i t e . c o m / e x a m p l e']) }}
    </div>

    <div class="form-group" id="button">
        {{ Form::submit('فحص',['class' => 'btn btn-primary form-control']) }}
    </div>

    {!! Form::close() !!}

    {!! Form::open(['url' => 'bulk-reports','id'=>'blk-form']) !!}

    <div  class="flex-center position-ref title">
        أدخل مجموعة الروابط
    </div>

    <div class="form-group" id="text-box">
        {{ Form::textarea('urlsTextArea', null, ['class' => 'form-control','id'=>'bulk-area','placeholder'=>'h t t p : / / y o u r s i t e . c o m / e x a m p l e']) }}
        <p id="note-form">أقصي عدد 100 رابط بمعدل رابط كل سطر</p>
        {{ Form::hidden('urls', null, ['id'=>'arrayOfLines']) }}
    </div>

    <div class="form-group" id="button">
        {{ Form::button('فحص جماعي',['class' => 'btn btn-primary form-control' ,'id'=>'blk-btn']) }}
    </div>

    {!! Form::close() !!}

</div>


@endsection

@section('scripts','')