@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('dashboard'))

@section('styles')
<style>
/* Warning section*/
.alert a {
    text-decoration: none;
}
/*!!! Warning section*/

/* Campaigns section*/
.card{
    background-color: #ffffff;
    padding: 10px;
    border: 1px solid #d2d6de;
}
.metric{
    font-size: 3rem;
}
.campaign{
    margin-bottom: 10px;
}
.campaign-ico{
    padding: 0 5px;
}
/*!!! Campaigns section*/

</style>

@endsection


@section('content')

{{-- Show alerts for non-subscribed users after their login --}}
@if(empty(Auth::user()->plan))
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>@lang('warning') !</strong> : 
        @lang('no-subscribtion-message')        
        {{ Auth::user()->subscribed_until->format('l d-m-Y') }}
        
        {{-- @php
        // Get localized human readable date
        \Carbon\Carbon::setLocale(app()->getLocale());
        @endphp
        {{ Auth::user()->subscribed_until->diffForHumans() }} --}}


        <a href="{{route('lang.plans',app()->getLocale())}}" class="btn btn-primary btn-md" style="margin :0;">
            @lang('subscribe-now') <i class="fa fa-bolt"></i>
        </a>


    </div>
@endif
{{--!!! Show alerts for non-subscribed users after their login --}}


<div class="row">

@php
    $metrics = [
    "globalAlexaRank",
    "PageAuthority" ,
    "DomainAuthority",
    "MozTotalLinks" ,
    "MozExternalEquityLinks"
    ];
@endphp

@if(Auth::user()->campaigns->isEmpty())
<div class="jumbotron">
    <div class="text-center container">
    <h1 class="display-4">@lang('have-nothing')</h1>   
    <p class="lead">    
       <a href="{{route('lang.seo-campaign-create',app()->getLocale())}}" class="btn btn-primary btn-lg" style="margin :0;">
            @lang('create-campaign') <i class="fa fa-plus"></i>
        </a>
    </p>
    </div>
</div>
@else
    @foreach(Auth::user()->campaigns as $campaign)
        <div class="card col-xs-12 my-3">
            <div class="card-body">
            <h4 class="card-title">
                <a href="{{route('lang.seo-campaign-view',['lang'=> app()->getLocale(),'id'=> $campaign->id])}}"><i class="campaign-ico fa fa-bullhorn"></i>{{$campaign->name}}</a>
            </h4>

            @foreach($campaign->site->metric->getAttributes() as $key => $value)
            @if(in_array($key,$metrics))
                <div class="card col-xs-2 text-center" style="width: 24rem;">
                    <div class="card-body">
                    <h4 class="card-title">
                        @lang($key)
                        <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="bottom" title="@lang($key.'Subtitle')"></i>
                    </h4>
                    {{-- <h6 class="card-subtitle mb-2 text-muted">@lang($key.'Subtitle')</h6> --}}                         
                    <p class="card-text metric number">{{is_null($value) ? __('not-found') : $value}}</p>            
                    </div>
                </div>
            @endif
            @endforeach
            </div>
        </div>
    @endforeach
@endif

</div>
@endsection


@section('scripts')
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
@endsection


@section('user-image',url('/img/user.png'))


@section('user-type',__('pro-plan'))