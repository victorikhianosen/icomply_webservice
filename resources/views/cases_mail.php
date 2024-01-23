<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            flex-direction: column;
        }

        table {
            border-collapse: collapse;
            width: 60%;
            margin-top: 25px;
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

        /* New class to remove border in the last td */
    </style>
</head>

<body>
    <table class="mt-5">
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
                <div class="under">
                    <h2 class="color:red">Required Action</h2>
                    <p style="font-weight: normal;">Please review</p>
                    <p style="font-weight: normal;">please ensure 100% review of this exception</p>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>