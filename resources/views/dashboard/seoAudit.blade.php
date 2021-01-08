@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('seo-audit'))
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
    .section-header{
        font-size: 20px;
        padding: 15px 15px 0 15px;
    }

</style>
@endsection

@section('content')
<div class="container-fluid">    
        <div class="row">
                {!! Form::open(['id'=>'the-form']) !!}
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                <p class="title">@lang('page-link')</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('page-link') ,'id'=>'urlInput','pattern'=>'https?://.+','required','title'=>'Page Link begins with http:// Or https://']) }}
                                </div>
                </div>
    
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                           <button id="button" type="button" class="btn btn-primary form-control hidden-print" style="margin-top: 38px;">@lang('audit') <i class="fa fa-calendar-check-o"></i></button>
                           <input type="submit" style="display:none;"/>
                </div>
                {!! Form::close() !!}
        </div>

        {{-- View Audit table --}}
        <div class="panel-body table-responsive" id="view-table">
            <table class="table table-bordered table-striped datatable">
                <thead>
                    <tr>
                        <th>@lang('page-link')</th>
                        <th>@lang('audit-time')</th>
                        <th>@lang('actions')</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($pages) > 0)
                        @foreach ($pages as $page)
                            <tr data-entry-id="{{ $page->id }}">
                                <td field-key='link'><a href="#" onclick="view('{{ $page->url }}');return false;">{{ $page->url }}</a></td>
                                <td field-key='create-date'>{{ $page->created_at }}</td>
                                <td>
                                  
                                    <a href="#" onclick="view('{{ $page->url }}');return false;" id="page-view-{{$page->id}}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> @lang('view')</a>
                                                       
                               
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".__('sure-question')."');",
                                        'route' => ['seoAuditDelete', $page->id]
                                        )) !!}
                      
                                    <button type="submit" class="btn btn-xs btn-danger" id="page-delete-{{$page->id}}">
                                        <i class="fa fa-trash"></i> @lang('delete')
                                    </button>
                                    {!! Form::close() !!}
                      
                                    <button class="btn btn-xs btn-success" onclick="reaudit({!! $page->id !!});return false;" >
                                        <i class="fa fa-refresh"></i> @lang('reaudit')
                                    </button>
                               
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">@lang('no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
            <div id="printable">
                <div style="display:none; padding-bottom: 15px;" id="upper-board">

                    <div class="row">    
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="title">
                                <p class="title">@lang('page-link')</p> 
                                <a id="url-value" href=""></a>
                                
                                <p class="title">@lang('page-title')</p> 
                                <p id="title-value"></p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="desc">
                                <p class="title">@lang('page-description')</p> 
                                <p id="desc-value"></p> 
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

                <div class="row" id="checks"></div>    
            </div>
    
</div>


@endsection

@section('scripts')

<script src="{{url('handlebars/handlebars-v4.1.1.js')}}" ></script>
<script>
  $( "#button" ).click(function() {
    if($("#the-form")[0].checkValidity()) {
  
        //disable button
        $("#button").attr("disabled", true);

        // view data
        view($("#urlInput").val());

        //Enable button
        setTimeout(function() {
            $("#button").removeAttr("disabled");
        },2500);   // enable after 2 seconds       
        
    }
    else {
        $("#the-form")[0].reportValidity();
    }
});

function view(url){
    $.get("{{route('lang.seoAuditAjax',app()->getLocale())}}",{ u: url }, function (jsondata) {
            $("#urlInput").attr("placeholder", url);

                $.get("{{url('templates/panelComponent.hbs')}}", function (data) {
                var template=Handlebars.compile(data);      
                $("#checks").html(template(jsondata.checks));
                    // update view
                    updateView(jsondata);
                }, 'html'); 
        },'json');
    $('#view-table').hide();
    $('#print-btn').show();
}

function reaudit(number){
    if(confirm("@lang('sure-question')")){
        $.get("{{ route('lang.seoAuditReaudit',app()->getLocale()) }}",{id: number}, function (jsondata) {
            $("#urlInput").attr("placeholder", $("#urlInput").val());

                $.get("{{url('templates/panelComponent.hbs')}}", function (data) {
                var template=Handlebars.compile(data);      
                $("#checks").html(template(jsondata.checks));
                    // update view
                    updateView(jsondata);
                }, 'html');          
        },'json');
    $('#view-table').hide();
    }
}

function updateView(jsondata){
    // Add expand/shrink btn
    $('#btns-section').append("<button class=\"btn btn-primary\" onclick=\"toggle()\"\"> <i class=\"fa fa-bullseye\"></i> @lang('toggle-panels')</button>")
    $('#upper-board').show();
    $('#url-value').text(jsondata.url).attr('href',jsondata.url);
    $('#title-value').text(jsondata.pageTitle);
    $('#desc-value').text(jsondata.pageDescription);
    
    $('#hurting').text( $('#checks .glyphicon-remove-sign').size() );
    $('#helping').text( $('#checks .glyphicon-ok-sign').size() );
    $('#all-issues').text( $('#checks .glyphicon-ok-sign').size() + $('#checks .glyphicon-remove-sign').size() );

    $('.panel-heading').on('click', function(e) {
        $(e.target).find("span.clickable").toggleClass('glyphicon-chevron-up glyphicon-chevron-down',200, "easeOutSine" );
    });

    $('#hurting-block').click(function() {
        $('.glyphicon-remove-sign').parent().parent().parent().show();
        $('.glyphicon-ok-sign').parent().parent().parent().hide();
        $( "#hurting-block" ).addClass( "active-issue" );
        $('#helping-block,#issues-block').removeClass( "active-issue" );
    });
    $('#helping-block').click(function() {
        $('.glyphicon-remove-sign').parent().parent().parent().hide();
        $('.glyphicon-ok-sign').parent().parent().parent().show();
        $( "#helping-block" ).addClass( "active-issue" );
        $('#issues-block,#hurting-block').removeClass( "active-issue" );
    });
    $('#issues-block').click(function() {
        $('.glyphicon-remove-sign').parent().parent().parent().show();
        $('.glyphicon-ok-sign').parent().parent().parent().show();
        $( "#issues-block" ).addClass( "active-issue" );
        $('#helping-block,#hurting-block').removeClass( "active-issue" );
    });
}

function toggle(){
    $('.panel-heading').click();
}
</script>

@endsection