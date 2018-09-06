<html>
<head>
    <title>Ajax test</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{url('/bootstrap/bootstrap.min.css')}}" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href={{url("font-awesome/css/font-awesome.min.css")}}>
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 300;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .full-width{
            width: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;

        }

        .position-ref {
            position: relative;
        }

        .title {
            font-size: 40px;
            text-align: center;

        }

        form{
            width: 100%;
        }

        form #text-box{
            width: 90vh;
            margin: auto auto;
        }

        form #button{
            width: 40vh;
            margin: 15px auto;

        }

    </style>
    <script>
        {{--function loadData() {--}}
            {{--var request = new XMLHttpRequest();--}}
            {{--request.onreadystatechange=function () {--}}
                {{--if(this.readyState== 4 && this.status == 200){--}}
                   {{--var responseText = this.responseText;--}}
                   {{--var models=JSON.parse(responseText);--}}
                   {{--for(var counter in models) {--}}
                       {{--document.getElementById("container").innerHTML=models[counter].created_at;--}}
                   {{--}--}}
                {{--}--}}
            {{--};--}}
            {{--request.open("GET","{{ url('load') }}",true);--}}
            {{--request.send();--}}
        {{--}--}}

        function sendReq() {
            var request = new XMLHttpRequest();
            request.onreadystatechange=function () {
                if(this.readyState== 4 && this.status == 200){
                    document.getElementById("container").innerHTML='Your request has been Completed';
                }
            };

            request.open("POST","{{ url('report') }}",true);
            request.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
            request.setRequestHeader("Accept","text/plain");
            request.send();
            document.getElementById("container").innerHTML='Your request has been sent';
        }

//        setInterval(ajaxCall, 1000);
    </script>
</head>
<body>
    <div id="container">

    </div>
    <div class="flex-center position-ref full-height">

        {!! Form::open(['url' => 'report']) !!}

        <div  class="flex-center position-ref title">
            Welcome
        </div>

        <div class="form-group" id="text-box">
            {{ Form::text('url', null, ['class' => 'form-control','placeholder'=>'h t t p : / / y o u r s i t e . c o m / e x a m p l e']) }}
        </div>

        <div class="form-group" id="button">
            {{ Form::button('Check',['class' => 'btn btn-primary form-control','onclick' => 'sendReq()']) }}
        </div>

        {!! Form::close() !!}

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{url('/js/jquery-3.2.1.slim.min.js')}}" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="{{url('/js/popper.min.js')}}" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{url('/js/bootstrap.min.js')}}" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>