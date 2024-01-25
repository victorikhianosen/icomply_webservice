<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            margin-top: 15px;
            margin-left: 0;

        }

        td {
            padding: 3px;
            font-weight: normal;

        }

        tr td:first-child {
            border-right: 1px solid #ccc;
            font-weight: bold;
            /* padding-right: 0px;
            padding-left: 0px; */

        }


        td.employee-response {
            padding-top: 20px;
        }

        .containerr {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="card-header" style="border: none;">
    <div class="containerr card" style="width:40%;">
        <div class="row card-body ">
            <div class="col">
                <div class="mt">
                    <img src="allfiles/Sterling_Logo.png" alt="" class="img-fluid img-responsive" width="170">
                </div>
                <table>
                    <tr>
                        <td colspan="2" style="border-right: none;font-weight: normal;">
                            <div>
                                <p><i>An exception initiated by {{ $close_case['user_email'] }} has been closed. see details below:</i></p>

                            </div>
                        </td>
                    </tr>
                    <div>
                        <div class="text-end">
                            <tr>
                                <td><b>Event Date</b></td>
                                <td> @isset($close_case['event_data'])
                                    {{ $close_case['event_data'] }}
                                    @else
                                    NULL
                                    @endisset
                                </td>
                            </tr>
                        </div>

                        <tr>
                            <td><b>ID</b></td>
                            <td>@isset($close_case['alert_name'])
                            {{ $close_case['alert_name'] }}
                            @else
                            NULL
                            @endisset </td>
                        </tr>
                        <tr>
                            <td><b>Title</b></td>
                            <td>@isset($close_case['title'])
                            {{ $close_case['title'] }}
                            @else
                            NULL
                            @endisset </td>
                        </tr>
                        <tr>
                            <td><b>Rating</b></td>
                            <td>@isset($close_case['rating_name'])
                            {{ $close_case['rating_name'] }}
                            @else
                            NULL
                            @endisset</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>@isset($close_case['status_name'])
                            {{ $close_case['status_name'] }}
                            @else
                            NULL
                            @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Action</b></td>
                            <td>@isset($close_case['case_action'])
                            {{ $close_case['case_action'] }}
                            @else
                            NULL
                            @endisset</td>
                        </tr>

                    </div>


                    <tr>
                        <td colspan="2" style="border-right: none;">
                            <div class="mt-5">
                                <h5 class=""><b>Required Action</b> </h5>
                                <p style="font-weight: normal;"><i> Please review and ensure compliance</i></p>
                                <p style="font-weight: normal;"><i>Please ensure 100% review of this exception.</i> </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</body>

</html>