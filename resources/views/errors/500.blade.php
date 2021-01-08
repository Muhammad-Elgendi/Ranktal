@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('internal-error'))

@section('styles','')

@section('content')

    <div class="container">
        <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="text-center py-2 px-2">
                <h2>Oops!</h2>
                <h2>Something Bad Happened</h2>
                <br>
                <div>
                    Sorry, an error has occured, You need our help!, Contact us
                </div>
                <br>
                <div class="my-2">
                    <a href="{{route('dashboard')}}" class="btn btn-primary btn-lg"><i class="fa fa-home"></i>
                        Take Me Home </a>
                    <a href="{{config('app.homepage')}}/contact-us" class="btn btn-default btn-lg"><i class="fa fa-envelope"></i> Contact Support </a>
                </div>                
            </div>
        </div>
          
    </div>
    </div>



@endsection

@section('scripts','')

