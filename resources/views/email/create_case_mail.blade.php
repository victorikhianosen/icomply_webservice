<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            margin-top: 40px;
            margin-left: 0;

        }

        td {
            padding: 3px;
            font-weight: normal;
            word-wrap: break-word;

        }

        tr td:first-child {
            border-right: 1px solid #ccc;
            padding-left: 5px font-weight: bold;
            white-space: nowrap;
            /* padding-right: 0px;
            padding-left: 0px; */

        }

        .space {
            padding-left: 10px
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
    <div class="containerr card" style="width: 100%;">
        <div class="row card-body">
            <div class="col">
                <div class="mt">
                    <img src="http://139.59.186.114/icomply_webservice/public/allfiles/Fkpkq5xyDmglUjE8WcLQlxVVGgp1fD7gXBGZSLkj.png"
                        alt="" class="img-fluid img-responsive" width="170">
                </div>
                <table>
                    <tr>
                        <td colspan="2" style="border-right: none;font-weight: normal;">
                            <div class="mb-3">
                                <span style="word-wrap: break-word;"><i>The exception below was raised on a transaction
                                        you processed or an activity within your scope of responsibility.</i></span><br>
                                <span style="word-wrap: break-word;"><i>Please respond to the exception immediately,
                                        explaining the reason(s) behind it as well as what you are doing to prevent
                                        re-occurrence.</i> </span><br>
                                <span style="word-wrap: break-word;"><i>NOTE: The exception will remain open and
                                        therefore count against you unless resolved.</i> </span> <br>
                            </div>
                        </td>
                    </tr>
                    <div>
                        <div>
                            <tr>
                                <td><b>Event Date</b></td>
                                <td class="space">@isset($create_case['event_date'])
                                    {{ $create_case['event_date'] }}
                                    @else
                                    NULL
                                    @endisset</td>
                            </tr>
                        </div>

                        <tr>
                            <td><b>Alert Id</b> </td>
                            <td class="space">@isset($create_case['alert_name'])
                                {{ $create_case['alert_name'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Narration</b></td>
                            <td class="space">@isset($create_case['title'])
                                {{ $create_case['title'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Severity Rating</b> </td>
                            <td class="space">@isset($create_case['rating_name'])
                                {{ $create_case['rating_name'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Department</b></td>
                            <td class="space">@isset($create_case['staff_dept'])
                                {{ $create_case['staff_dept'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Status</b></td>
                            <td class="space">@isset($create_case['status_name'])
                                {{ $create_case['status_name'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Exception Process</b></td>
                            <td class="space">@isset($create_case['exception_process'])
                                {{ $create_case['exception_process'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Exception Process Type</b></td>
                            <td class="space">@isset($create_case['process_type'])
                                {{ $create_case['process_type'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Exception Process Category</b></td>
                            <td class="space">@isset($create_case['process_category'])
                                {{ $create_case['process_category'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Recommended Action</b> </td>
                            <td class="space">@isset($create_case['case_action'])
                                {{ $create_case['case_action'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                        <tr>
                            <td><b>Additional Details</b></td>
                            <td class="space">@isset($create_case['description'])
                                {{ $create_case['description'] }}
                                @else
                                NULL
                                @endisset</td>
                        </tr>
                    </div>

                    <tr>
                        <td class="employee-response"><b>Employee Response</b> </td>
                        <td class="employee-response"><a href=@isset($create_case['response_link'])
                                {{ $create_case['response_link'] }}
                                @else
                                NULL
                                @endisset>CLICK here to respond</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-right: none;">
                            <div class="mt-5">
                                <h5 class=""><b>Required Action</b> </h5>
                                <p style="font-weight: normal;"><i> Please review</i></p>
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