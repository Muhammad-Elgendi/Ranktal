@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('settings'))
@section('styles')
<style>

.nav>li>a {
    color: #4392F1;
}

.wrapper{
  margin-bottom: 15px;
}

.ui-w-80 {
  width: 80px !important;
  height: auto;
  margin-bottom: 10px;
}

.btn-default {
  border-color: rgba(24,28,33,0.1);
  background: rgba(0,0,0,0);
  color: #4E5155;
}

label.btn {
  margin-bottom: 0;
}

.btn-outline-primary {
  border-color: #4392F1;
  background: transparent;
  color: #4392F1;
}

.btn {
  cursor: pointer;
}

.row-bordered {
  overflow: hidden;
}

.custom-file-upload {
  border: 1px solid #4392F1;
  display: inline-block;
  padding: 6px 12px;
  cursor: pointer;
}

.alert .close {
    opacity: 9.2;
    color: #fff;
}
</style>
@endsection

@section('content')

<div class="light-style flex-grow-1 container-p-y">


  <form action="{{route('lang.edit-settings',app()->getLocale())}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

    @if ($errors->any())
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    @if (session()->has('error'))
      <div class="alert alert-danger alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         @if(is_array(session('error')))
            <ul>
                @foreach (session('error') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @else
            {{ session('error') }}
        @endif
      </div>
    @endif

    @if (session()->has('success'))
      <div class="alert alert-success alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         @if(is_array(session('success')))
            <ul>
                @foreach (session('success') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @else
            {{ session('success') }}
        @endif
      </div>
    @endif

  <div class="card overflow-hidden">
    <div class="row no-gutters row-bordered row-border-light">

       <div class="wrapper">
        <ul class="nav nav-tabs">

          <li class="active">
            <a href="#account-general" data-toggle="tab"><strong>@lang('profile')</strong></a>
          </li>

          <li >
            <a href="#account-change-password" data-toggle="tab"><strong>@lang('reset-password')</strong></a>
          </li>

          <li >
            <a href="#account-stats" data-toggle="tab"><strong>@lang('account-info')</strong></a>
          </li>

        </ul>
      </div>  

      <div class="col-md-9">
        <div class="tab-content">
          
          <div class="tab-pane active" id="account-general">
            <div class="card-body media align-items-center">
              <img src="{{ Auth::user()->photo }}" alt="user image" class="d-block ui-w-80">
              <div class="media-body ml-4">
                <label class="btn btn-outline-primary custom-file-upload" for="file-upload">
                  <i class="fa fa-cloud-upload"></i>
                  @lang('upload-new-photo')
                  </label>
                  <input id="file-upload" name='image' type="file" style="display:none;">
                </label> &nbsp;
                <button type="button" class="btn btn-default md-btn-flat" id="reset">@lang('reset')</button>
                <div class="text-light small mt-1">@lang('img-upload-msg')</div>
              </div>
            </div>
            <hr class="border-light m-0">
            <div class="card-body">
              <div class="form-group">
                <label class="form-label">@lang('name')</label>
                <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="name">
              </div>
              <div class="form-group">
                <label class="form-label">@lang('e-mail')</label>
                <input type="text" class="form-control mb-1" value="{{ Auth::user()->email }}" name="email">
                {{-- <div class="alert alert-warning mt-3">
                  Your email is not confirmed. Please check your inbox.<br>
                  <a href="javascript:void(0)">Resend confirmation</a>
                </div> --}}
              </div>
              <div class="form-group">
                <label class="form-label">@lang('site-lang')</label>
                <select name="lang" class="form-control">
                  <option value="" {{ (Auth::user()->language == '') ? "selected":"" }}>@lang('optional') (@lang('switch-lang'))</option>
                  <option value="en" {{ (Auth::user()->language == 'en') ? "selected":"" }}>@lang('english')</option>
                  <option value="ar" {{ (Auth::user()->language == 'ar') ? "selected":"" }}>@lang('arabic')</option>
                </select>     
              </div>
        
              <div class="form-group">
                <label class="form-label">@lang('company')</label>
                <input type="text" class="form-control" value="{{ Auth::user()->company }}" name="company">
              </div>
            </div>

          </div>
          
          <div class="tab-pane" id="account-change-password">
            <div class="card-body pb-2">

              <div class="form-group">
                <label class="form-label">@lang('current-password')</label>
                <input type="password" class="form-control" name="old_password">
              </div>

              <div class="form-group">
                <label class="form-label">@lang('new-password')</label>
                <input type="password" class="form-control" name="new_password">
              </div>

              <div class="form-group">
                <label class="form-label">@lang('confirm-new-password')</label>
                <input type="password" class="form-control" name="confirm_password">
              </div>

            </div>
          </div>    
          
              
          <div class="tab-pane" id="account-stats">
            <div class="card-body pb-2">
              
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">@lang('account-info')</h4>

                  <ul class="list-group list-group-flush">
                    
                    <li class="list-group-item"><strong>@lang('plan') : </strong> 
                      @if(empty(Auth::user()->plan) || Auth::user()->plan == "Trial")
                      @lang('Trial')
                      @else
                      {{ __(Auth::user()->plan) }}
                      @endif
                      <a href="{{route('lang.plans',app()->getLocale())}}" class="btn btn-primary btn-md" style="margin :0;">
                        @lang('change-plan') <i class="fa fa-edit"></i>
                      </a>
                    </li>

                    <li class="list-group-item"><strong>@lang('subscribtion-until') : </strong>
                          {{ Auth::user()->subscribed_until->format('l d-m-Y') }}
                    </li>

                    @if(isset(Auth::user()->subscription_id)) 
                    <li class="list-group-item"><strong>Subscribtion ID : </strong> {{ Auth::user()->subscription_id }}</li>
                    @endif
                  
                    @if(isset(Auth::user()->limits))  
                      <li class="list-group-item"><strong>@lang('plan-limits')</strong></li>
                      @foreach(Auth::user()->limits as $key => $value) 
                        <li class="list-group-item"><strong>@lang($key) : </strong> @lang('available') {{ Auth::user()->available_credit($key) }}  @lang('of') {{$value}}</li>
                      @endforeach
                    @endif

                  </ul>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
  <div class="text-right">
    <button type="submit" class="btn btn-primary">@lang('save-changes')</button>&nbsp;
    <a href="{{ route('lang.dashboard', app()->getLocale()) }}" class="btn btn-default">@lang('cancel')</a>
  </div>
  </form>{{-- !Form --}}
</div>


@endsection

@section('scripts')
<script>
$('#file-upload').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload')[0].files[0].name;
  $(this).prev('label').html("<i class='fa fa-cloud-upload'></i> "+file);
});

$('#reset').click(function(){
  $('#file-upload').val("");
  $('#file-upload').prev('label').html("<i class='fa fa-cloud-upload'></i> @lang('upload-new-photo')");
});

</script>
@endsection