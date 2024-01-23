<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {

            justify-content: center;
            text-align: center;

        }

        table {
            display: flex;
            border-collapse: collapse;
            width: 100%;
            margin-top: 25px;
            align-items: center;
            /* padding-left: 100px;
            padding-right: 100px; */

            flex-direction: column;
            margin: 0;
            text-align: center;
        }

        td {
            padding: 5px;
            text-align: center;
            /* margin: 10px; */
        }

        td:first-child {
            border-right: 1px solid #ccc;
            font-weight: bold;
            padding-right: 120px;
        }

        td.employee-response {
            padding-top: 50px;
        }


        .under {
            margin-top: 25px;
            justify-content: left;
            /* Remove border from the under class */
        }

        .above {
            margin-bottom: 25px;
            justify-content: left;
            /* Remove border from the under class */
        }

        /* New class to remove border in the last td */
    </style>
</head>

<body>
    <div class="mt-2">
        <img src="allfiles/Sterling_Logo.png" alt="" class="img-fluid img-responsive" width="170">
    </div>
    <div class="container">
        <div class="row">
            <div class="mt-2" style="justify-content:end;">
                <p style="font-weight: normal;">the exception below was raised on a transaction you processed or an activity within your scope of responsibility.
                </p>
                <p style="font-weight: normal;">please respond to the exception immediately, explaining the reason(s) behind it as well as what you are doing to prevent re-occurence.</p>
                <p style="font-weight: normal;"><b style="color:red">Note</b>: the exception will reamain open and therefore count against you unless resolved</p>
            </div>
            <div class="col">
                <table class="mt-1">
                    <tr>
                        <td >Event Date</td>
                        <td>Value 1</td>
                    </tr>
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
                    <tr>
                        <td class="employee-response">Employee Response</td>
                        <td class="employee-response no-border">Value 3nhh</td>
                    </tr>
                    <!-- New row for paragraphs -->
                </table>
            </div>
            <div class="mt-4">
                <h2 style="color:red;">Required Action</h2>
                <p style="font-weight: normal;">Please review</p>
                <p style="font-weight: normal;">please ensure 100% review of this exception</p>
            </div>
        </div>
    </div>


</body>

</html>