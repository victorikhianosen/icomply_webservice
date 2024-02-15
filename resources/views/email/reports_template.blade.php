<!DOCTYPE html>
<html>

<head>
    <style>
        .card-dark {
            background-color: #333;
            color: #fff;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="">
        <div class="">
            <div class="row card-body px-3">
                <div class="col">
                    <div class="mb-2">
                        <img src="http://139.59.186.114/icomply_webservice/public/allfiles/Fkpkq5xyDmglUjE8WcLQlxVVGgp1fD7gXBGZSLkj.png"
                            alt="" class="img-fluid img-responsive" width="170">
                    </div>
                    <div class="mt-5"><b>Alert Id</b>: {{$report['exceptionName']}} </div>
                    <p class="mt-4"><b>Narration</b> : {{$report['Narration']}}</p>
                    <table class="table table-striped table-hover table-responsive table-bordered mt-1">
                        <thead>
                            <tr>
                                @foreach ($report['validResults'][0][0] as $key => $value)
                                <th scope="col" class="text-danger">{{ $key }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report['validResults'][0] as $row)
                            <tr>
                                @foreach ($row as $key => $value)
                                <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>