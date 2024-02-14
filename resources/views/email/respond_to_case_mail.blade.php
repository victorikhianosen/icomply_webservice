<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            margin-top: 40px;
            margin-left: 0;

        }
        .space {
        padding-left: 10px
        }

        td {
            padding: 3px;
            font-weight: normal;
            word-wrap: break-word;

        }

        tr td:first-child {
            border-right: 1px solid #ccc;
            font-weight: bold;
            white-space: nowrap;
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
    <div class="containerr card" style="width:100%;">
        <div class="row card-body ">
            <div class="col">
                <div class="">
                    <img src="http://139.59.186.114/icomply_webservice/public/allfiles/Fkpkq5xyDmglUjE8WcLQlxVVGgp1fD7gXBGZSLkj.png"
                        alt="" class="img-fluid img-responsive" width="170">
                </div>
                <table>
                    <tr>
                        <td colspan="2" style="border-right: none;font-weight: normal;">
                            <div>
                                <p style="word-wrap: break-word;"><i>An exception initiated by
                                        @isset($update_case['user_email'])
                                       {{ $update_case['user_name'] }} ({{ $update_case['user_email'] }})
                                        @endisset has been responded to by <br> @isset($update_case['responder_name'])
                                        {{ $update_case['responder_name'] }} ({{ $update_case['responder_email'] }})
                                        @endisset. SEE details below:</i></p>

                            </div>
                        </td>
                    </tr>
                    <div>
                        <div>
                            <tr>
                                <td><b>Event Date</b></td>
                                <td class="space"> @isset($update_case['event_date'])
                                    {{ $update_case['event_date'] }}
                                    @else
                                    NULL
                                    @endisset
                                </td>
                            </tr>
                        </div>

                        <tr>
                            <td><b>Alert Id</b></td>
                            <td class="space">@isset($update_case['alert_name'])
                                {{ $update_case['alert_name'] }}
                                @else
                                NULL
                                @endisset </td>
                        </tr>
                        <tr>
                            <td><b>Title</b></td>
                            <td class="space">@isset($update_case['title'])
                                {{ $update_case['title'] }}
                                @else
                                NULL
                                @endisset </td>
                        </tr>
                        <tr>
                            <td><b>Department</b></td>
                            <td class="space">@isset($update_case['staff_dept'])
                                {{ $update_case['staff_dept'] }}
                                @else
                                NULL
                                @endisset </td>
                        </tr>
                        <tr>
                            <td><b>Rating</b></td>
                            <td class="space">@isset($update_case['rating_name'])
                                {{ $update_case['rating_name'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Exception Process</b></td>
                            <td class="space">@isset($update_case['exception_process'])
                                {{ $update_case['exception_process'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Exception Process Type</b></td>
                            <td class="space">@isset($update_case['process_type'])
                                {{ $update_case['process_type'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Exception Process Category</b></td>
                            <td class="space">@isset($update_case['process_category'])
                                {{ $update_case['process_category'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Status</b></td>
                            <td class="space">@isset($update_case['status_name'])
                                {{ $update_case['status_name'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Action</b></td>
                            <td class="space">@isset($update_case['case_action'])
                                {{ $update_case['case_action'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Response message</b></td>
                            <td class="space">@isset($update_case['response'])
                                {{ $update_case['response'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>

                    </div>


                    <tr>
                        <td colspan="2" style="border-right: none;">
                            <div class="mt-5">
                                <h5 class=""> Required Action</h5>
                                <p style="font-weight: normal;"><i> Please review and ensure compliance</i></p>
                                <p style="font-weight: normal;"><i>Please ensure 100% review of this exception.</i> </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="px-3">
        <a href="http://139.59.186.114:8080/ords/r/sterling/icomply/login">Login to iComply portal</a>
    </div>

</body>

</html>