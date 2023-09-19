<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @isset($system['systemtitle'])
    <h1>{{ $system['systemtitle']}}</h1>
    @endisset


    @isset($system['system'])
    <p>{{ $system['system'] }}</p>
    @endisset

@isset($system['approver_id'])
<p>Approver Id: {{ $system['approver_id'] }} </p>
@endisset


    @isset($system['allocate_title'])
    <p>{{ $system['allocate_title'] }}</p>
    @endisset

    @isset($system['allocate'])
    <p>{{ $system['allocate'] }}</p>
    @endisset

    @isset($system['update_allocate_title'])
    <p>{{ $system['update_allocate_title'] }}</p>
    @endisset

    @isset($system['update_allocate'])
    <p>{{ $system['update_allocate'] }}</p>
    @endisset

    @isset($system['allocator'])
    <p> Allocator Id: {{ $system['allocator'] }} </p>
    @endisset


    @isset($system['link'])
    <p>View <a href="">{{ $system['link'] }}</a> </p>
    @endisset




</body>

</html>