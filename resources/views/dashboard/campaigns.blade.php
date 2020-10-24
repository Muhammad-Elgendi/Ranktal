@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('seo-campaigns'))
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
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <a href="{{route('lang.seo-campaign-create',app()->getLocale())}}" class="btn btn-primary form-control hidden-print" style="margin :0;">
                @lang('create-campaign') <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>              

    {{-- View campaigns table --}}
    <div class="panel-body table-responsive" id="view-table">
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>@lang('campaign-name')</th>
                    <th>@lang('update-interval')</th>
                    <th>@lang('campaign-status')</th>
                    <th>@lang('last-track-time')</th>                        
                    <th>@lang('actions')</th>
                </tr>
            </thead>
            
            <tbody>
                @if (count($campaigns) > 0)
                    @foreach ($campaigns as $campaign)
                        <tr data-entry-id="{{ $campaign->id }}">
                            <td field-key='link'><a href="{{route('lang.seo-campaign-view',['lang'=> app()->getLocale(),'id'=> $campaign->id])}}" ><p><strong>{{ $campaign->name }}</strong></p><p>{{ $campaign->site->host }}</p></a></td>
                            <td field-key='update-interval'> @lang('every-'.$campaign->interval.'-days')</td>                              
                            <td field-key='status'> 
                                @if(!empty($campaign->status))
                                    @lang($campaign->status)
                                @endif
                            </td>
                            <td field-key='last-track-time'>{{ $campaign->last_track_at }}</td>
                            <td>
                                {{-- View Button --}}
                                <a href="{{route('lang.seo-campaign-view',['lang'=> app()->getLocale(),'id'=> $campaign->id])}}" id="campaign-view-{{$campaign->id}}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> @lang('view')</a>
                                                
                                <a class="btn btn-xs btn-success" href="{{route('lang.seo-campaign-edit',['lang'=>app()->getLocale(),'id'=> $campaign->id])}}">
                                    <i class="fa fa-edit"></i> @lang('edit')
                                </a>

                                @if($campaign->status == "Finished")
                                {!! Form::open(array(
                                    'style' => 'display: inline-block;',
                                    'method' => 'DELETE',
                                    'onsubmit' => "return confirm('".__('sure-question')."');",
                                    'route' => ['seoCampaignDelete', $campaign->id]
                                    )) !!}
                    
                                <button type="submit" class="btn btn-xs btn-danger" id="campaign-delete-{{$campaign->id}}">
                                    <i class="fa fa-trash"></i> @lang('delete')
                                </button>
                                {!! Form::close() !!}
                                @endif
                            
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
</div>
@endsection

@section('scripts')

<script>

</script>

@endsection