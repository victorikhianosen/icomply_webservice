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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="card-header" style="border: none;">
    <div class="containerr card" style="width: 40%;">
        <div class="row card-body card border">
            <div class="col">
                <div class="mt">
                    <img src="allfiles/Sterling_Logo.png" alt="" class="img-fluid img-responsive" width="170">
                </div>
                <table>
                    <tr>
                        <td colspan="2" style="border-right: none;font-weight: normal;">
                            <div>
                                <p><i>The exception below was raised on a transaction you processed or an activity within your scope of responsibility.</i></p>
                                <p><i>Please respond to the exception immediately, explaining the reason(s) behind it as well as what you are doing to prevent re-occurrence.</i> </p>
                                <p><i>Note: The exception will remain open and therefore count against you unless resolved.</i> </p>
                            </div>
                        </td>
                    </tr>
                    <div>
                        <div class="text-end">
                            <tr>
                                <td>Event Date</td>
                                <td>Value 1</td>
                            </tr>
                        </div>

                        <tr>
                            <td>ID</td>
                            <td>Value 2</td>
                        </tr>
                        <tr>
                            <td>Narration</td>
                            <td>Value 3</td>
                        </tr>
                        <tr>
                            <td>Severity Rating</td>
                            <td>Value 3</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>Value 3</td>
                        </tr>
                        <tr>
                            <td>Recommended Action</td>
                            <td>Value 3</td>
                        </tr>
                        <tr>
                            <td>Additional Details</td>
                            <td>Value 3</td>
                        </tr>
                    </div>

                    <tr>
                        <td class="employee-response">Employee Response</td>
                        <td class="employee-response">Value 3nhh</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-right: none;">
                            <div class="mt-5">
                                <h5 class=""> Required Action</h5>
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