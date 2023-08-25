<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>
    <div class="row justify-content-center all">
        <div class="col-sm-10 m-3 table-responsive">
            <h4 class="text-center m-3">Case Details</h4>

            <table class="table table-hover table-striped text-center">
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody class="api-data">

                </tbody>


            </table>
        </div>

        <div class="api-error text-danger text-center" >
        </div>

    </div>

    <div class="text-danger text-center m-5" style="display: none" id="emptyMessage">
        <h1>CASE NOT FOUND!</h1>
    </div>

    <div class="text-center mt-5 text-decoration-none all">


        @if(Session::has('checkErr'))
        <div class="text-danger text-center justify-content-center">
            <strong>{{Session::get('checkErr')}}</strong>
        </div>
        @endif
        <form id="myForm">
            @csrf
            <h2>Close Case</h2>
            <ul class="m-3" style="list-style-type: none">
                <li>
                    <label class="m-2 text-align-center" for="reason_for_close">
                        Why do you want to close this case? <textarea name="reason_for_close" cols="40" rows="3"
                            id="reason_for_close" required></textarea>
                        @error('reason_for_close')
                        <p class="text-danger"> {{$message}} </p>
                        @enderror
                    </label>
                </li>
                <li>
                    <label for="" class="mt-4">
                        <input type="submit" class="btn btn-primary" id="submit-button" value="close case">

                    </label>
                </li>
            </ul>

        </form>

    </div>




    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            var currentDate = new Date(); // Create a new Date object with the current date and time

var currentYear = currentDate.getFullYear(); // Get the current year (4 digits)
var currentMonth = currentDate.getMonth() + 1; // Get the current month (0-11, so add 1)
var currentDay = currentDate.getDate(); // Get the current day of the month
var currentHour = currentDate.getHours(); // Get the current hour (0-23)
var currentMinute = currentDate.getMinutes(); // Get the current minute (0-59)
var currentSecond = currentDate.getSeconds(); // Get the current second (0-59)

// Format the values if you want to display them nicely (add leading zeros)
var formattedDate = currentYear + '-' + (currentMonth < 10 ? '0' : '') + currentMonth + '-' + (currentDay < 10 ? '0' : '') + currentDay;
var formattedTime = (currentHour < 10 ? '0' : '') + currentHour + ':' + (currentMinute < 10 ? '0' : '') + currentMinute + ':' + (currentSecond < 10 ? '0' : '') + currentSecond;
var emptyMessage = document.getElementById('emptyMessage');
            var token = '{{Session::get('token')}}';
            var id = '{{ $id }}';

            var keyMapping = {
            id:'Case ID',
             user_id: 'Creator ID',
             supervisor_name: 'Closer',
        case_status_id:'Case status ID',
         priority_level_id:'Priority Level ID',
        description:'Description',
        reason_for_close:'Reason For Close',
        created_at:'Date Created',


        // Add more mappings as needed
    };
            $.ajax({
                url: '/api/send/case/' + id,
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function (data) {
                    var tableBody = $('.api-data');
                    tableBody.empty();
                    if (Object.keys(data).length === 0) {
                        $('.all').hide()
                        emptyMessage.style.display = 'block';
                    }
                    if (data.case_status_id == 2 ) {
                        $('#myForm').hide(); // Hide the form
                    } else {
                        $('#myForm').show(); // Show the form
                    }

                    for (var key in data) {
                        var customKey = keyMapping[key] || key;
                        var value = data[key];
                        
                        if (key === 'created_at' && value == null ) {
                        value = formattedDate;
                     }
                     if (key === 'updated_at' ) {
                       continue;
                     } 
                        var row = '<tr><td>' + customKey + '</td><td>' + value + '</td></tr>';
                        tableBody.append(row);
                    }
                },
                error: function () {
                    $('.api-error').html('Failed to load API data.');
                }
            });      
            

             });


             $(document).ready(function () {
    // Click event for the submit button
    
        $("#myForm").submit(function(e){
        e.preventDefault();
        var id= '{{$id}}';
        var token = '{{ Session::get('token') }}'; // Get the token from Laravel session
        var dataToSend = {
            reason_for_close: $('#reason_for_close').val(),
            // Add more parameters as needed
        };

        $.ajax({
            url: '/api/case/closecase/'+ id,
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Laravel CSRF token
            },
            data: dataToSend,
            success: function (response) {
               var msg = response.message;
                var redirectUrl = 'http://127.0.0.1:8000/showcase?msg=' + encodeURIComponent(msg);
                window.location.href = redirectUrl;
            },
            error: function (error) {
                console.log('Error:', error);
                // Handle error response here
            }
        });
    });
});
    </script>
</body>

</html>