<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
   @isset($document_notification['title'])
       <h1>{{ $document_notification['title']}}</h1>
   @endisset 

   @isset($document_notification['update_title'])
<h1>{{ $document_notification['update_title']}}</h1>
@endisset
    
    @isset($document_notification['update_document'])
        <p>{{ $document_notification['update_document'] }}</p>
    @endisset

    @isset($document_notification['document'])
    <p>{{ $document_notification['document'] }}</p>
    @endisset

    @isset($document_notification['id'])
    <p>Process Id: {{ $document_notification['id'] }}</p>
    @endisset

    @isset($document_notification['link'])
    <p>View this document <a href="">{{ $document_notification['link'] }}</a> </p>
    @endisset

    @isset($document_notification['creator_id'])
    <p>Creator Id: {{ $document_notification['creator_id'] }} </p>
    @endisset

    @isset($document_notification['approver_id'])
    <p>Approver Id: {{ $document_notification['approver_id'] }} </p>
    @endisset


</body>

</html>