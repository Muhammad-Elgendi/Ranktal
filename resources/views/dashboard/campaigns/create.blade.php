@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('create-campaign'))
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
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        {!! Form::open(['url'=> route('lang.seo-campaign-store',app()->getLocale()),'id'=>'the-form']) !!}
        <div class="form-group">

            <p class="title">@lang('site-url')</p>

            {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('site-url') ,'id'=>'urlInput','pattern'=>'https?://.+','required','title'=>'Page Link begins with http:// Or https://']) }}
                                
         
            <div class="form-check col-xs-12">
                <label class="form-check-label" for="exact">
                    @lang('crawl-subdomain')
                </label>
                <input class="form-check-input" id="exact" type="checkbox" value="true" name="exact">
            
            </div>

            <p class="title">@lang('campaign-name')</p>

            {{ Form::text('name', null, ['class' => 'form-control','placeholder'=>__('campaign-name') ]) }}

            <p class="title">@lang('update-interval')</p>

            <select name="interval" class="form-control">
                    <option selected="selected" value="7">@lang('every-7-days')</option>
                    <option value="10">@lang('every-10-days')</option>    
                    <option value="15">@lang('every-15-days')</option>
                    <option value="30">@lang('every-30-days')</option>  
            </select>           
        </div>

            <p class="title">@lang('page-optimization')</p>

            {{-- Pages table --}}
            <div class="panel-body table-responsive">
                <table class="table table-bordered table-striped datatable" id="pages-table">
                    <thead>
                        <tr>
                            <th>@lang('keyword')</th>
                            <th>@lang('page-link')</th>
                            <th>@lang('actions')</th>                             
                        </tr>
                    </thead>
                    
                    <tbody>
                        <tr>
                            <td>
                                {{ Form::text('keyword[]', null, ['class' => 'form-control','placeholder'=>__('keyword'),'pattern'=>'[\S]+.*','required','title'=>'Keyword must be at least one charcter or more' ]) }}
                            </td>
                            <td>
                                {{ Form::text('page-link[]', null, ['class' => 'form-control','placeholder'=>__('page-link'),'pattern'=>'https?://.+','required','title'=>'Page Link begins with http:// Or https://' ]) }}
                            </td>
                            <td>
                                <button class="btn btn-xs btn-success add-btn" onclick="addRow();return false;" >
                                    <i class="fa fa-plus fa-2x"></i>
                                </button>
                                <button class="btn btn-xs btn-danger delete-btn" onclick="removeRow();return false;">
                                    <i class="fa fa-minus fa-2x"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary form-control hidden-print">@lang('create-campaign') <i class="fa fa-bullhorn"></i></button>
        {!! Form::close() !!}
    </div>
</div>    
        
      

@endsection

@section('scripts')
<script>
    function addRow(){        
        if($('#pages-table tbody tr').length == 2 && !$('#pages-table tbody tr:first').is(':visible')){
            $('#pages-table tbody tr:first').show();
            $('#pages-table tbody tr:first td:nth-child(2) input').attr('required',true);
            $('#pages-table tbody tr:last').remove();
        }else{
            $('#pages-table tbody').append('<tr>'+$('#pages-table tbody tr:first').html()+'</tr>');
        }
        $(".delete-btn,.add-btn").hide();
        $(".delete-btn:last,.add-btn:last").show();
    }
    function removeRow(){    
        if($('#pages-table tbody tr').length == 1){
            $('#pages-table tbody tr:last').hide();
            $('#pages-table tbody tr:last td input').attr('required',false);
            $('#pages-table tbody tr:last td input').val('');
        }
        else{
            $('#pages-table tbody tr:last').remove();
        }
        if($('#pages-table tbody tr').length == 1 && !$('#pages-table tbody tr:first').is(':visible')){
            $('#pages-table tbody').append("<tr><td colspan='2'>@lang('no_entries_in_table')</td>"+
              "<td><button class=\"btn btn-xs btn-success\" onclick=\"addRow();return false;\">"+
              "<i class=\"fa fa-plus fa-2x\"></i></button></td></tr>");
        }
        $(".delete-btn,.add-btn").hide();
        $(".delete-btn:last,.add-btn:last").show();
    }
</script>
@endsection