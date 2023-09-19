<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>{{ $case_notification['title']}}</h1>
    <p>{{ $case_notification['body'] }}</p>
    
    @isset($case_notification['link'])
        <p>View this case <a href="">{{ $case_notification['link'] }}</a> </p>
    @endisset 
    
    @isset($creator_id)
        <p>Responder Id: {{ $email_info['responder_id'] }} </p>
    @endisset


</body>

</html>