<!DOCTYPE html>
<html>

<head>
    <style>
        body {}

        table {
            display: flex;
            border-collapse: collapse;
            width: 60%;
            margin-top: 25px;
            align-items: center;
            padding-left: 10px;
            flex-direction: column;
            margin: 0;
            justify-content: center;

        }

        td {
            padding: 8px;
        }

        td:first-child {
            border-right: 1px solid #ccc;
            font-weight: bold;
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
    <div>
        felkewke
        <img src="" alt="">
    </div>
    <table class="mt-1">
        <tr>
            <td colspan="2" style="border-right: none;">
                <div class="above">
                    <p style="font-weight: normal;">the exception below was raised on a transaction you processed or an activity within your scope of responsibility.
                    </p>
                    <p style="font-weight: normal;">please respond to the exception immediately, explaining the reason(s) behind it as well as what you are doing to prevent re-occurence.</p>
                    <p style="font-weight: normal;"><b style="color:red">Note</b>: the exception will reamain open and therefore count against you unless resolved</p>
                </div>
            </td>
        </tr>
        <tr>
            <td>Event Date</td>
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
        <tr>
            <td colspan="2" style="border-right: none;">

            </td>
        </tr>
    </table>
    <div class="unader">
        <h2 style="color:red">Required Action</h2>
        <p style="font-weight: normal;">Please review</p>
        <p style="font-weight: normal;">please ensure 100% review of this exception</p>
    </div>
</body>

</html>