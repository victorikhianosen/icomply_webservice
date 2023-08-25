<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>{{ $email_info['title']}}</h1>
    <p>{{ $email_info['body'] }}</p>
    <p>{{ $email_info['name'] }}</p>
    <p>{{ $email_info['reason'] }}</p>

    <p>View this case <a href="">{{ $email_info['link'] }}</a> </p>


</body>

</html>