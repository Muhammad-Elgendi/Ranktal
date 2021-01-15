@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('plans'))

@section('styles')
<style>
/* Pricing */

#pricing{
  font-family: "Source Sans Pro", "helvetica", sans-serif;
  font-style: normal;
  font-weight: normal;
  text-align: center;
  font-size: 16px;
  color: rgba(39,65,90,1);
}

.plan-tier ul,.plan-tier ol {
  list-style: none;
  padding: 0px 2em;
}

.plans {
background: #ECE8EF;
}

.layer {
clear: both;
width: 100%;
height: auto;
display: block;
}

.layer > section, .layer > article {
clear: both;
width: 100%;
height: auto;
max-width: 1092px;
margin: 0 auto;
display: block;
}

.third {
margin: 0 30px 0 0;
display: inline-block;
}

.plan-tier {
background: white;
vertical-align: baseline;
border-radius: 3px;
-moz-border-radius: 3px;
overflow: hidden;
}

.lift {
position: relative;
-webkit-transition: all .075s ease-out;
-moz-transition: all .075s ease-out;
-o-transition: all .075s ease-out;
transition: all .075s ease-out;
}

.lift:hover {
top: -3px;
-webkit-box-shadow: 0 2px 6px rgba(39,65,90,.15);
-moz-box-shadow: 0 2px 6px rgba(39,65,90,.15);
box-shadow: 0 2px 6px rgba(39,65,90,.15);
}

.plan-tier h4 {
padding: 18px 0 15px;
margin: 0 0 30px;
background: #4392F1;
color: white;
}

.plan-tier sup {
position: relative;
right: -9px;
}

.plan-tier ul {
margin: 30px 0 0;
border-top: 2px solid #ECE8EF;
}

.plan-tier ul li {
font-size: 1.25em;
padding: 18px 0;
color: rgba(39,65,90,.9);
border-bottom: 2px solid #ECE8EF;
}

sup {
vertical-align: top;
font-size: 100%;
top: 0.5em;
}

.plan-tier .plan-price {
font-size: 4em;
font-weight: 300;
letter-spacing: -3px;
}

.plan-tier sub {
vertical-align: bottom;
position: relative;
bottom: .875em;
}

.plan-tier .early-adopter-price {
color: #4392F1;
}
p:first-of-type {
margin-top: 0;
}

small, del {
color: rgba(39,65,90,.5);
font-size: 1em;
line-height: 1.5em;
}

s, strike, del {
text-decoration: line-through;
}

/* Most popular */

.plan-tier.callout h6 {
width: 100%;
color: white;
font-size: 1.25em;
padding: 18px 0 15px;
margin: 0;
}

.callout{
    padding: 0;
}

/*!!! Pricing */

/* Loader Section */
.container {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  min-height: 100vh;
}

.loader {
  max-width: 15rem;
  width: 100%;
  height: auto;
  stroke-linecap: round;
}

circle {
  fill: none;
  stroke-width: 3.5;
  -webkit-animation-name: preloader;
          animation-name: preloader;
  -webkit-animation-duration: 3s;
          animation-duration: 3s;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
  -webkit-animation-timing-function: ease-in-out;
          animation-timing-function: ease-in-out;
  -webkit-transform-origin: 170px 170px;
          transform-origin: 170px 170px;
  will-change: transform;
}
circle:nth-of-type(1) {
  stroke-dasharray: 550;
}
circle:nth-of-type(2) {
  stroke-dasharray: 500;
}
circle:nth-of-type(3) {
  stroke-dasharray: 450;
}
circle:nth-of-type(4) {
  stroke-dasharray: 300;
}
circle:nth-of-type(1) {
  -webkit-animation-delay: -0.15s;
          animation-delay: -0.15s;
}
circle:nth-of-type(2) {
  -webkit-animation-delay: -0.3s;
          animation-delay: -0.3s;
}
circle:nth-of-type(3) {
  -webkit-animation-delay: -0.45s;
  -moz-animation-delay:  -0.45s;
          animation-delay: -0.45s;
}
circle:nth-of-type(4) {
  -webkit-animation-delay: -0.6s;
  -moz-animation-delay: -0.6s;
          animation-delay: -0.6s;
}

@-webkit-keyframes preloader {
  50% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}

@keyframes preloader {
  50% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}

/* Fix colors of user header */
.navbar-nav>.user-menu>.dropdown-menu>li.user-header>p>small {
   color: rgba(255,255,255,0.8);
}

/*!!! Loader Section */

</style>
@endsection


@section('content')

<meta name="csrf-token" content="{{csrf_token()}}">

@if($errors->any())
  <div class="alert alert-warning fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>@lang('warning') !</strong> : 
    {{$errors->first()}}
  </div>
@endif

<div id="plans" dir="ltr">
{!! $plan_html !!}
</div>

<div class="container" id="loader" style="display: none;">
	
	<svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340">
		 <circle cx="170" cy="170" r="160" stroke="#4392F1"/>
		 <circle cx="170" cy="170" r="135" stroke="#DC493A"/>
		 <circle cx="170" cy="170" r="110" stroke="#E7F0FF"/>
     <circle cx="170" cy="170" r="85" stroke="#E3EBFF"/>
	</svg>
	
</div>

@endsection

@section('scripts')

<script src="https://www.paypal.com/sdk/js?client-id=AXa8kAmW6osPvSCXl_ClAaM2KkGsKXNJks3ttRxySwoAwTG5TfKF_NGs-a9Zz7l60mR9-K9DEqRTm0qu&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>

<script>

function notifyBackend(subscription,plan){

// show loader on screen whilst wating backend reply
$('#plans').hide();
$('#loader').show();

// notify the backend
$.post("{{route('lang.checkout',app()->getLocale())}}", {
    _token: "{{ csrf_token() }}",
    subscriptionID     : subscription,
    planID : plan
}, function( html ) {
  
// show thank you page to the user
$('#loader').hide();
$( "#plans" ).html(html);
$('.content-header h1').text('')
$('#plans').show();
},'html');

}

paypal.Buttons({
    style: {
        shape: 'rect',
        color: 'gold',
        layout: 'vertical',
        label: 'subscribe'
    },
    createSubscription: function(data, actions) {
      return actions.subscription.create({
        'plan_id': 'P-5M7067117B8503722L6I5B2Q'
      });
    },
    onApprove: function(data, actions) {
      notifyBackend(data.subscriptionID,'P-5M7067117B8503722L6I5B2Q');
    }
}).render('#plan0');

paypal.Buttons({
    style: {
        shape: 'rect',
        color: 'gold',
        layout: 'vertical',
        label: 'subscribe'
    },
    createSubscription: function(data, actions) {
      return actions.subscription.create({
        'plan_id': 'P-8HM887005N024444DL6I5HPY'
      });
    },
    onApprove: function(data, actions) {
      notifyBackend(data.subscriptionID,'P-8HM887005N024444DL6I5HPY');
    }
}).render('#plan1');

</script>

@endsection

