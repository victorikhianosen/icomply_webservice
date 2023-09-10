<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>{{ $process_notification['title']}}</h1>
    
    @isset($process_notification['newprocess'])
        <p>{{ $process_notification['newprocess'] }}</p>
    @endisset
    <p>{{ $process_notification['newprocess'] }}</p>

    @isset($process_notification['link'])
    <p>View this case <a href="">{{ $case_notification['link'] }}</a> </p>
    @endisset

    @isset($process_notification['creator_id'])
    <p>Creator Id: {{ $process_notification['creator_id'] }} </p>
    @endisset


</body>

</html>