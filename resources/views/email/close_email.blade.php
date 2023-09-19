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

    @isset($close_case['creator_id'])
    <p>Creator Id:
        {{ $close_case['creator_id'] }}
    </p>
    @endisset

    @isset($close_case['reason_for_close'])
    <p>Reason For Close: {{ $close_case['reason_for_close'] }} </p>
    @endisset

    @isset($close_case['link'])
    <p>View this case <a href="">{{ $close_case['link'] }}</a> </p>
    @endisset

</body>

</html>