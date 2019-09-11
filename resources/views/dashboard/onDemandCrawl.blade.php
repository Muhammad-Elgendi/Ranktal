@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('on-demand-crawl'))
@section('user-image',url('/img/user.png'))
@section('user-type',__('pro-plan'))
@section('print-div','printable')
@section('styles')
<!-- Load c3.css -->
<link href="{{url('c3/c3-v0.7.8.min.css')}}" rel="stylesheet">
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

</style>
@endsection

@section('content')
<div class="container-fluid" id="printable">    
        
                {!! Form::open(['url' => 'report','id'=>'the-form']) !!}
        <div class="row">
                <div class="col-xs-12">
                    <p class="title">@lang('site-url')</p>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">                            
                    <div class="form-group" id="text-box">
                        {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('site-url') ,'id'=>'urlInput','pattern'=>'https?://.+','required','title'=>'Page Link begins with http:// Or https://']) }}
                    </div>
                </div>
                <!-- Default unchecked -->
                <div class="form-check col-xs-12 hidden-lg hidden-md">
                    <input class="form-check-input" id="exact" type="checkbox" value="true" name="exact">
                    <label class="form-check-label" for="exact">
                        @lang('crawl-subdomain')
                    </label>
                </div>
    
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                           <button id="button" type="button" class="btn btn-primary form-control hidden-print" style="margin :0;"><i class="fa fa-search"></i></button>
                           <input type="submit" style="display:none;"/>
                </div>
        </div>
        <div class="row">
                <!-- Default unchecked -->
                <div class="form-check col-xs-12 visible-lg-block visible-md-block">
                    <input class="form-check-input" id="exact2" type="checkbox" value="true" name="exact2">
                    <label class="form-check-label" for="exact2">
                      @lang('crawl-subdomain')
                    </label>
                </div>
        </div>
                {!! Form::close() !!}                

        

            <div style="display:none; padding-bottom: 15px;" id="upper-board">
                <div class="row">
                    <div class="crawl-research-url">
                        <label class="crawl-research-url-label">
                            @lang('site-url'):
                        </label>                
                        <a id="domain" class="external-link" href="#" target="_blank" style="max-width: 100%;">
                            <span id="domain-inner">#</span>
                            <svg width="16" height="16">                                        
                                <path d="M16 10l-1-1v3H4V1h3L6 0H3v3H0v13h13v-3h3v-3zm-4 5H1V4h2v9h9v2z"></path>
                                <path d="M9 0v2h3.586L7.293 7.293l1.414 1.414L14 3.414V7h2V0"></path>
                            </svg>
                        </a>                    
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

            <div id="checks"></div>
</div>


@endsection

@section('scripts')

<script src="{{url('handlebars/handlebars-v4.1.1.js')}}" ></script>

<!-- Load d3.js and c3.js -->
<script src="{{url('c3/d3-v5.11.0.min.js')}}" charset="utf-8" ></script>
<script src="{{url('c3/c3-v0.7.8.min.js')}}" ></script>

<script>
  $( "#button" ).click(function() {
    if($("#the-form")[0].checkValidity()) {
  
        //disable button
        $("#button").attr("disabled", true);         
        let exact = ($("#exact").is(":checked") && $("#exact").is(":visible"))  || ($("#exact2").is(":checked") && $("#exact2").is(":visible"));
          $.get("{{route('lang.demandCrawlAjax',app()->getLocale())}}",{ site: $("#urlInput").val(), exact: exact }, function (jsondata) {
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
    }
    else {
        $("#the-form")[0].reportValidity();
    }
});




function updateView(jsondata){
    $('#upper-board').show();
    $('#domain-inner').text(jsondata.url);
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

    // Apply Table pagination and update counters
    var totalCount = 0;
    for(var key in jsondata.catagories ){
        totalCount += jsondata.catagories[key]['issuesCount']; 
        switch(jsondata.catagories[key]['header']){
            // Don't forget to localize
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

    // Generate charts 
    $( "#overview" ).after( "<div id=\"statusChart\"></div><div  id=\"issuesChart\" ></div>" );
    renderCharts(jsondata);
    $(window).on('beforeprint', function(){
        $('.selectRows').val("0");

        for(var key in jsondata.catagories ){  
            jsondata.catagories[key]['issues'].forEach(element => {    
                paginateTable('#'+element['title'])
                $('#'+element['title']+"-content").before("<h3>"+element['loclizedTitle']+"</h3>");
            });
        }
        $('.selectCount').hide();
        $('.selectRows').hide();
        $('.ExportCSVa').hide();
        $('.nav-pills li').addClass('active')
        $('.tab-content div').addClass('active')
     
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