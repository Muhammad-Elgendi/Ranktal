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
  padding: 0;
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
width: 27.95%;
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
}

.plan-tier.callout h4 {
background-color: #DC493A;
}
.callout{
    padding: 0;
}

/*!!! Pricing */

</style>
@endsection


@section('content')


{!! $plan_html !!}

@endsection

@section('scripts')
<script src="https://www.paypal.com/sdk/js?client-id=AXa8kAmW6osPvSCXl_ClAaM2KkGsKXNJks3ttRxySwoAwTG5TfKF_NGs-a9Zz7l60mR9-K9DEqRTm0qu&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
<script>
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
   
            // show loader on screen whilst wating to redirect
            // $('.checkout-loader').addClass('active');
            
            // excute php script
            var EXECUTE_URL = "{{route('checkout')}}";
            // Authorize the transaction
            actions.order.capture().then(function(details) {
                // Call your server to validate and capture the transaction               
                return $.post(EXECUTE_URL, JSON.stringify({
                        subscriptionID     : data.orderID,
                        planID : 'P-5M7067117B8503722L6I5B2Q'
                    }), function( data ) {

                    $( "#pricing" ).html('<h1>'+ data + '</h1>');

                });     
            });
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
   
   // show loader on screen whilst wating to redirect
   // $('.checkout-loader').addClass('active');
   
   // excute php script
   var EXECUTE_URL = "{{route('checkout')}}";
   // Authorize the transaction
   actions.order.capture().then(function(details) {
       // Call your server to validate and capture the transaction               
       return $.post(EXECUTE_URL, JSON.stringify({
               subscriptionID     : data.orderID,
               planID : 'P-8HM887005N024444DL6I5HPY'
           }), function( data ) {

           $( "#pricing" ).html('<h1>'+ data + '</h1>');

       });     
   });
}
}).render('#plan1');



</script>

@endsection


@section('user-image',url('/img/user.png'))


@section('user-type',__('pro-plan'))