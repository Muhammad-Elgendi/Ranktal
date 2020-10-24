<div class="jumbotron text-center">
    <h1 class="display-3">Thank You!, {{$name}}</h1>
    <p class="lead">You are on <strong>{{$plan}}</strong> plan untill <strong>{{$end_date}}</strong>.</p>
    <p class="lead"><strong>Please check your email</strong> for further information.</p>
    <hr>
    <p>
    Having trouble? <a href="{{config('app.homepage')}}/contact-us">Contact us</a>
    </p>
    <p class="lead">
    <a class="btn btn-primary btn-sm" href="{{config('app.homepage')}}" role="button">Continue to homepage</a>
    </p>
</div>