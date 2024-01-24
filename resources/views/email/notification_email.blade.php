<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>{{ $close_case['title']}}</h1>
    <p>{{ $close_case['body'] }}</p>
    
    @isset($close_case['link'])
        <p>View this case <a href="">{{ $close_case['link'] }}</a> </p>
    @endisset 
    
    @isset($creator_id)
        <p>Responder Id: {{ $close_case['creator_id'] }} </p>
    @endisset


</body>

</html>