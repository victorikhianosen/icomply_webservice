<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>
    <div class="container-fluid">
        <div class="row text-center mt-5 d-block">
            @if(Session::has('this_error'))
            <div class="text-danger text-center justify-content-center">
                <strong>{{Session::get('this_error')}}</strong>
            </div>
            @endif

            
            

            @if(Session::has('this_error'))
            <div class="text-danger text-center justify-content-center">
                <strong>{{Session::get('this_error')}}</strong>
            </div>
            @endif
            <div class="col ">
                <div class="text-success text-center justify-content-center " id="msg">
                
                </div>
                Enter Case ID
                <form action="/api/send-case-id" method="get">
                    @csrf
                    <label for="getcase" class="m-3">
                        <input type="number" name="id" placeholder="enter case id" class=" form-control">
                        @error('id')
                        <strong class="text-danger"> {{$message}}</strong>
                        @enderror

                    </label>
                    <input type="submit" name="" id="" value="submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="{{asset('/js/app.js')}}"></script>
    <script>
        // Get the value of the 'message' parameter from the URL
            var urlParams = new URLSearchParams(window.location.search);
            var message = urlParams.get('msg');
    
            // Display the message in the designated element
            var messageElement = document.getElementById('msg');
            if (messageElement && message) {
                messageElement.textContent = decodeURIComponent(message);

                setTimeout(function() {
                messageElement.textContent = ''; // Clear the message element
                }, 10000);
            };
    </script>

</body>

</html>