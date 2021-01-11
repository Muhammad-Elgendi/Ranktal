{{-- Non-working blade for email of campaign notification
    See campaignUpdates blade
--}}
@extends('layouts.email-main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', $title)

@section('styles')
<style>
.title {
    font-size: 20px;
    color: #636b6f;
    font-weight: 200;
}
.container-border{
    border: 1px solid #ccc; 
    height: 144px;
}
.active-issue{
    background-color: #ccc;
    color: white;
}
.section-header{
    font-size: 20px;
    padding: 15px 15px 0 15px;
}
.summary-issues{
    padding: 0 12px;
}
/* On screens that are 600px or less */
@media screen and (max-width: 970px) {
    .summary-issues{
        padding: 0 1px;
    }
    body {  
        font-size: 11px;
    }
}
.margin-ver{
    margin: 10px 0; 
}
.margin-hor{
    margin: 0 5px;
}
.pagination{
    margin: 5px 0;
}
.title-wrapper{
    border-bottom: solid 2px #DBE3E3;
}         
.crawl-items{
    margin-left: 15px;
    margin-right: 15px;
}
.card{
    background-color: #ffffff;
    padding: 10px;
    border: 1px solid #d2d6de;
    width: 24rem;
}
.metric{
    font-size: 28px;
}
</style>
@endsection

@php
$allowedMetrics = [
    "globalAlexaRank",
    "alexaReach" ,
    "rankDelta" ,
    "countryName",
    "countryRank" ,
    "alexaBackLinksCount" ,
    "PageAuthority" ,
    "DomainAuthority",
    "MozTotalLinks" ,
    "MozExternalEquityLinks"
    ];

@endphp

@section('content')
<div class="container-fluid" id="printable">
    {{-- Site metrics --}}
    <div class="row">
        <p class="title margin-ver">@lang('site-metrics')</p>
    </div>
    <div class="row text-center">
        @foreach($campaign->site->metric->getAttributes() as $key => $value)
        @if(in_array($key,$allowedMetrics))
        <div class="card col-xs-2" style="width: 24rem;">
            <div class="card-body">
              <h4 class="card-title">
                  @lang($key)
                  <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="bottom" title="@lang($key.'Subtitle')"></i>
            </h4>
              {{-- <h6 class="card-subtitle mb-2 text-muted">@lang($key.'Subtitle')</h6> --}}
              @if($key == 'countryName' && $countryCode != null)
              <p class="card-text metric"><span class="flag-icon flag-icon-{{$countryCode}}"></span> {{is_null($value) ? __('not-found') : $value}}</p>
              @elseif($key == "rankDelta")
                @if(stripos($value, '-') !== FALSE)
                <p class="card-text metric"> 
                    <i class="fa fa-angle-double-up btn-success"></i>
                    {{is_null($value) ? __('not-found') : substr($value,1)}}
                </p>
                @elseif(stripos($value, '+') !== FALSE)
                <p class="card-text metric"> 
                    <i class="fa fa-angle-double-down btn-danger"></i>
                    {{is_null($value) ? __('not-found') : substr($value,1)}}
                </p>
                @else
                <p class="card-text metric">{{is_null($value) ? __('not-found') : $value}}</p>
                @endif
              @else              
              <p class="card-text metric number">{{is_null($value) ? __('not-found') : $value}}</p>
              @endif
            </div>
        </div>
        @endif
        @endforeach
    </div>

    {{-- Site Crawl elements --}}

    <div style="padding-bottom: 15px;" id="upper-board">       
        <hr>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-6 container-border text-center">
                <p class="title"> @lang('site-url')</p>
                <p class="title" id="site-url">{{$campaign->site->host}}</p>
            </div>   
            <div class="col-md-3 col-sm-6 col-xs-6 container-border text-center">
                <p class="title">@lang('last-crawling-time')</p>
                <p class="title" id="last-crawling-time">{{$campaign->site->crawlingJob->finished_at}}</p>
            </div>                       
            <div class="col-md-3 col-sm-6 col-xs-6 container-border text-center">
                <p class="title">@lang('pages-crawled')</p>
                <p class="title" id="pages-crawled">{{ $pages }}</p>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 container-border text-center">
                    <p class="title">@lang('crawling-status')</p>
                    <p class="title" id="crawling-status">@lang($campaign->site->crawlingJob->status)</p>
            </div>   
        </div>
    </div>
</div>
@endsection