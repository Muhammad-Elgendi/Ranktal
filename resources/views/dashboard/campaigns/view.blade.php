@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', in_array(app()->getLocale(),config('app.rtl')) ? __('campaign')." ".$campaign->name : $campaign->name." ".__('campaign'))
@section('user-image',url('/img/user.png'))
@section('user-type',__('pro-plan'))
@section('print-div','printable')
@section('styles')
<!-- Styles -->
<!-- Load c3.css -->
<link href="{{url('c3/c3-v0.7.8.min.css')}}" rel="stylesheet">
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
    .table td.text {
        max-width: 177px;
    }
    .table td.text a {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        max-width: 100%;
    }
    .table td.text{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .crawl-items{
        margin-left: 15px;
        margin-right: 15px;
    }
    .card{
        background-color: #ffffff;
        padding: 10px;
        border: 1px solid #d2d6de;

    }
    .metric{
        font-size: 32px;
    }
    .iphone {
        display: inline-block;
        margin: 10px;
        background-color: #f8f8f8;
        border: 1px solid #c0c0c0;
        padding: 0 10px 0 10px;
        border-radius: 25px;
        max-width: 100% !important;
        }
    .iphone-screenshot {
        max-width: 200px;
        border: 1px solid #000000;
    }
    .iphone-small-round-top {
        margin: 10px auto;
        width: 5px;
        height: 5px;
        background-color: #c0c0c0;
        border-radius: 50%;
    }
    .iphone-round-top-left {
        float: left;
        margin-left: 65px;
        margin-top: -2px;
        width: 9px;
        height: 9px;
        background-color: #c0c0c0;
        border-radius: 50%;
    }
    .iphone-speaker {
        margin: 15px auto;
        margin-top: 10px;
        width: 30px;
        height: 5px;
        background-color: #c0c0c0;
        border-radius: 3px;
    }
    .iphone-button {
        border-radius: 50%;
        margin: 10px auto;
        width: 30px;
        height: 30px;
        border: 2px solid #c0c0c0;
        background: none !important;
    }
    .desktop-img{
        border: 1px solid #e0e0e0;
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
    {{-- Page Insights --}}
    <div class="row">
        <p class="title margin-ver">@lang('page-spead-analysis')</p>
    </div>

    <div class="row">
        <ul class="nav nav-tabs" id="pageInsight-list" role="tablist">
            @foreach($campaign->site->pageInsight as $insight)
            <li class="nav-item">
              <a class="nav-link" id="{{$insight->type}}-tab" data-toggle="tab" href="#{{$insight->type}}" role="tab" aria-controls="{{$insight->type}}" aria-selected="true">@lang($insight->type)</a>
            </li>   
            @endforeach
          </ul>
          <div class="tab-content" id="pageInsight-content">
            @foreach($campaign->site->pageInsight as $insight)
                <div class="tab-pane fade" id="{{$insight->type}}" role="tabpanel" aria-labelledby="{{$insight->type}}-tab">
                    <div class="row card">
                        <div class="col-xs-12 col-lg-9">
                                <div class="card-body">
                                @if(!empty($insight->pageInsight['pageStats']))
                                  <h4 class="card-title">@lang('pageStats')</h4>
                                    <h6 class="card-subtitle mb-2 text-muted">@lang('pageStatsSubtitle')</h6>
                                      {{-- View stats table --}}
                                    <div class="panel-body table-responsive" id="stats-table">
                                        <table class="table table-hover table-bordered margin-ver">
                                            <thead>
                                                <tr>
                                                    <th>@lang('stats')</th>
                                                    <th>@lang('values')</th>                                                    
                                                </tr>
                                            </thead>                                            
                                            <tbody>
                                                @foreach ($insight->pageInsight['pageStats'] as $key => $value)
                                                    <tr>
                                                        <td>
                                                            @lang($key)
                                                        </td>
                                                        <td class="number"> 
                                                            {{$value}}
                                                        </td>
                                                    </tr>
                                                @endforeach                                            
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                    @if(!empty($insight->pageInsight['formattedResults']['ruleResults']))
                                    <h4 class="card-title">@lang('speed-optimization')</h4>
                                    <h6 class="card-subtitle mb-2 text-muted">@lang('speed-optimizationSubtitle')</h6>
                                      {{-- View optimization table --}}
                                      <div class="panel-body table-responsive" id="optimization-table">
                                        <table class="table table-hover table-bordered margin-ver">
                                            <thead>
                                                <tr>
                                                    <th>@lang('optimization-suggestions')</th>
                                                    <th>@lang('impact-percent')</th>                                                    
                                                </tr>
                                            </thead>                                            
                                            <tbody>                                   
                                                @foreach ($insight->pageInsight['formattedResults']['ruleResults'] as $rule)
                                                    <tr>
                                                        <td>@lang($rule['localizedRuleName'])</td>
                                                        <td>{{$rule['ruleImpact'].'%'}}</td>
                                                    </tr>
                                                @endforeach                                            
                                            </tbody>
                                        </table>
                                    </div>                                 
                                    @endif
                                </div>
                        </div>
                        
                        <div class="col-xs-12 col-lg-3">
                                <div class="card-body text-center">
                                  <h4 class="card-title">
                                      @lang('speed-score')
                                      <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="bottom" title="@lang('speed-scoreSubtitle')"></i>
                                  </h4>
                                  {{-- <h6 class="card-subtitle mb-2 text-muted">@lang('speed-scoreSubtitle')</h6> --}}
                                  <p class="card-text speed-score" style="font-size: 40px;">{{$insight->pageInsight['speed']}}</p>
                                  @if($insight->type == "mobile")
                                  <!-- phone container -->
                                    <div class="iphone">
                                        <!-- Small round top -->
                                        <div class="iphone-small-round-top"></div>
                                        <!-- Round top left -->
                                        <div class="iphone-round-top-left"></div>
                                        <!-- Speaker top -->
                                        <div class="iphone-speaker"></div>
                                        <!-- Screenshot -->
                                        <img src="{{$insight->screenShotSrc}}" class="iphone-screenshot">                                        
                                        <!-- Round button bottom -->
                                        <div class="iphone-button"></div>                                    
                                    </div>
                                    @else
                                    <img src="{{$insight->screenShotSrc}}" class="desktop-img">  
                                    @endif
                                </div>
                        </div>
                    </div>
                </div>
            @endforeach
          </div>    
    </div>

    {{-- Site Crawl--}}
    <div class="row">
        <p class="title margin-ver">@lang('site-crawl')</p>
    </div>


    {{-- Problems pie --}}

    <div class="row" id="problemsChart">
        <p class="text-center title">@lang('top-problems')</p>
        <div id="pieChart"></div>
    </div>
    

    {{-- View Crawl table --}}
    <div class="panel-body table-responsive" id="crawl-table">
        <table class="table table-hover table-bordered margin-ver">
            <thead>
                <tr>
                    <th>@lang('site-url')</th>
                    <th>{{ ucwords(__('crawl-subdomain')) }}</th>
                    <th>@lang('crawling-status')</th>
                    <th>@lang('last-crawling-time')</th>                        
                    <th>@lang('actions')</th>
                </tr>
            </thead>
            
            <tbody>
                @if($campaign->site !== null)
                        <tr>
                            <td field-key='link'><a href="#" onclick="view();return false;">{{ $campaign->site->host }}</a></td>
                        
                            @if($campaign->site->exact_match)
                            <td><span class="glyphicon glyphicon-ok-sign text-success fa-lg"></span></td>
                            @else
                            <td><span class="glyphicon glyphicon-remove-sign text-danger fa-lg"></span></td>
                            @endif

                            <td field-key='crawling-status'> @lang($campaign->site->crawlingJob->status)</td>
                            <td field-key='last-crawling-time'>{{ $campaign->site->crawlingJob->finished_at }}</td>
                            <td>
                                        
                                <a href="#" onclick="view();return false;" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> @lang('view')</a>
                          
                                @if($campaign->site->crawlingJob->status == 'Finished')
                                <button class="btn btn-xs btn-success" onclick="recrawl({!! $campaign->site->id !!});return false;" >
                                    <i class="fa fa-refresh"></i> @lang('recrawl')
                                </button>
                                @endif
                            
                            </td>
                        </tr>                    
                @else
                    <tr>
                        <td colspan="8">@lang('no_entries_in_table')</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

        {{-- Site Crawl elements --}}
   
        <div style="display:none; padding-bottom: 15px;" id="upper-board">
            <div class="row">
                <div class="crawl-items">
                    <label class="crawl-items-label">
                        @lang('site-url') :
                    </label>                
                    <a id="domain" class="external-link" href="#" target="_blank" style="max-width: 100%;">
                        <span id="domain-inner">#</span>
                        <svg width="16" height="16">                                        
                            <path d="M16 10l-1-1v3H4V1h3L6 0H3v3H0v13h13v-3h3v-3zm-4 5H1V4h2v9h9v2z"></path>
                            <path d="M9 0v2h3.586L7.293 7.293l1.414 1.414L14 3.414V7h2V0"></path>
                        </svg>
                    </a>                    
                </div>
                <div class="crawl-items">
                    <label class="crawl-items-label">
                        @lang('last-crawling-time') :
                    </label>                
                    <span id="last-crawl-time">#</span>                    
                </div>
            </div>
            <div class="row">                    
                <div class="col-md-3 col-sm-6 col-xs-6 container-border text-center">
                    <p class="title">@lang('pages-crawled')</p>
                    <p class="title" id="pages-crawled"></p>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 container-border text-center">
                        <p class="title">@lang('crawling-status')</p>
                        <p class="title" id="crawling-status"></p>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-6 container-border text-center">
                    <p class="title">@lang('issues-by-category')</p>                        
                        <div id="issues-by-category">
                            <div>
                                <a class="summary-issues" href="#crawlerIssues">@lang('critical-crawler')</a>
                                <span class="summary-issues" id="critical">0</span>
                            </div>
                            <div>
                                <a class="summary-issues" href="#crawlerWarnings">@lang('crawler-warnings')</a>
                                <span class="summary-issues"id="warnings">0</span>
                            </div>
                            <div>
                                <a class="summary-issues" href="#metadataIssues">@lang('metadata-issues')</a>
                                <span class="summary-issues" id="metadata">0</span>
                            </div>
                            <div>
                                <a class="summary-issues" href="#redirectIssues">@lang('redirect-issues')</a>
                                <span class="summary-issues" id="redirect">0</span>
                            </div>
                            <div>
                                <a class="summary-issues" href="#contentIssues">@lang('content-issues')</a>
                                <span class="summary-issues" id="content">0</span>
                            </div>
                        </div> 
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 container-border text-center">
                    <p class="title">@lang('total-issues')</p>
                    <p class="title"  id="total-issues">0</p>
                </div>
            </div>
        </div>

        <div id="checks" style="display:none;"></div>

        {{-- Page Optimization --}}
        <div class="row">
            <p class="title ">@lang('page-optimization')</p>
        </div>

        <div class="row">
            {{-- page optimization table --}}
            <div class="panel-body table-responsive" id="page-optimization-table">
                <table class="table table-hover table-bordered margin-ver">
                    <thead>
                        <tr>
                            <th>@lang('page-link')</th>                           
                            <th>@lang('keyword')</th>
                            <th>@lang('page-score')</th>
                            <th>@lang('actions')</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @if (count($campaign->optimization) > 0)
                        @foreach ($campaign->optimization as $optimization)    
                            {{-- check if the report is ready --}}
                            @if(isset($optimization->report))
                                    <tr>                                    
                                        <td><a href="{{$optimization->url}}" target="_blank"> {{ $optimization->url }} </a></td>
                                        <td> {{ $optimization->keyword }}</td>
                                        <td>{{ $optimization->report['score'] }}</td>
                                        <td>
                                            <a href="{{route('lang.seo-campaign-view-optimization',['lang'=>app()->getLocale(),'campaign_id' => $campaign->id ,'page_id' => $optimization->id])}}" class="btn btn-xs btn-primary" target="_blank"><i class="fa fa-eye"></i> @lang('view')</a>
                                        </td>
                                    </tr> 
                            @endif
                        @endforeach
                        @else
                            <tr>
                                <td colspan="8">@lang('no_entries_in_table')</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
   

</div>
@endsection

@section('scripts')
<script src="{{url('handlebars/handlebars-v4.1.1.js')}}" ></script>

<!-- Load d3.js and c3.js -->
<script src="{{url('c3/d3-v5.11.0.min.js')}}" charset="utf-8" ></script>
<script src="{{url('c3/c3-v0.7.8.min.js')}}" ></script>

<script>   

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

$('.number').each(function () {
    var item = $(this).text();
    var num = Number(item).toLocaleString('en');
    if(num !=="NaN"){
        $(this).text(num);
    }    
});

$('.speed-score').each(function(){
// The color-coding maps to these Performance score ranges:
// 0 to 49 (slow): Red
// 50 to 89 (average): Orange
// 90 to 100 (fast): Green
    var score = Number($(this).text());
    if(score <= 49){
        $(this).css('color','#ff4e42');
    }else if(score >= 50 && score <= 89){
        $(this).css('color','#ffa400');
    }else if(score >= 90){
        $(this).css('color','#0cce6b');
    }
});

$('#pageInsight-list li:first').addClass('active');
$('#pageInsight-content div:first').addClass('active in');



$(document).ready(function(){
    $.get("{{route('lang.demandCrawlAjax',app()->getLocale())}}",{ site: "{{$campaign->site->host}}", exact: "{{$campaign->site->exact_match}}" }, function (jsondata) {
        window.crawlData = jsondata;
        // draw problems chart
        renderPie(jsondata.count);
        $.get("{{url('templates/NewTableComponent.hbs')}}", function (data) {
        var template=Handlebars.compile(data);      
        $("#checks").html(template(jsondata.catagories));                
        }, 'html');
    },'json');
});


function renderPie(counts){
    var chart = c3.generate({
    bindto:'#pieChart',
    data: {   
        columns: counts,
        type : 'donut'
    },
    donut: {
        title: "@lang('problems')",
        label: {
          format: function(value, ratio, id) {
            return value+" "+"@lang('problem')";
          }
        },
        width: 100
    }
    });
    $('#pieChart svg').css("direction","ltr");
}

function view(){
    updateView(crawlData);
    $('#checks').show();
    $('#problemsChart').hide();
    $('#crawl-table').hide();
}

function recrawl(number){
    if(confirm("@lang('sure-question')")){
        $.get("{{route('lang.demandCrawlRecrawl',app()->getLocale())}}",{ id: number }, function (jsondata) {
                $("#the-form").hide();
                $.get("{{url('templates/NewTableComponent.hbs')}}", function (data) {
                var template=Handlebars.compile(data);      
                $("#checks").html(template(jsondata.catagories));
                    // update view
                    updateView(jsondata);                
                }, 'html');
                //Enable button
                $("#button").removeAttr("disabled"); 
        },'json');
        $('#view-table').hide();
    }
}


function updateView(jsondata){
    $('#upper-board').show();
    $('#domain-inner').text(jsondata.url);
    $('#last-crawl-time').text(jsondata.lastCrawl);
    $('#domain').attr('href',jsondata.url);    
    $('#crawling-status').text( jsondata.status );
    $('#pages-crawled').text( jsondata.pagesCount );  

    // Activate the first tab
    $('.nav-pills li:first-child').addClass('active')
    $('.tab-content div:first-child').addClass('active')

    // Get translation
    $('.selectCount').text("@lang('selectCount')")
    $('.showAll').text("@lang('showAll')")
    $('.ExportCSV').text("@lang('ExportCSV')")

    $('.ExportCSVa').on('click',function(){
        exportTableToCSV($(this).parent().parent().next("table").attr('id')+".csv",$(this).parent().parent().next("table").attr('id'));
    });

    // Add sitemap btn
    $('#btns-section').append("<a class=\"btn btn-primary\" href=\"{{route('demandCrawlsitemap')}}?id="+jsondata.siteId+"\"> <span class=\"glyphicon glyphicon-save-file\"></span> @lang('download-sitemap')</button>")

    // Show print btn
    $('#print-btn').show();

    // Apply Table pagination and update counters
    var totalCount = 0;
    for(var key in jsondata.catagories ){
        totalCount += jsondata.catagories[key]['issuesCount']; 
        switch(jsondata.catagories[key]['header']){
            case "@lang('critical-crawler')":
                $('#critical').text( jsondata.catagories[key]['issuesCount'] );
                break;
            case "@lang('crawler-warnings')":
                $('#warnings').text( jsondata.catagories[key]['issuesCount'] );
                break;
            case "@lang('metadata-issues')":
                $('#metadata').text( jsondata.catagories[key]['issuesCount'] );
                break;
            case "@lang('redirect-issues')":
                $('#redirect').text( jsondata.catagories[key]['issuesCount'] );
                break;
            case "@lang('content-issues')":
                $('#content').text( jsondata.catagories[key]['issuesCount'] );
                break;        

        }
        jsondata.catagories[key]['issues'].forEach(element => {    
            paginateTable('#'+element['title'])
        });
    }
    $('#total-issues').text( totalCount );

    if(!jsondata.pagesCount > 0 && jsondata.status != "@lang('Finished')" ){
        // show some things take some time
        $( "#upper-board" ).after( "<div class='alert alert-info text-center' role='alert'><i class='fa fa-hourglass-half'></i> <strong> @lang('takes-time') </strong> @lang('come-back-later')</div>");
    }else{
        // Generate charts 
        $( "#overview" ).after( "<div id=\"statusChart\"></div><div  id=\"issuesChart\" ></div>" );
        renderCharts(jsondata);
    }
  
    $(window).on('beforeprint', function(){
        $('.selectRows').val("0");
        for(var key in jsondata.catagories ){  
            jsondata.catagories[key]['issues'].forEach(element => {    
                paginateTable('#'+element['title']);
                $('#'+element['title']+"-content").before("<h3>"+element['loclizedTitle']+"</h3>");
            });
        }
        $('.selectCount').hide();
        $('.selectRows').hide();
        $('.ExportCSVa').hide();
        $('.nav-pills li').addClass('active')
        $('.tab-content div').addClass('active')


        $('#pageInsight-list li').addClass('active');
        $('#pageInsight-content div').addClass('active in');
        $('#mobile').before("<h3>@lang('mobile')</h3>");
        $('#desktop').before("<h3>@lang('desktop')</h3>");
        $('#pageInsight-list').hide();     
        $('#page-optimization-table th:last,#page-optimization-table td:last').remove();     
    });
   
}

function renderCharts(jsondata){
  
    var chart = c3.generate({
    bindto:'#statusChart',
    data: {   
        columns: [
            ['2XX', jsondata.count2xx],
            ['3XX', jsondata.count3xx],
            ['4XX', jsondata.count4xx],
            ['5XX', jsondata.count5xx]
        ],
        type : 'donut'
    },
    donut: {
        title: "@lang('status')",
        label: {
          format: function(value, ratio, id) {
            return value+" "+"@lang('pages')";
          }
        },
        width: 100
    }
    });
    $('#statusChart svg').css("direction","ltr");

    var chart2 = c3.generate({
        bindto:'#issuesChart',
        data: {
            columns:jsondata.count,
            type:'bar'
        },
        axis: {
            rotated: true
        }
    });
    $('#issuesChart svg').css("direction","ltr");

}

function exportTableToCSV(filename,tableId) {
    var csv = [];
    var rows = $('#'+tableId+" tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++){
            row.push(cols[j].innerText);
        }           
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

function paginateTable(table){     
    $(table+'-maxRows').on('change', function(){
        $(table+'-page'+'.pagination').html('')
        var trnum = 0
        var totalRows = $(table+' tbody tr').length
        var maxRows = parseInt($(this).val()) == 0 ? totalRows : parseInt($(this).val());
        $(table+' tr:gt(0)').each(function(){
            trnum++
            if(trnum > maxRows){
                $(this).hide()
            }
            if(trnum <= maxRows){
                $(this).show()
            }
        })
        if(totalRows > maxRows){
            var pagenum = Math.ceil(totalRows/maxRows)
            for(var i=1;i<=pagenum;){
                $(table+'-page'+'.pagination').append('<li data-page="'+i+'">\<span>'+ i++ +'<span class="sr-only">(current)</span></span>\</li>').show()
            }
        }
        $(table+'-page'+'.pagination li:first-child').addClass('active')
        $(table+'-page'+'.pagination li').on('click',function(){
            var pageNum = $(this).attr('data-page')
            var trIndex = 0;
            $(table+'-page'+'.pagination li').removeClass('active')
            $(this).addClass('active')
            $(table+' tr:gt(0)').each(function(){
                trIndex++
                if(trIndex > (maxRows*pageNum) || trIndex <= ((maxRows*pageNum)-maxRows)){
                    $(this).hide()
                } else{
                    $(this).show()
                }
            })
        })
    })
    $(table+'-maxRows').trigger('change');
}
</script>
@endsection