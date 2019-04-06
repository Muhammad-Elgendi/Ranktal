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

</style>
@endsection

@section('content')
<div class="container-fluid">    
        <div class="row">
                {!! Form::open(['url' => 'report']) !!}
                <div class="col-lg-5 col-xs-12">
                                <p class="title">@lang('page-link')</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('page-link')]) }}
                                </div>
                </div>
                <div class="col-lg-5 col-xs-12">
                                <p class="title">@lang('keyword')</p>
                                <div class="form-group" id="text-box">
                                    {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>__('keyword')]) }}
                                </div>                            
                </div>
                <div class="col-lg-2 col-xs-12">
                           <button id="button" type="button" class="btn btn-primary form-control" style="margin-top: 38px;"><i class="fa fa-search"></i></button>
                </div>
                {!! Form::close() !!}
        </div>

        <div class="row">

                <div class="panel panel-default">
                  <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <h4 class="panel-title">
                        <span class="glyphicon glyphicon-flag text-success fa-2x"></span>折りたたみグループアイテム #1
                        <span class="glyphicon glyphicon-chevron-down clickable"></span>           
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse">
                    <div class="panel-body">１個目の内容</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    <h4 class="panel-title"> 
                        <span class="glyphicon glyphicon-flag text-info fa-2x"></span>折りたたみグループアイテム #2
                        <span class="glyphicon glyphicon-chevron-down clickable"></span>             
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">２個目の内容</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                    <h4 class="panel-title">                  
                        <span class="glyphicon glyphicon-flag text-danger fa-2x"></span>折りたたみグループアイテム #3
                        <span class="glyphicon glyphicon-chevron-down clickable"></span>                  
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">３個目の内容</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                    <h4 class="panel-title"> 
                        <span class="glyphicon glyphicon-flag text-warning fa-2x"></span>折りたたみグループアイテム #2
                        <span class="glyphicon glyphicon-chevron-down clickable"></span>             
                    </h4>
                  </div>

                  <div id="collapse4" class="panel-collapse collapse">

                    {{-- body of panel with padding --}}

                    <div class="panel-body">
                    {{-- info div --}}
                      <div class="alert alert-info">
                          <i class="fa fa-info-circle" aria-hidden="true"></i>
                           <strong>معلومه</strong>
                           <article>
                           تعد وسوم Meta أحد الأشياء التي تقرأها جميع الروبوتات بما فيها محركات البحث و روبوتات تطبيقات أخري
                       </article>
                       </div>

                       {{-- attribute table --}}
                       <table class="table">
                          <tbody>
                               <tr>
                                <th>First Name</th>
                                  <td>John</td> 
                              </tr>
                              <tr>
                                <th>Last Name</th>
                                  <td>Carter</td>   
                              </tr>
                            <tr>
                                <th>Email</th>
                                  <td>johncarter@mail.com</td>    
                              </tr>
                          </tbody>
                      </table>
                              
                    {{-- Data table --}}

                    <p>The .table-striped class adds zebra-stripes to a table:</p>            
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Firstname</th>
                          <th>Lastname</th>
                          <th>Email</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>John</td>
                          <td>Doe</td>
                          <td>john@example.com</td>
                        </tr>
                        <tr>
                          <td>Mary</td>
                          <td>Moe</td>
                          <td>mary@example.com</td>
                        </tr>
                        <tr>
                          <td>July</td>
                          <td>Dooley</td>
                          <td>july@example.com</td>
                        </tr>
                      </tbody>
                    </table>
                    
                         {{-- required action --}}
                         ２個目の内容
                        </div>
                  </div>
                </div>
              

        </div>
</div>


@endsection

@section('scripts')
<script>
$('.panel-default').on('click', function(e) {
    // $(this).toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
    $(e.target).find("span.clickable").toggleClass('glyphicon-chevron-up glyphicon-chevron-down',200, "easeOutSine" );
});
</script>
@endsection