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
    <div class="row justify-content-center">
        <div class="col-sm-10 m-3 table-responsive">
            <h4 class="text-center m-3">Case Details</h4>
            <table class="table table-hover table-striped">
                <thead class="table-dark ">
                    <tr>
                        <th>Case Id</th>
                        <th>Creator</th>
                        <th>Case Status</th>
                        <th>Description</th>
                        <th>Narration</th>
                        <th>Created At</th>


                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>{{$case->id}}</td>
                        <td>{{$case->user->full_name}}</td>
                        <td> @if ($case->case_status_id ==1)
                            opened

                            @else
                            closed
                            @endif</td>
                        <td>{{$case->description}}</td>
                        <td>{{$case->narration}}</td>
                        <td>{{$case->created_at}}</td>

                    </tr>

                </tbody>
            </table>
        </div>
        <div class="text-center mt-5 text-decoration-none">
            <h2>Close Case</h2>
            <form action="/close-this-case/{{$case->id}}" method="post">
                @csrf
                <ul class="m-3" style="list-style-type: none">
                    <li>
                        <label class="m-2 text-align-center" for="reason_for_close">
                            Why do you want to close this case? <textarea name="reason_for_close" cols="40"
                                rows="3"></textarea>
                            @error('reason_for_close')
                            <p class="text-danger"> {{$message}}</p>
                            @enderror
                        </label>
                    </li>
                    <li>
                        <label for="supervisor_name">
                            Supervisor Name <input type="text" name="supervisor_name">
                            @error('supervisor_name')
                            <p class="text-danger"> {{$message}}</p>
                            @enderror
                        </label>
                    </li>
                    <li>
                        <label for="" class="mt-4">
                            <input type="submit" class="btn btn-primary" value="close case">

                        </label>
                    </li>
                </ul>

            </form>
        </div>

    </div>

    <script src="{{asset('/js/app.js')}}"></script>

</body>

</html>